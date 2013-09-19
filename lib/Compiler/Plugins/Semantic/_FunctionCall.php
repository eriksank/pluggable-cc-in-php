<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _FunctionCall implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($generator)
        {
                $generator->addToken('COMMA');
                $generator->addGrammarRule('expression: function_expression');
                $generator->addGrammarRule('function_expression: IDENTIFIER BRACKET_LEFT arguments BRACKET_RIGHT');
                $generator->addGrammarRule('arguments: arguments COMMA argument');
                $generator->addGrammarRule('arguments: argument');
                $generator->addGrammarRule('arguments: ');
                $generator->addGrammarRule('argument: expression');
        }

        function beforeLexing($compiler) { }

        function beforeParsing($compiler)
        {
                $compiler->associateRuleNumberForLHSSymbol('FUNCTION_CALL','function_expression');
                $compiler->registerNamedReduceCallback(
                        'FUNCTION_CALL',
                        function($me,$stackStates)
                        {
                                emitFunctionCall($me,$stackStates);
                        }
                );
        }
}


?>

