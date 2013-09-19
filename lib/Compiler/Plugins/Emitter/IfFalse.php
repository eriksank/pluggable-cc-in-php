<?php
/*
        Compiler bytecode emitter function

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function emitIfFalse($compiler,$stackStates,$labelPrefix,$labelNumber=null, $subLabelNumber=null)
{
        emitLabeledInstruction($compiler,$stackStates,'IF_FALSE',$labelPrefix,$labelNumber, $subLabelNumber);
}
?>
