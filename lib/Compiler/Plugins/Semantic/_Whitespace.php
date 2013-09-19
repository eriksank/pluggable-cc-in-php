<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _Whitespace implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($grammar) { }

        function beforeLexing($compiler)
        {
                $compiler->addlexerPatternRule(LEXER_PRIORITY_WHITESPACE,'WHITESPACE','\s+');
        }

        function beforeParsing($compiler) 
        {
                $compiler->lexer->purgeUnimportantSymbol('WHITESPACE');
        }
}
?>

