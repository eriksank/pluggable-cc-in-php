<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _Or extends CompilerSemanticPluginBinaryOperator
{
        function __construct()
        {
                $this->tokenName='OR';
                $this->tokenValue='||';
                $this->operatorPriority=PARSER_PRIORITY_COND_CONCAT;
        }
}
?>

