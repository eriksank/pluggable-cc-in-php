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
function vmExecInstruction($vm,$vmInstruction)
{
        //the code must exist. Otherwise, it's an error
        if(array_key_exists($vmInstruction->code,$vm->instructionCallbacks))
        {
                //retrieve the function associated with this vm instruction code
                $function=$vm->instructionCallbacks[$vmInstruction->code];

                if($vm->DEBUG) 
                {
                        echo 'executing:'.$vmInstruction->__toString();
                }

                //call the function
                $function($vm,$vmInstruction);
        }
        else
        {
                vmInstructionError($vm,$vmInstruction,
                        "Unknown IL instruction code: '{$vmInstruction->code}'");
        }

        //only for debugging
        if($vm->DEBUG)        
        {
                vmDebugPrintStack($vm);
                vmDebugPrintVariables($vm);
        }
}
?>

