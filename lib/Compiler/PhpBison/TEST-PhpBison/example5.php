<?php
/*
	Phnom Penh, Cambodia, December 2011
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/

/*

Example grammar 5 and example input, parsed using the bison tables.

*/

ob_start();
require_once('../PhpLexer/LexerPattern.php');
require_once('../PhpLexer/PhpLexer.php');
require_once('../Parser.php');
ob_end_clean();

//prepare lexer pattern for test case
$lexerPattern=new LexerPattern();
$lexerPattern->addRule('A','a');
$lexerPattern->addRule('NUMBER','[0-9]+(\.[0-9]+)?');
$lexerPattern->addRule('MINUS','-');
$lexerPattern->addRule('PLUS','\+');
$lexerPattern->addRule('MULT','\*');
$lexerPattern->addRule('DIV','\/');
$lexerPattern->addRule('EXPONENTIATE','\^');
$lexerPattern->addRule('BRACKET_LEFT','\(');
$lexerPattern->addRule('BRACKET_RIGHT','\)');

//supply lexer pattern to lexer
$lexer=new PhpLexer($lexerPattern->regex());

//print detailed lexer report
$lexer->debugPrintLexerReport();

//prepare default reduce callback function
$defaultReduceCallback=function($ruleNumber,$terms)
                {
                        echo "- rule $ruleNumber: ";
                        Parser::debugPrintTree($terms);
                };

//prepare parser for test case
$bisonXmlGrammar=file_get_contents('example-grammars/testlr5.xml');
$parser=new Parser($bisonXmlGrammar);
$parser->setDefaultReduceCallback($defaultReduceCallback);

//prepare program text
$text='99*(12.99+5.1)';

//tokenize the program text
$lexer->lex($text);

//print detailed tokenization report
$lexer->debugPrintTextReport();

if($lexer->hasGaps())
{
        //There is no point in parsing, if the lexer has detected invalid tokens already.
        echo "Lexer error: aborting before parsing\n";
}
else
{
        echo "===PARSE TREE===\n\n";
        try
        {
                //parse the program text
                //the callback function will produce output every time a rule has been reduced
                //reduction of rule number 0, means that the entire program has been parsed

                $parser->parse($lexer);
        }
        catch (Exception $e)
        {
                //the parser throws errors.
                //the program text is invalid.
                echo "parser error: ". $e->getMessage() ."\n";
        }
}

