<?php
/*
	Phnom Penh, Cambodia, December 2011
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/

/*

TEST: Regexer

This script tests the TextLines class with an example

*/

//the commandline version of php outputs newlines outside the php
//markers verbatim. One solution is to discard all output before the program 
//actually starts.
ob_start();
require_once('../TextLines.php');
ob_end_clean();

$text="if (whatever) then 	{do_something} else {dont}\nIll be damned // some \"blabla\" comment \n".
        "if my friend else he /* does whatever he likes,\n no? if */".
        ' "this is an \'embedded /* // string\' with if and else and ()}{}{}" '.
        ' and \'this one\' with single quotes ' ;

$textLines=new TextLines($text);

foreach($textLines->lines as $line)
{
        echo "{$line->lineNumber} {$line->start}-{$line->end}: {$line->line}\n";
}
?>

