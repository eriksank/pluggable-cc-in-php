<?php
/*
        Virtual Machine function plugin

        Convention: vmFunction+function name

        Will be called with a reference to the vm: $vm
                                a reference to the instruction that is executing the function call: $vmInstruction
                                the arguments to the function: $args

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function vmFunctionstring2Float($vm,$vmInstruction,$args)
{
        vmAssertNumberOfFunctionArgs($vm,$vmInstruction,'string2Float',$args,1);
        return floatval($args[0]);
}
?>

