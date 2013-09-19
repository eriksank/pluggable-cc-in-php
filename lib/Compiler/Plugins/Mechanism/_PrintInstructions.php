<?php
/*
        Compiler mechanism function. Knows how to print the bytecode.

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function compilerPrintInstructions($compiler)
{
        CompilerInstruction::printColumnHeadings();
        foreach($compiler->instructions as $instruction)
        {
                $instruction->printInstruction();
        }
}

function compilerInstructions($compiler)
{
        $buffer=CompilerInstruction::columnHeadings();
        foreach($compiler->instructions as $instruction)
        {
                $buffer.=$instruction->__toString();
        }
        return $buffer;
}
?>
