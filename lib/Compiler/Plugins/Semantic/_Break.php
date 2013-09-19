<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _Break implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($generator)
        {
                $generator->addToken('BREAK');
                $generator->addGrammarRule('statement: break_statement');
                $generator->addGrammarRule('break_statement: BREAK SEMICOLON');
        }

        function beforeLexing($compiler) 
        {
                $compiler->addLexerKeywordPatternRule(LEXER_PRIORITY_KEYWORD,'BREAK','break');
        }

        function beforeParsing($compiler)
        {
                $compiler->associateRuleNumberForLHSSymbol('BREAK_STATEMENT','break_statement');

                $compiler->registerNamedReduceCallback(
                        'BREAK_STATEMENT',
                        function($me,$stackStates)
                        {
                                $label=labelDescendStack($me,'labelPrefixForBreak');
                                if($label==null) $me->error("nothing to break out");
                                emitJump($me,$stackStates,$label->labelPrefixForBreak,$label->labelNumber);
                        }
                );
        }
}
?>

