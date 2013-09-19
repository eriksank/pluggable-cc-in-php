<?php
/*
        Virtual Machine identifier handling support function

        The function is called with:
        $vm: a reference the virtual machine
        $vmInstruction: a reference to the instruction

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function vmPushIdentifier($vm,$vmInstruction)
{
        if(array_key_exists($vmInstruction->value,$vm->variables))
        {
                //if the variable exists, use its value.
                $hasValue=true;
                $value=$vm->variables[$vmInstruction->value];
        }
        else
        {
                //unknown identifier. May be assigned later on.
                $hasValue=false;
                $value=null;
        }
        $vm->stack[]=new VMExpressionStackItem(true,$vmInstruction->value, $hasValue,$value);
}
?>

