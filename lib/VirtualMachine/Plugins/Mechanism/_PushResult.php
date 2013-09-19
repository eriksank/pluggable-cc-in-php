<?php
/*
        Virtual Machine mechanism plugin

        Convention: vm+mechanism name

        The function is called with:
        $vm: a reference the virtual machine
        $vmInstruction: a reference to the instruction
        (optionally other arguments)

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function vmPushResult($vm,$value)
{
        $vm->stack[]=new VMExpressionStackItem(false,null,true,$value);
}
?>
