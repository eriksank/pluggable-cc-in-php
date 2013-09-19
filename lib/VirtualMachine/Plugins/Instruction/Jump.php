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
function vmInstructionJump($vm,$vmInstruction)
{
        if(array_key_exists($vmInstruction->value,$vm->labelInstructionNumbers))
        {
                $instructionNumber=$vm->labelInstructionNumbers[$vmInstruction->value];
                $vm->currentInstructionNumber=$instructionNumber;
        }
        else
        {
                vmInstructionError($vm,$vmInstruction,
                        "Undefined IL label '{$vmInstruction->value}'");                                        
        }
}
?>

