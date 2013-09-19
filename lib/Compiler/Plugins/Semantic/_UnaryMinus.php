<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _UnaryMinus implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($generator) 
        {
                $generator->addPriority('UNARY','left',PARSER_PRIORITY_UNARY);
                $generator->addGrammarRule('expression: MINUS expression %prec UNARY');
        }

        function beforeLexing($compiler) { }

        function beforeParsing($compiler) 
        {
                $compiler->associateRuleNumberForRHSSymbolAndNumberOfTerms('UNARY_MINUS','MINUS',2);
                $compiler->registerNamedReduceCallback(
                        'UNARY_MINUS',
                        function($me,$stackStates)
                        {
                                $stackState=$stackStates[0];
                                $stackState->token->symbol='UNARY_MINUS';
                                $stackState->token->value='-';
                                emitOperator($me,$stackState,1);
                        }
                );
        }
}
?>

