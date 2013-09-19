<?php
/*
        Compiler bytecode emitter function for operands

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function emitReturn($compiler,$stackStates)
{
        $token=$stackStates[0]->token;
        $instruction=CompilerInstruction::fromToken(
                $stackStates[0]->token,
                'RETURN',
                '');  //no arguments
        $instruction->value='';
        $compiler->emit($instruction);                              
}
?>

