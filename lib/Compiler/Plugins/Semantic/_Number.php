<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _Number extends CompilerSemanticPluginOperand
{
        function __construct()
        {
                $this->tokenName='NUMBER';
                $this->regex='{MINUS}{IS_OPTIONAL}{DIGIT}{SOME}({DOT}{DIGIT}{SOME}){IS_OPTIONAL}';
                $this->lexerPriority=LEXER_PRIORITY_NUMBER;
        }
}
?>

