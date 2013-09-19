<?php
/*
        Compiler function. Prints the compiler configuration report

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function compilerDebugPrintConfigReport($compiler)
{
        $compiler->lexer->debugPrintLexerReport();
}
?>

