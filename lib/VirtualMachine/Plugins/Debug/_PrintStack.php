<?php
/*
        Virtual Machine debug function

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function vmDebugPrintStack($vm)
{
        echo "------\n";
        echo "STACK:\n";
        foreach($vm->stack as $item)
        {
                $hasName=vmDebugBool2String($item->hasName);
                $hasValue=vmDebugBool2String($item->hasValue);                        
                if(is_callable($item->value)) echo "{$item->name}:[<function>]\n";
                else echo "[(hasName $hasName){$item->name}:(hasValue $hasValue){$item->value}]\n";
        }
}
?>

