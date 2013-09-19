<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _Continue implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($generator)
        {
                $generator->addToken('CONTINUE');
                $generator->addGrammarRule('statement: continue_statement');
                $generator->addGrammarRule('continue_statement: CONTINUE SEMICOLON');
        }

        function beforeLexing($compiler) 
        {
                $compiler->addLexerKeywordPatternRule(LEXER_PRIORITY_KEYWORD,'CONTINUE','continue');
        }

        function beforeParsing($compiler)
        {

                $compiler->associateRuleNumberForLHSSymbol('CONTINUE_STATEMENT','continue_statement');

                $compiler->registerNamedReduceCallback(
                        'CONTINUE_STATEMENT',
                        function($me,$stackStates)
                        {
                                $label=labelDescendStack($me,'labelPrefixForContinue');
                                if($label==null) $me->error("nothing to continue");
                                emitJump($me,$stackStates,$label->labelPrefixForContinue,$label->labelNumber);
                        }
                );
        }

}
?>
        
