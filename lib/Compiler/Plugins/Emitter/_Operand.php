<?php
/*
        Compiler bytecode emitter function for operands

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function emitOperand($compiler,$stackStates)
{
        $compiler->emit(CompilerInstruction::fromToken(
                $stackStates[0]->token,
                'PUSH_OPERAND',
                '')); //it does not take arguments from the stack                                
}
?>

