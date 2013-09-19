<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _If implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($generator)
        {
                $generator->addToken('IF');
                $generator->addToken('ELSE');
                $generator->addGrammarRule('statement: if_statement');
                $generator->addGrammarRule('if_statement: if_clause else_clause');
                $generator->addGrammarRule('if_clause: if_condition block');
                $generator->addGrammarRule('if_condition: IF BRACKET_LEFT expression BRACKET_RIGHT');
                $generator->addGrammarRule('else_clause: ELSE block');
                $generator->addGrammarRule('else_clause: ');
                $generator->addExpectedShiftReduceConflicts(1);
        }

        function beforeLexing($compiler) 
        {
                $compiler->addLexerKeywordPatternRule(LEXER_PRIORITY_KEYWORD,'IF','if');
                $compiler->addLexerKeywordPatternRule(LEXER_PRIORITY_KEYWORD,'ELSE','else');
        }

        function beforeParsing($compiler)
        {
                $compiler->associateRuleNumberForLHSSymbol('IF_STATEMENT','if_statement');
                $compiler->associateRuleNumberForLHSSymbol('IF_CLAUSE','if_clause');
                $compiler->associateRuleNumberForLHSSymbol('IF_CONDITION','if_condition');

                $compiler->registerNamedReduceCallback(
                        'IF_CONDITION',
                        function($me,$stackStates)
                        {
                                pushLabel($me,'IF');
                                emitIfFalse($me,$stackStates,'ELSE');
                        }
                );

                $compiler->registerNamedReduceCallback(
                        'IF_CLAUSE',
                        function($me,$stackStates)
                        {
                                emitJump($me,$stackStates,'IF_END');
                                emitLabel($me,$stackStates,'ELSE');
                        }
                );

                $compiler->registerNamedReduceCallback(
                        'IF_STATEMENT',
                        function($me,$stackStates)
                        {
                                emitLabel($me,$stackStates,'IF_END');
                                popLabel($me);
                        }
                );
        }
}
?>

