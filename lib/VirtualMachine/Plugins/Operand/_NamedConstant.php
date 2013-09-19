<?php
/*
        Virtual Machine constant handling support function

        The function is called with:
        $vm: a reference the virtual machine
        $vmInstruction: a reference to the instruction

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function vmPushNamedConstant($vm,$namedConstant)
{
        $vm->stack[]=new VMExpressionStackItem(
                false, //hasName
                null, //name
                true, //hasValue
                $namedConstant
        );
}
?>

