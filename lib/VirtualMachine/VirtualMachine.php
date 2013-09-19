<?php
/*
        The main Virtual Machine class

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
require_once('VMInstruction.php');
require_once('VMExpressionStackItem.php');
require_once('Plugins/VMPluginLoader.php');

class VirtualMachine
{
        var $vmInstructions=null; //the instructions to execute
        var $expressionStack=null; //the expression stack
        var $gosubStack=null; //the subroutine stack
        var $variables=null; //the variables stored in memory, including the functions
        var $labelInstructionNumbers=null; //IL instructions numbers for the labels
        var $currentInstructionNumber=null; //Current instruction number

        //vm instructions, operands, and operators
        var $instructionCallbacks=null; //all registered IL instructions
        var $operandCallbacks=null; //to handle the registered types of operands
        var $operatorsCallbacks=null; //all     registered operators

        //special index for binary operators
        var $binaryOperators=null; //all binary operators (called back with another signature)

        var $DEBUG=false;

        function __construct()
        {
                vmInitPlugins($this);
        }

        function run($ilText)
        {
                vmParseILText($this,$ilText);
                vmMainLoop($this);
        }
}
?>

