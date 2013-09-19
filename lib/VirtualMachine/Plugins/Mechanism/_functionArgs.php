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
function vmFunctionArgs($vm,$vmInstruction)
{
        //now pop the correct number of function arguments from the stack
        $args=array();
        for($i=1; $i<$vmInstruction->args; $i++)
        {
                $arg=vmPopItem($vm,$vmInstruction)->value;
                array_unshift($args,$arg);
        }
        return $args;
}
?>
