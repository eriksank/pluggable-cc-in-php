<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _Cast implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($generator) 
        {
                $generator->addToken('TYPE_BOOL');
                $generator->addToken('TYPE_INT');
                $generator->addToken('TYPE_FLOAT');
                $generator->addToken('TYPE_STRING');
                $generator->addPriority('CAST','left',PARSER_PRIORITY_CAST);
                $generator->addGrammarRule('expression: cast expression %prec CAST');
                $generator->addGrammarRule('cast: BRACKET_LEFT type_name BRACKET_RIGHT');
                $generator->addGrammarRule('type_name: TYPE_BOOL');
                $generator->addGrammarRule('type_name: TYPE_INT');
                $generator->addGrammarRule('type_name: TYPE_FLOAT');
                $generator->addGrammarRule('type_name: TYPE_STRING');
        }

        function beforeLexing($compiler)
        {
                $compiler->addLexerKeywordPatternRule(LEXER_PRIORITY_KEYWORD,'TYPE_BOOL','bool');                
                $compiler->addLexerKeywordPatternRule(LEXER_PRIORITY_KEYWORD,'TYPE_INT','int');                
                $compiler->addLexerKeywordPatternRule(LEXER_PRIORITY_KEYWORD,'TYPE_FLOAT','float');                
                $compiler->addLexerKeywordPatternRule(LEXER_PRIORITY_KEYWORD,'TYPE_STRING','string');                
        }

        function beforeParsing($compiler) 
        {
                $compiler->associateRuleNumberForLHSSymbol('CAST','cast');
                $compiler->registerNamedReduceCallback(
                        'CAST',
                        function($me,$stackStates)
                        {
                                $embeddedStackStates=$stackStates[1]->token->value;
                                $embeddedStackStates[0]->token->symbol='TYPE';
                                emitOperand($me,$embeddedStackStates);
                        }
                );

                $compiler->associateRuleNumberForRHSSymbolAndNumberOfTerms('CAST_OPERATOR','cast',2);
                $compiler->registerNamedReduceCallback(
                        'CAST_OPERATOR',
                        function($me,$stackStates)
                        {
                                $embeddedStackStates=$stackStates[0]->token->value;
                                $stackState=$embeddedStackStates[0];
                                $stackState->token->symbol='CAST';
                                emitOperator($me,$stackState,2);
                        }
                );
        }
}
?>

