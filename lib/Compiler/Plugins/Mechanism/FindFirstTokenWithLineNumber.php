<?php
/*
        Compiler mechanism function. Searches for the first token with a line number.

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function compilerFindFirstTokenWithLineNumber($stackStates)
{
        foreach($stackStates as $stackState)
        {
                if($stackState->token->lineNumber==0)
                {
                        return compilerFindFirstTokenWithLineNumber($stackState->token->value);
                }
                else
                {
                        return $stackState->token;
                }
        }
        return null;
}
?>

