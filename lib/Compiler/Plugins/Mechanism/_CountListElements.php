<?php
/*
        Compiler mechanism function. Knows how to count the elements of 
        a list, contained in a parse tree.

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function compilerCountListElements($stackStates,$listName,$elementName)
{
        $count=0;
        foreach($stackStates as $stackState)
        {
                if($stackState->token->symbol==$elementName)
                {
                        $count++;
                }
                else if($stackState->token->symbol==$listName)
                {
                        $count+=compilerCountListElements($stackState->token->value,$listName,$elementName);
                }
        }
        return $count;
}
?>

