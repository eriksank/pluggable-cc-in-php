<?php
/*
        Compiler bytecode emitter function

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function emitOperator($compiler,$stackState,$args)
{
        $instruction=CompilerInstruction::fromToken(
                $stackState->token,
                'EXEC_OPERATOR',
                $args); //it does not take arguments from the stack
        $compiler->emit($instruction);
}
?>

