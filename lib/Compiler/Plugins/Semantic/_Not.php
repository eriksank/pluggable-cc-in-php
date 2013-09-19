<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _Not implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($generator) 
        {
                $generator->addPriority('NOT','left',PARSER_PRIORITY_COND_CONCAT);
                $generator->addGrammarRule('expression: NOT expression');
        }

        function beforeLexing($compiler)
        {
                $compiler->addlexerPatternRule(LEXER_PRIORITY_OPERATOR_SYMBOL,'NOT','!');                
        }

        function beforeParsing($compiler) 
        {
                $compiler->associateRuleNumberForRHSSymbol('NOT');
                $compiler->registerNamedReduceCallback(
                        'NOT',
                        function($me,$stackStates)
                        {
                                $stackState=$stackStates[0];
                                $stackState->token->symbol='NOT';
                                $stackState->token->value='!';
                                $me->emitOperator($me,$stackState,1);
                        }
                );
        }
}
?>

