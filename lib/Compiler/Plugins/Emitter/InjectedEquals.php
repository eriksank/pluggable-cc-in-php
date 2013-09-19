<?php
/*
        Compiler bytecode emitter function

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function emitInjectedEquals($compiler,$stackStates,$instructionValue)
{
        $token=compilerFindFirstTokenWithLineNumber($stackStates);
        $instruction=CompilerInstruction::fromToken(
                $token,
                'EXEC_OPERATOR',
                2); //2 arguments
        $instruction->symbol='EQ';
        $instruction->value=$instructionValue;
        $compiler->emit($instruction);
}
?>

