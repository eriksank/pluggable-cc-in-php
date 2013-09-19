<?php
/*
        Compiler bytecode emitter function for operands

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function emitInjectedOperand($compiler,$stackStates,$symbol,$value)
{
        $token=compilerFindFirstTokenWithLineNumber($stackStates);
        $instruction=CompilerInstruction::fromToken(
                $token,
                'PUSH_OPERAND',
                ''); //it does not take arguments from the stack
        $instruction->symbol=$symbol;
        $instruction->value=$value;
        $compiler->emit($instruction);
}
?>

