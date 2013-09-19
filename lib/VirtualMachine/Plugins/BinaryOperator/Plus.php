<?php
/*
        Virtual Machine operator

        Convention: vmOperator+operator name

        For binary operators, the VM already pops 2 elements from the stack
        and sends them through the function call

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function vmOperatorPlus($vm,$vmInstruction,$value1,$value2)
{
        vmPushResult($vm,$value1+$value2);
}
?>

