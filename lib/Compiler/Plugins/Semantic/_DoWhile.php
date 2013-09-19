<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _DoWhile implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($generator)
        {
                $generator->addToken('DO');
                $generator->addGrammarRule('statement: do_while_statement');
                $generator->addGrammarRule(
                        'do_while_statement: do_prefix block WHILE BRACKET_LEFT expression BRACKET_RIGHT SEMICOLON');
                $generator->addGrammarRule('do_prefix: DO');

        }

        function beforeLexing($compiler) 
        {
                $compiler->addLexerKeywordPatternRule(LEXER_PRIORITY_KEYWORD,'DO','do');
        }

        function beforeParsing($compiler)
        {
                $compiler->associateRuleNumberForLHSSymbol('DO_WHILE_STATEMENT','do_while_statement');
                $compiler->associateRuleNumberForLHSSymbol('DO_PREFIX','do_prefix');

                $compiler->registerNamedReduceCallback(
                        'DO_PREFIX',
                        function($me,$stackStates)
                        {
                                pushLabel($me,'DO WHILE','DO_END','DO_START');
                                emitLabel($me,$stackStates,'DO_START');
                        }
                );

                $compiler->registerNamedReduceCallback(
                        'DO_WHILE_STATEMENT',
                        function($me,$stackStates)
                        {
                                emitIfTrue($me,$stackStates,'DO_START');
                                emitLabel($me,$stackStates,'DO_END');
                                popLabel($me);
                        }
                );
        }
}
?>
