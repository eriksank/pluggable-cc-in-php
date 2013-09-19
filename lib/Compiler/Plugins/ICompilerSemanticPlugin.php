<?php
/*
        The interface for compiler semantic plugins

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/

//needed for the plugins themselves
require_once(dirname(dirname(__FILE__)).'/ParserOperatorPriorities.php');
require_once(dirname(dirname(__FILE__)).'/LexerPriorities.php');

interface ICompilerSemanticPlugin
{
        function onGeneratingGrammar($grammar);
        function beforeLexing($compiler);
        function beforeParsing($compiler);
}
?>

