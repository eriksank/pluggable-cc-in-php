<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _Identifier extends CompilerSemanticPluginOperand
{
        function __construct()
        {
                $this->tokenName='IDENTIFIER';
                $this->regex='{IDENTIFIER}';
                $this->lexerPriority=LEXER_PRIORITY_IDENTIFIER;
        }
}
?>

