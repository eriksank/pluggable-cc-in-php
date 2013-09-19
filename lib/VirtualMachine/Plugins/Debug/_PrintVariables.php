<?php
/*
        Virtual Machine debug function

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function vmDebugPrintVariables($vm)
{
        echo "------\n";
        echo "VARS:\n";
        echo "------\n";
        foreach($vm->variables as $key=>$value)
        {
                if(is_callable($value)) echo "$key:[<function>]\n";
                else echo "[$key:$value]\n";
        }
}
?>
