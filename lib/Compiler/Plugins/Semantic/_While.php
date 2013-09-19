<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _While implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($generator)
        {
                $generator->addToken('WHILE');
                $generator->addGrammarRule('statement: while_statement');
                $generator->addGrammarRule('while_statement: while_clause block');
                $generator->addGrammarRule('while_clause: while_prefix BRACKET_LEFT expression BRACKET_RIGHT');
                $generator->addGrammarRule('while_prefix: WHILE');
        }

        function beforeLexing($compiler) 
        {
                $compiler->addLexerKeywordPatternRule(LEXER_PRIORITY_KEYWORD,'WHILE','while');
        }

        function beforeParsing($compiler)
        {
                $compiler->associateRuleNumberForLHSSymbol('WHILE_STATEMENT','while_statement');
                $compiler->associateRuleNumberForLHSSymbol('WHILE_CLAUSE','while_clause');
                $compiler->associateRuleNumberForLHSSymbol('WHILE_PREFIX','while_prefix');

                $compiler->registerNamedReduceCallback(
                        'WHILE_PREFIX',
                        function($me,$stackStates)
                        {
                                pushLabel($me,'WHILE','WHILE_END','WHILE_START');
                                emitLabel($me,$stackStates,'WHILE_START');
                        }
                );

                $compiler->registerNamedReduceCallback(
                        'WHILE_CLAUSE',
                        function($me,$stackStates)
                        {
                                emitIfFalse($me,$stackStates,'WHILE_END');
                        }
                );

                $compiler->registerNamedReduceCallback(
                        'WHILE_STATEMENT',
                        function($me,$stackStates)
                        {
                                emitJump($me,$stackStates,'WHILE_START');
                                emitLabel($me,$stackStates,'WHILE_END');
                                popLabel($me);
                        }
                );
        }
}
?>

