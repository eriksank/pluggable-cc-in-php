<?php
/*
        Compiler bytecode emitter function

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function emitFunctionCall($compiler,$stackStates)
{
        $token=$stackStates[0]->token;
        $argCount=compilerCountListElements($stackStates,'arguments','argument');
        emitOperand($compiler,$stackStates);
        $instruction=CompilerInstruction::fromToken(
                        $token,
                        'EXEC_OPERATOR',
                        $argCount+1);
        $instruction->symbol='FUNCTION_CALL';
        $instruction->value='';
        $compiler->emit($instruction);                                
}
?>

