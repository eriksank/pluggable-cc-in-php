<?php
/*
        Virtual Machine operand function plugin

        convention: vmOperand+operand type

        The function is called with:
        $vm: a reference the virtual machine
        $vmInstruction: a reference to the instruction

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function vmOperatorFunction_Call($vm,$vmInstruction)
{
        //get function name off the stack
        $stackItem=vmPopItem($vm,$vmInstruction);
        $functionName=$stackItem->name;
        if($functionName==null) $functionName=$stackItem->value;
        //now pop the function arguments from the stack
        $args=vmFunctionArgs($vm,$vmInstruction);

        //if the function exists, call it with the arguments retrieved
        //otherwise, it's an undefined function
        if(array_key_exists($functionName,$vm->variables))
        {
                $function=$vm->variables[$functionName];
                vmPushResult($vm,$function($vm,$vmInstruction,$args));
        }
        else
        {
                vmInstructionError($vm,$vmInstruction,
                        "Undefined function '$functionName'");                                        
        }
}
?>

