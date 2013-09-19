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
function vmInstructionReturn($vm,$vmInstruction)
{
        if(count($vm->goSubStack)==0)
                vmInstructionError($vm,$vmInstruction,
                        "cannot return; sub routine stack is empty");

        $vm->currentInstructionNumber=array_pop($vm->goSubStack);
}
?>

