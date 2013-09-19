<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _Switch implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($generator)
        {
                $generator->addToken('SWITCH');
                $generator->addToken('COLON');
                $generator->addToken('CASE');
                $generator->addToken('DEFAULT');
                $generator->addGrammarRule('statement: switch_statement');
                $generator->addGrammarRule(
                        'switch_statement: switch_prefix switch_condition CBRACKET_LEFT switch_options CBRACKET_RIGHT');
                $generator->addGrammarRule(
                        'switch_statement: switch_prefix switch_condition CBRACKET_LEFT CBRACKET_RIGHT');
                $generator->addGrammarRule('switch_prefix: SWITCH');
                $generator->addGrammarRule('switch_condition: BRACKET_LEFT expression BRACKET_RIGHT');
                $generator->addGrammarRule('switch_options: switch_options switch_option');
                $generator->addGrammarRule('switch_options: switch_option');
                $generator->addGrammarRule('switch_option: switch_case_option');
                $generator->addGrammarRule('switch_option: switch_default_option');
                $generator->addGrammarRule('switch_case_option: case_prefix case_expression COLON statements');
                $generator->addGrammarRule('case_prefix: CASE');
                $generator->addGrammarRule('case_expression: expression');
                $generator->addGrammarRule('switch_default_option: default_prefix COLON statements');
                $generator->addGrammarRule('default_prefix: DEFAULT');
        }

        function beforeLexing($compiler) 
        {
                $compiler->addLexerKeywordPatternRule(LEXER_PRIORITY_KEYWORD,'SWITCH','switch');
                $compiler->addLexerPatternRule(LEXER_PRIORITY_PUNCTUATION,'COLON',':');
                $compiler->addLexerKeywordPatternRule(LEXER_PRIORITY_KEYWORD,'CASE','case');
                $compiler->addLexerKeywordPatternRule(LEXER_PRIORITY_KEYWORD,'DEFAULT','default');
        }

        function beforeParsing($compiler)
        {
                $compiler->associateRuleNumberForLHSSymbol('SWITCH_STATEMENT','switch_statement');
                $compiler->associateRuleNumberForLHSSymbol('SWITCH_PREFIX','switch_prefix');
                $compiler->associateRuleNumberForLHSSymbol('SWITCH_CONDITION','switch_condition');
                $compiler->associateRuleNumberForLHSSymbol('CASE_PREFIX','case_prefix');
                $compiler->associateRuleNumberForLHSSymbol('CASE_EXPRESSION','case_expression');
                $compiler->associateRuleNumberForLHSSymbol('DEFAULT_PREFIX','default_prefix');

                $compiler->registerNamedReduceCallback(
                        'SWITCH_PREFIX',
                        function($me,$stackStates)
                        {
                                pushLabel($me,'SWITCH','SWITCH_END');
                                emitJump($me,$stackStates,'SWITCH_CASE',lastLabelNumber($me),lastSubLabelNumber($me)+1);
                                emitLabel($me,$stackStates,'SWITCH_START');
                        }
                );

                $compiler->registerNamedReduceCallback(
                        'SWITCH_CONDITION',
                        function($me,$stackStates)
                        {
                                emitReturn($me,$stackStates);
                        }
                );

                $compiler->registerNamedReduceCallback(
                        'CASE_PREFIX',
                        function($me,$stackStates)
                        {
                                incSubLabelNumber($me);
                                emitLabel($me,$stackStates,'SWITCH_CASE',lastLabelNumber($me),lastSubLabelNumber($me));
                                emitGoSub($me,$stackStates,'SWITCH_START');
                        }
                );

                $compiler->registerNamedReduceCallback(
                        'CASE_EXPRESSION',
                        function($me,$stackStates)
                        {
                                emitInjectedEquals($me,$stackStates,'case');
                                emitIfFalse($me,$stackStates,
                                        'SWITCH_CASE',lastLabelNumber($me),lastSubLabelNumber($me)+1);                                
                        }
                );

                $compiler->registerNamedReduceCallback(
                        'DEFAULT_PREFIX',
                        function($me,$stackStates)
                        {
                                emitLabel($me,$stackStates,'SWITCH_CASE',lastLabelNumber($me),
                                        lastSubLabelNumber($me)+1);
                                incSubLabelNumber($me);
                        }
                );

                $compiler->registerNamedReduceCallback(
                        'SWITCH_STATEMENT',
                        function($me,$stackStates)
                        {
                                incSubLabelNumber($me);
                                emitLabel($me,$stackStates,'SWITCH_CASE',lastLabelNumber($me),
                                        lastSubLabelNumber($me));
                                emitLabel($me,$stackStates,'SWITCH_END');
                                popLabel($me);
                        }
                );

        }
}
?>

