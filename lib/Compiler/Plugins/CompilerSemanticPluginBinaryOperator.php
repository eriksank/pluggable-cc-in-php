<?php
/*
        The compiler plugin for binary operators

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class CompilerSemanticPluginBinaryOperator implements ICompilerSemanticPlugin
{
        var $tokenName=null;
        var $tokenValue=null;
        var $associativity='left';
        var $operatorPriority=null;

        function onGeneratingGrammar($generator)
        {
                $generator->addToken($this->tokenName);
                $generator->addPriority($this->tokenName,$this->associativity,$this->operatorPriority);
                $generator->addGrammarRule("expression: expression {$this->tokenName} expression");
        }

        function beforeLexing($compiler)
        {
                //watch out, preq_quote() does not escape the '/' symbol
                //but preg_match() will definitely fail for it
                if($this->tokenValue=='/') $quotedValue='\/';
                else $quotedValue=preg_quote($this->tokenValue);

                $compiler->addlexerPatternRule(LEXER_PRIORITY_OPERATOR_SYMBOL,$this->tokenName,$quotedValue);
        }

        function beforeParsing($compiler)
        {
                $compiler->associateRuleNumberForRHSSymbol($this->tokenName);                        
                $compiler->registerNamedReduceCallback($this->tokenName,'emitBinaryOperator');
        }
}
?>

