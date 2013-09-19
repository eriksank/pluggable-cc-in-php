<?php
/*
        Compiler bytecode emitter support functions for labeled instructions

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function emitLabeledInstruction($compiler,$stackStates,$instructionCode,$labelPrefix,$labelNumber=null, $subLabelNumber=null)
{
        if($labelNumber==null) $labelNumber=lastLabelNumber($compiler);
        $instruction=CompilerInstruction::fromToken(
                        compilerFindFirstTokenWithLineNumber($stackStates),
                        $instructionCode,
                        '');
        $instruction->symbol=''; //no symbol
        if($subLabelNumber==null)
        {
                $instruction->value="<{$labelPrefix}_{$labelNumber}>";
        }
        else
        {
                $instruction->value="<{$labelPrefix}_{$labelNumber}_{$subLabelNumber}>";
        }
        $compiler->emit($instruction);                                
}
?>

