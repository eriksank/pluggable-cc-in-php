<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _SemiColon implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($generator)
        {
                $generator->addToken('SEMICOLON');
        }

        function beforeLexing($compiler)
        {
                $compiler->addlexerPatternRule(LEXER_PRIORITY_PUNCTUATION,'SEMICOLON',';');
        }

        function beforeParsing($compiler) 
        {
                $compiler->associateRuleNumberForLHSSymbol('SEMICOLON','expression_statement');
                $compiler->registerNamedReduceCallback(
                        'SEMICOLON',
                        function($me,$stackStates)
                        {
                                $me->emit(CompilerInstruction::fromToken(
                                        $stackStates[count($stackStates)-1]->token,
                                        'RESET_STACK',
                                        ''));                                
                        }
                );
        }
}
?>

