<?php
/*
	Phnom Penh, Cambodia, December 2011
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/

/*

TEST: lexerPattern and Regexer

This script tests the lexerPattern and Regexer classes with examples

*/

//the commandline version of php outputs newlines outside the php
//markers verbatim. One solution is to discard all output before the program 
//actually starts.
ob_start();
require_once('../LexerPattern.php');
require_once('../Regexer.php');
ob_end_clean();

$lexerPattern=new LexerPattern();
//definitions
$lexerPattern->addDefinition('DIGIT','[0-9]');
$lexerPattern->addDefinition('LETTER','[a-zA-Z_]');
$lexerPattern->addDefinition('LETTER_OR_DIGIT','[a-zA-Z0-9_]');
$lexerPattern->addDefinition('ANY_CHAR_NOT_GREEDY','.*?');
$lexerPattern->addDefinition('ANY_CHAR_NOT_GREEDY_NO_NEWLINE','[^\n]*?');
$lexerPattern->addDefinition('FOLLOWED_BY_NEWLINE','?=\n');
$lexerPattern->addDefinition('QUOTE_SINGLE',"'");
$lexerPattern->addDefinition('QUOTE_DOUBLE','"');
$lexerPattern->addDefinition('SLASH_FORWARD','\/');
$lexerPattern->addDefinition('STAR','\*');
$lexerPattern->addDefinition('DOT','\.');

//rules
$lexerPattern->addRule('WHITESPACE','\s+');
$lexerPattern->addRule('IF','if');
$lexerPattern->addRule('THEN','then');
$lexerPattern->addRule('ELSE','else');
$lexerPattern->addRule('RBRACKET_L','\(');
$lexerPattern->addRule('RBRACKET_R','\)');
$lexerPattern->addRule('CBRACKET_L','\{');
$lexerPattern->addRule('CBRACKET_R','\}');
$lexerPattern->addRule('EQUALS','=');
$lexerPattern->addRule('IDENTIFIER','{LETTER}{LETTER_OR_DIGIT}*');
$lexerPattern->addRule('NUMBER_FLOAT','{DIGIT}+({DOT}{DIGIT}+)?');
$lexerPattern->addRule('NUMBER_INTEGER','{DIGIT}+');
$lexerPattern->addRule('STRING1','{QUOTE_DOUBLE}{ANY_CHAR_NOT_GREEDY}{QUOTE_DOUBLE}');
$lexerPattern->addRule('STRING2','{QUOTE_SINGLE}{ANY_CHAR_NOT_GREEDY}{QUOTE_SINGLE}');
$lexerPattern->addRule('COMMENT1','{SLASH_FORWARD}{SLASH_FORWARD}{ANY_CHAR_NOT_GREEDY_NO_NEWLINE}({FOLLOWED_BY_NEWLINE})');
$lexerPattern->addRule('COMMENT2','{SLASH_FORWARD}{STAR}{ANY_CHAR_NOT_GREEDY}{STAR}{SLASH_FORWARD}');

$example=<<<'EOD'
                        if (this) then {do_something} else {dont}
                        if(not this) then { do_something_else } // just a comment here
                        /* another comment,
                        over two lines */
                        &*@&*++ //these are illegal chars
                        //"these are" an 'embedded' string within a comment
                        /* these are keywords: if,then,else in a comment */
                        // this is punctuation: "()}{}{}"' in a comment
                        variable1="first string variable"
                        variable2='second string variable'
                        variable3=324342 //a integer
                        variable4=343.34 //a float
                        /* illegal chars */ :: @#@$ &&&

EOD;

$regexer=new Regexer();
$regexer->tokenizeAll($lexerPattern->regex(),$example);
$regexer->debugPrintLexerReport();
$regexer->debugPrintTextReport();

?>

