<?php
/*
        The compiler plugin for operands

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class CompilerSemanticPluginOperand implements ICompilerSemanticPlugin
{
        var $tokenName=null;
        var $regex=null;
        var $lexerPriority=null;

        function onGeneratingGrammar($generator)
        {
                $generator->addToken($this->tokenName);
                $generator->addGrammarRule('expression: '.$this->tokenName);
        }

        function beforeLexing($compiler)
        {
                $compiler->addlexerPatternRule($this->lexerPriority,$this->tokenName,$this->regex);
        }

        function beforeParsing($compiler)
        {
                $compiler->associateRuleNumberForRHSSymbol($this->tokenName);
                $compiler->registerNamedReduceCallback($this->tokenName,'emitOperand');
        }
}
?>

