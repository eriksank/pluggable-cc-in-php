<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _Null extends CompilerSemanticPluginOperand
{
        function __construct()
        {
                $this->tokenName='NULL';
                $this->regex='\bnull\b';
                $this->lexerPriority=LEXER_PRIORITY_KEYWORD;
        }
}
?>

