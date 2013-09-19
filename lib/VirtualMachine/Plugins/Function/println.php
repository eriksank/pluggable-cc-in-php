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
function vmFunctionprintln($vm,$vmInstruction,$args)
{
        vmAssertNumberOfFunctionArgs($vm,$vmInstruction,'println',$args,1);
        echo $args[0]."\n";
        return true;
}
?>

