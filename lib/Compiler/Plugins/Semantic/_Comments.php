<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _Comments implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($grammar) { }

        function beforeLexing($compiler)
        {
                $compiler->addlexerPatternRule(LEXER_PRIORITY_COMMENT,'COMMENT1',
                        '{SLASH_FORWARD}{SLASH_FORWARD}{ANY_CHAR_LAZY_NO_NEWLINE}({FOLLOWED_BY}{NEWLINE})');
                $compiler->addlexerPatternRule(LEXER_PRIORITY_COMMENT,'COMMENT2',
                        '{SLASH_FORWARD}{STAR}{ANY_CHAR_LAZY}{STAR}{SLASH_FORWARD}');
        }

        function beforeParsing($compiler) 
        {
                $compiler->lexer->renameSymbol('COMMENT1','COMMENT');
                $compiler->lexer->renameSymbol('COMMENT2','COMMENT');
                $compiler->lexer->purgeUnimportantSymbol('COMMENT');
        }
}
?>

