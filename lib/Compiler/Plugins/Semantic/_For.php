<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _For implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($generator)
        {
                $generator->addToken('FOR');
                $generator->addGrammarRule('statement: for_statement');
                $generator->addGrammarRule('for_statement: for_clause for_block');
                $generator->addGrammarRule('for_clause: FOR BRACKET_LEFT for_init_statements SEMICOLON '.
                        'for_condition SEMICOLON for_next_statements BRACKET_RIGHT');
                $generator->addGrammarRule('for_init_statements: for_statements');
                $generator->addGrammarRule('for_next_statements: for_statements');
                $generator->addGrammarRule('for_statements: for_statements COMMA expression');
                $generator->addGrammarRule('for_statements: expression');
                $generator->addGrammarRule('for_statements: ');
                $generator->addGrammarRule('for_condition: for_expression');
                $generator->addGrammarRule('for_expression: expression');
                $generator->addGrammarRule('for_expression:');
                $generator->addGrammarRule('for_block: block');
        }

        function beforeLexing($compiler) 
        {
                $compiler->addLexerKeywordPatternRule(LEXER_PRIORITY_KEYWORD,'FOR','for');
        }

        function beforeParsing($compiler)
        {
                $compiler->associateRuleNumberForLHSSymbol('FOR_INIT_STATEMENTS','for_init_statements');
                $compiler->associateRuleNumberForLHSSymbol('FOR_CONDITION','for_condition');
                $compiler->associateRuleNumberForLHSSymbol('FOR_NEXT_STATEMENTS','for_next_statements');
                $compiler->associateRuleNumberForLHSSymbol('FOR_BLOCK','for_block');


                $compiler->registerNamedReduceCallback(
                        'FOR_INIT_STATEMENTS',
                        function($me,$stackStates)
                        {
                                pushLabel($me,'FOR','FOR_END','FOR_BLOCK_LOOP_NEXT');
                                emitJump($me,$stackStates,'FOR_BLOCK_START');
                                emitLabel($me,$stackStates,'FOR_CONDITION');
                                emitInjectedOperand($me,
                                        $stackStates,
                                        'TRUE','true');
                        }
                );

                $compiler->registerNamedReduceCallback(
                        'FOR_CONDITION',
                        function($me,$stackStates)
                        {
                                emitIfTrue($me,$stackStates,'FOR_BLOCK_START');
                                emitJump($me,$stackStates,'FOR_END');
                                emitLabel($me,$stackStates,'FOR_BLOCK_LOOP_NEXT');
                        }
                );

                $compiler->registerNamedReduceCallback(
                        'FOR_NEXT_STATEMENTS',
                        function($me,$stackStates)
                        {
                                emitJump($me,$stackStates,'FOR_CONDITION');
                                emitLabel($me,$stackStates,'FOR_BLOCK_START');
                        }
                );

                $compiler->registerNamedReduceCallback(
                        'FOR_BLOCK',
                        function($me,$stackStates)
                        {
                                emitJump($me,$stackStates,'FOR_BLOCK_LOOP_NEXT');
                                emitLabel($me,$stackStates,'FOR_END');
                                popLabel($me);
                        }
                );

        }
}
?>

