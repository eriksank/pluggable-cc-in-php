<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _Block implements ICompilerSemanticPlugin
{
        function onGeneratingGrammar($generator) 
        {
                $generator->addToken('CBRACKET_LEFT');
                $generator->addToken('CBRACKET_RIGHT');
                $generator->addGrammarRule('block: statement');
                $generator->addGrammarRule('block: CBRACKET_LEFT block_statements CBRACKET_RIGHT');
                $generator->addGrammarRule('block: CBRACKET_LEFT CBRACKET_RIGHT');
                $generator->addGrammarRule('block_statements: block_statements block_statement');
                $generator->addGrammarRule('block_statements: block_statement');
                $generator->addGrammarRule('block_statement: statement');
        }

        function beforeLexing($compiler)
        {
                $compiler->addLexerPatternRule(LEXER_PRIORITY_PUNCTUATION,'CBRACKET_LEFT','\{');
                $compiler->addLexerPatternRule(LEXER_PRIORITY_PUNCTUATION,'CBRACKET_RIGHT','\}');
        }

        function beforeParsing($compiler) { }
}
?>

