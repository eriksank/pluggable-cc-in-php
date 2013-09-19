<?php
/*
        Semantic compiler plugin

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class _Minus extends CompilerSemanticPluginBinaryOperator
{
        function __construct()
        {
                $this->tokenName='MINUS';
                $this->tokenValue='-';
                $this->operatorPriority=PARSER_PRIORITY_PLUS_MINUS;
        }

        function beforeParsing($compiler)
        {
                $compiler->associateRuleNumberForRHSSymbolAndNumberOfTerms($this->tokenName,$this->tokenName,3);
                $compiler->registerNamedReduceCallback($this->tokenName,'emitBinaryOperator');
        }
}
?>

