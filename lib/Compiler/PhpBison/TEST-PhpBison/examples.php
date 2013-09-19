<?php
/*
	Phnom Penh, Cambodia, December 2011
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/

/*

Example grammars and example input, parsed using the bison tables.

*/

ob_start();
require_once('../PhpLexer/LexerPattern.php');
require_once('../PhpLexer/PhpLexer.php');
require_once('../Parser.php');
ob_end_clean();

$testCases=array
(
                /* example 1 */
                array
                ( 
                         'title' => 'EXAMPLE 1'
                        ,'grammar-bison' => 'example-grammars/testlr1.y'
                        ,'grammar-xml' => 'example-grammars/testlr1.xml'
                        ,'lexer-symbols' => array('A'=>'a', 'B'=>'b')
                        , 'test-programs' =>
                                array
                                (
                                         array('text'=>'abb','correct'=>true)
                                        ,array('text'=>'abba','correct'=>false)
                                )
                ),

                /* example 2 */
                array
                ( 
                         'title' => 'EXAMPLE 2'
                        ,'grammar-bison' => 'example-grammars/testlr2.y'
                        ,'grammar-xml' => 'example-grammars/testlr2.xml'
                        ,'lexer-symbols' => array('a'=>'a', 'b'=>'b')
                        , 'test-programs' =>
                                array
                                (
                                         array('text'=>'abb','correct'=>true)
                                        ,array('text'=>'baa','correct'=>true) 
                                        ,array('text'=>'aaa','correct'=>false)
                                )
                )
                ,
                /* example 3 */
                array
                ( 
                         'title' => 'EXAMPLE 3'
                        ,'grammar-bison' => 'example-grammars/testlr3.y'
                        ,'grammar-xml' => 'example-grammars/testlr3.xml'
                        ,'lexer-symbols' => array('id'=>'[A-Za-z][A-Za-z0-9]*','equals'=>'=','deref'=>'\*')
                        , 'test-programs' =>
                                array
                                (
                                         array('text'=>'var1=var2','correct'=>true)
                                        ,array('text'=>'*var1=var2','correct'=>true) 
                                        ,array('text'=>'*var1=*var2','correct'=>true) 
                                        ,array('text'=>'var','correct'=>true) 
                                        ,array('text'=>'*var','correct'=>true) 
                                        ,array('text'=>'***var1=**var2','correct'=>true) 
                                        ,array('text'=>'var1=*','correct'=>false)
                                )
                )
                ,
                /* example 4 */
                array
                ( 
                         'title' => 'EXAMPLE 4'
                        ,'grammar-bison' => 'example-grammars/testlr4.y'
                        ,'grammar-xml' => 'example-grammars/testlr4.xml'
                        ,'lexer-symbols' => array('mult'=>'\*','plus'=>'\+','number'=>'[0-9]+(\.[0-9]+)?')
                        , 'test-programs' =>
                                array
                                (
                                         array('text'=>'4+3','correct'=>true) 
                                        ,array('text'=>'99*12+5.1','correct'=>true) 
                                        ,array('text'=>'65*12.1*45901','correct'=>true) 
                                        ,array('text'=>'+3','correct'=>false) 
                                        ,array('text'=>'343.12','correct'=>true)
                                        ,array('text'=>'23.1+*55','correct'=>false) 
                                        ,array('text'=>'101-','correct'=>false) //lexer error
                                        ,array('text'=>'101+','correct'=>false) //parser error
                                )
                )
                ,
                /* example 5 */
                array
                ( 
                         'title' => 'EXAMPLE 5'
                        ,'grammar-bison' => 'example-grammars/testlr5.y'
                        ,'grammar-xml' => 'example-grammars/testlr5.xml'
                        ,'lexer-symbols' => array
                                                (
                                                         'NUMBER'=>'[0-9]+(\.[0-9]+)?'
                                                        ,'MINUS'=>'-'
                                                        ,'PLUS'=>'\+'
                                                        ,'MULT'=>'\*'
                                                        ,'DIV'=>'\/'
                                                        ,'EXPONENTIATE'=>'\^'
                                                        ,'BRACKET_LEFT'=>'\('
                                                        ,'BRACKET_RIGHT'=>'\)'
                                                )
                        , 'test-programs' =>
                                array
                                (
                                         array('text'=>'5+4+3','correct'=>true) 
                                        ,array('text'=>'99*(12.99+5.1)','correct'=>true) 
                                        ,array('text'=>'65*(12.1/0.55-7)/((55*4)-1)^2','correct'=>true) 
                                        ,array('text'=>'2^(3-1+8)','correct'=>true)
                                        ,array('text'=>'-5^12','correct'=>true) 
                                        ,array('text'=>'+5^12','correct'=>true) 
                                        ,array('text'=>'101-','correct'=>false)
                                        ,array('text'=>'101+','correct'=>false)
                                        ,array('text'=>'(4+101','correct'=>false)
                                        ,array('text'=>'(4+101))-1','correct'=>false)
                                )
                )
);

define('VALID_MANUAL_OK_PARSER_OK','correctness of program text confirmed');
define('VALID_MANUAL_OK_PARSER_NOK','Program text deemed correct, recognized as correct');
define('VALID_MANUAL_NOK_PARSER_OK','Program text deemed incorrect, but not recognized as incorrect');
define('VALID_MANUAL_NOK_PARSER_NOK','Incorrectness of program text confirmed');

$defaultReduceCallback=function($ruleNumber,$terms)
                {
                        echo "- rule $ruleNumber: ";
                        Parser::debugPrintTree($terms);
                };

function lexerErrorMsg()
{
        echo "lexer error: there are unrecognized gaps in the text.\n";
        echo "lexer error: not parsing the tokens.\n";
}

function parserMsg($msg)
{
        echo "\n==> parser evaluation: $msg.\n";
}

foreach($testCases as $testCase)
{
        echo "\n==================================================\n";
        echo "===".$testCase['title']."===\n";
        echo "==================================================\n";

        //prepare lexer pattern for test case
        $lexerPattern=new LexerPattern();
        foreach($testCase['lexer-symbols'] as $symbol=>$regex)
        {
                $lexerPattern->addRule($symbol,$regex);
        }
        //supply lexer pattern to lexer
        $lexer=new PhpLexer($lexerPattern->regex());

        //print detailed lexer report
        $lexer->debugPrintLexerReport();

        //prepare parser for test case
        $bisonXmlGrammar=file_get_contents($testCase['grammar-xml']);
        $parser=new Parser($bisonXmlGrammar);
        $parser->setDefaultReduceCallback($defaultReduceCallback);

        //show grammar applied
        echo "===BISON GRAMMAR===\n\n";
        $bisonGrammar=file_get_contents($testCase['grammar-bison']);
        echo $bisonGrammar."\n";

        //analyze test case's program texts
        foreach($testCase['test-programs'] as $program)
        {
                $lexer->lex($program['text']);
                $lexer->debugPrintTextReport();
                if($lexer->hasGaps())
                {
                        lexerErrorMsg();
                }
                else
                {
                        echo "===PARSE TREE===\n\n";
                        try
                        {
                                $parser->parse($lexer);
                                if($program['correct']) parserMsg(VALID_MANUAL_OK_PARSER_OK);
                                else parserMsg(VALID_MANUAL_NOK_PARSER_OK);
                        }
                        catch (Exception $e)
                        {
                                echo "parser error: ". $e->getMessage() ."\n";
                                if($program['correct']) parserMsg(VALID_MANUAL_OK_PARSER_NOK);
                                else parserMsg(VALID_MANUAL_NOK_PARSER_NOK);
                        }
                }
        }        
}

