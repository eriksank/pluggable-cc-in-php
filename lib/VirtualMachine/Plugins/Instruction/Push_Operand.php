<?php
/*
        Virtual Machine instruction plugin function

        Convention: vmInstruction+instruction name

        The function is called with:
        $vm: a reference the virtual machine
        $vmInstruction: a reference to the instruction

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function vmInstructionPush_Operand($vm,$vmInstruction)
{
        $symbol=$vmInstruction->symbol;
        if(array_key_exists($symbol,$vm->operandCallbacks))
        {
                $function=$vm->operandCallbacks[$symbol];
                $function($vm,$vmInstruction);
        }
        else
        {
                vmInstructionError($vm,$vmInstruction,
                        "Unknown operand type: '$symbol'");                        
        }
}
?>

