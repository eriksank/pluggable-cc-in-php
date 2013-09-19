<?php
/*
        Virtual Machine instruction plugin function

        Convention: vmInstruction+instruction name

        The function is called with:
        $vm: a reference the virtual machine
        $vmInstruction: a reference to the instruction
        $branchCondition: true, for IF_TRUE, and FALSE, for IF_FALSE

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function vmInstructionBranchConditionally($vm,$vmInstruction,$branchCondition)
{
        //get condition result off the stack
        $expressionStackCondition=(bool)vmPopItem($vm,$vmInstruction)->value;
        vmInstructionReset_Stack($vm,$vmInstruction);
        //if condition fulfilled, then jump
        if(($branchCondition==$expressionStackCondition))
                vmInstructionJump($vm,$vmInstruction);
}
?>

