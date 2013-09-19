<?php
/*
        Virtual Machine operator function plugin

        convention: vmOperator+operand type

        The function is called with:
        $vm: a reference the virtual machine
        $vmInstruction: a reference to the instruction

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function vmOperatorAssign($vm,$vmInstruction)
{
        //get two items from the stack
        $expressionStackItem2=vmPopItem($vm,$vmInstruction);
        $expressionStackItem1=vmPopItem($vm,$vmInstruction);

        //item 1
        $hasName1=$expressionStackItem1->hasName;
        $name1=$expressionStackItem1->name;
        $hasValue1=$expressionStackItem1->hasValue;
        $value1=$expressionStackItem1->value;

        //item 2
        $hasName2=$expressionStackItem2->hasName;
        $name2=$expressionStackItem2->name;
        $hasValue2=$expressionStackItem2->hasValue;
        $value2=$expressionStackItem2->value;

        //fix the error message (give a name value2 if possible)
        if($hasValue2) $msg2=" or '$value2' "; else $msg2=''; 

        //item 1 must have a name
        if(!$hasName1) vmInstructionError($vm,$vmInstruction,
                                "Cannot assign value of '$name2'$msg2".
                                " to variable '$value1'");

        //item 2 must have a value
        if(!$hasValue2) vmInstructionError($vm,$vmInstruction,
                                "Undefined value for variable '$name2'");

        //now we can assign
        $vm->variables[$name1]=$value2;
}
?>

