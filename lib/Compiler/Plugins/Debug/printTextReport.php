<?php
/*
        Compiler function. Prints the compiler compilation report

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function compilerDebugPrintTextReport($compiler)
{
        Regexer::debugPrintTokens('GAPS',$compiler->lexer->gaps);
}
?>

