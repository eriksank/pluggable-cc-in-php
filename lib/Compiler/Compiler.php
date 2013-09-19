<?php
/*
        The main compiler script

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/

require_once('CompilerLexerPattern.php');
require_once('CompilerInstruction.php');

require_once('PhpBison/PhpLexer/PhpLexer.php');
require_once('PhpBison/Parser.php');

require_once('Plugins/CompilerPluginLoader.php');
require_once('Plugins/ICompilerSemanticPlugin.php');
require_once('Plugins/CompilerSemanticPluginBinaryOperator.php');
require_once('Plugins/CompilerSemanticPluginOperand.php');

class Compiler extends Parser
{
        const GRAMMAR_FILE='grammar.xml';

        var $lexer=null;
        var $lexerPatternRulesPrioritized=null;
        var $semanticPlugins=null;

        //output
        var $instructions=null;

        //label numbers
        var $labelStack=array();
        var $lastLabelNumber=0;

        function __construct()
        {
                $grammarFilePath=dirname(__FILE__).'/'.self::GRAMMAR_FILE;
                $bisonXmlGrammar=file_get_contents($grammarFilePath);
                parent::__construct($bisonXmlGrammar);
                compilerInitPlugins($this);
                $this->prepareLexer();
        }

        function prepareLexer()
        {
                $this->lexerPatternRulesPrioritized=array();
                $lexerPattern=new CompilerLexerPattern();
                $this->initDefaultLexerRules($lexerPattern);
                $this->addPluginLexerRules($lexerPattern);
                $this->lexer=new PhpLexer($lexerPattern->regex());
        }

        function initDefaultLexerRules()
        {
                $this->addLexerPatternRule(LEXER_PRIORITY_PUNCTUATION,'COMMA',',');
                $this->addLexerPatternRule(LEXER_PRIORITY_PUNCTUATION,'BRACKET_LEFT','{BRACKET_LEFT}');
                $this->addLexerPatternRule(LEXER_PRIORITY_PUNCTUATION,'BRACKET_RIGHT','{BRACKET_RIGHT}');
        }        


        function addLexerKeywordPatternRule($priority,$symbol,$keyword)
        {
                $this->addLexerPatternRule(1,$symbol,'\b'.$keyword.'\b');
        }

        function addLexerPatternRule($priority,$symbol,$regex)
        {
                //we use string as level key
                $levelKey='LEVEL_'.sprintf('%010d',$priority);

                //if the level key cannot be found, initialize the priority level
                if(!array_key_exists($levelKey,$this->lexerPatternRulesPrioritized))
                        $this->lexerPatternRulesPrioritized[$levelKey]=array();

                //add the rule to te correct priority level
                $this->lexerPatternRulesPrioritized[$levelKey][]=array('symbol'=>$symbol,'regex'=>$regex);
        }

        function addPluginLexerRules($lexerPattern)
        {
                //call the beforeLexing() method for all semantic plugins
                foreach($this->semanticPlugins as $plugin)
                {
                        $plugin->beforeLexing($this);
                }

                for($priorityLevel=1; $priorityLevel<10; $priorityLevel++)
                {
                        $levelKey='LEVEL_'.sprintf('%010d',$priorityLevel);
                        if(array_key_exists($levelKey,$this->lexerPatternRulesPrioritized))
                        {
                                $lexerPatternRulesForLevel=&$this->lexerPatternRulesPrioritized[$levelKey];

                                //use a callback to sort
                                usort($lexerPatternRulesForLevel,
                                        function($val1,$val2)
                                        {
                                                if(strlen($val1['regex'])>strlen($val2['regex'])) return -1;
                                                else return 1;
                                        }
                                );

                                //now add the regular expressions
                                foreach($lexerPatternRulesForLevel as $lexerPatternRule)
                                {
                                        $lexerPattern->addRule(
                                                $lexerPatternRule['symbol'],$lexerPatternRule['regex']);                        
                                }

                        }

                }
        }

        function emit($instruction)
        {
                $this->instructions[]=$instruction;
        }


        function compile($text)
        {
                //lex the program text
                $this->lexer->lex($text);

/*
                DEBUG

                compilerDebugPrintConfigReport($this);
                compilerDebugPrintFullTextReport($this);
*/
                 //if the program text has unrecognized gaps, don't even parse
                if($this->lexer->hasGaps())
                {
                        compilerDebugPrintTextReport($this);
                        $this->error("Lexer error: Unrecognized gaps. Aborting before parsing\n");
                }

                //call the beforeParsing() method for all semantic plugins
                foreach($this->semanticPlugins as $plugin)
                {
                        $plugin->beforeParsing($this);
                }

                //parse the text
                try
                {
                        $this->parse($this->lexer);
                }
                catch (Exception $e)
                {
                        $this->error("parser error: ". $e->getMessage() ."\n");
                }
        }
}
?>

