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
function vmInstructionExec_Operator($vm,$vmInstruction)
{
        $operator=$vmInstruction->symbol;

        //check if the operator is registered
        if(array_key_exists($operator,$vm->operatorCallbacks))
                $function=$vm->operatorCallbacks[$operator];
        else vmInstructionError($vm,$vmInstruction,"Unknown operator '$operator'");

        //make sure there are enough items on the stack
        vmAssertMinimalStackSize($vm,$vmInstruction,$vmInstruction->args);

        //we distinguish between binary operators and others.
        //binary operators have a simplified handling
        if(array_key_exists($vmInstruction->symbol,$vm->binaryOperators))
        {
                //handle binary operators
                $expressionStackItem2=vmPopItem($vm,$vmInstruction);
                $expressionStackItem1=vmPopItem($vm,$vmInstruction);

                //item 1
                $hasValue1=$expressionStackItem1->hasValue;
                $value1=$expressionStackItem1->value;
                $name1=$expressionStackItem1->name;

                //item2
                $hasValue2=$expressionStackItem2->hasValue;
                $value2=$expressionStackItem2->value;       
                $name2=$expressionStackItem2->name;         

                //check for undefined values
                if(!$hasValue1) vmInstructionError($vm,$vmInstruction,"Undefined variable '$name1'");
                if(!$hasValue2) vmInstructionError($vm,$vmInstruction,"Undefined variable '$name2'");

                //call the operator function
                $function($vm,$vmInstruction,$value1,$value2);
        }
        else
        {
                //handle other operators
                $function($vm,$vmInstruction);
        }
}
?>

