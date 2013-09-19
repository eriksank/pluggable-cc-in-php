<?php
/*
	Phnom Penh, Cambodia, December 2011
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/

/*

ILexer interface

An ILexer reads tokens, returning the $end token in the end

*/

interface ILexer
{
        function readToken();
}

?>

