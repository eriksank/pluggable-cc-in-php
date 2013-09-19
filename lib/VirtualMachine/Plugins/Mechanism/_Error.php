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
function vmInstructionError($vm,$vmInstruction,$msg)
{
        $symbol=$vmInstruction->symbol;
        $value=$vmInstruction->value;
        $Sourceline=$vmInstruction->lin;
        $col=$vmInstruction->col;
        $textLineNumber=$vmInstruction->textLineNumber;
        throw new Exception($msg.
                " at instruction '$symbol'".
                " on source line $Sourceline and column $col".
                " in IL line $textLineNumber");
}
?>

