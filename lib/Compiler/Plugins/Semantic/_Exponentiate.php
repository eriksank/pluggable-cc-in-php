<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _Exponentiate extends CompilerSemanticPluginBinaryOperator
{
        function __construct()
        {
                $this->tokenName='EXPONENTIATE';
                $this->tokenValue='^';
                $this->operatorPriority=PARSER_PRIORITY_EXPONENTIATE;
                $this->associativity='right';
        }
}
?>

