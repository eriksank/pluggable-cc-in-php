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
function vmOperandTrue($vm,$vmInstruction)
{
        vmPushNamedConstant($vm,true);
}
?>

