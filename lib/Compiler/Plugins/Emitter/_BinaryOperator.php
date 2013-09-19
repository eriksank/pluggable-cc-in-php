<?php
/*
        Compiler bytecode emitter function

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function emitBinaryOperator($compiler,$stackStates)
{
        $compiler->emit(CompilerInstruction::fromToken(
                $stackStates[1]->token,
                'EXEC_OPERATOR',
                2));  //2 arguments                              
}
?>

