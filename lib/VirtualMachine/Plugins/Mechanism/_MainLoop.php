<?php
/*
        Virtual Machine mechanism plugin

        Convention: vm+mechanism name

        The function is called with:
        $vm: a reference the virtual machine

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function vmMainLoop($vm)
{
        //initialize the expression stack
        vmInstructionReset_Stack($vm,null);

        //initialize the subroutine stack
        $vm->goSubStack=array();

        //start with the first instruction at the beginning of the array of instructions
        $vm->currentInstructionNumber=0;

        //count the total number of instructions
        $countInstructions=count($vm->vmInstructions);

        //loop until the last instruction has been reached
        while($vm->currentInstructionNumber<$countInstructions)
        {
                //take the next instruction
                $vmInstruction=$vm->vmInstructions[$vm->currentInstructionNumber];
                vmExecInstruction($vm,$vmInstruction);

                //move to the next instruction
                $vm->currentInstructionNumber++;
        }
}
?>

