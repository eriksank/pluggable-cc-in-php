<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _String implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($generator)
        {
                $generator->addToken('STRING');
                $generator->addGrammarRule('expression: STRING');
        }

        function beforeLexing($compiler)
        {
                $compiler->addlexerPatternRule(LEXER_PRIORITY_STRING,'STRING_DOUBLE',
                        '"'.'{ANY_CHAR_LAZY}({NOT_PRECEDED_BY}{BACKSLASH})'.'"');
                $compiler->addlexerPatternRule(LEXER_PRIORITY_STRING,'STRING_SINGLE',
                        "'".'{ANY_CHAR_LAZY}({NOT_PRECEDED_BY}{BACKSLASH})'."'");
        }

        function beforeParsing($compiler) 
        {
                $compiler->lexer->renameSymbol('STRING_SINGLE','STRING');
                $compiler->lexer->renameSymbol('STRING_DOUBLE','STRING');
                $compiler->associateRuleNumberForRHSSymbol('STRING');
                $compiler->registerNamedReduceCallback('STRING','emitOperand');
        }
}
?>

