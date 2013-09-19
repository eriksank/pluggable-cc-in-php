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
function vmTypeName($value)
{
        if(is_bool($value)) return 'bool';
        else if(is_int($value)) return 'int';
        else if(is_float($value)) return 'float';
        else if(is_string($value)) return 'string';
        else return null;
}

function vmSupportedCastTypeNames($typeName)
{
        switch($typeName)
        {
                case 'bool': return true;
                case 'int': return true;
                case 'float': return true;
                case 'string': return true;
                default: return false;
        }
}

function vmOperatorCast($vm,$vmInstruction,$value1,$value2)
{
        $typeNameFrom=vmTypeName($value2);
        if(!vmSupportedCastTypeNames($typeNameFrom))
                        vmInstructionError($vm,$vmInstruction,
                                        "Cannot cast from type ".gettype($value2));
        $typeNameTo=$value1;
        if(!vmSupportedCastTypeNames($typeNameTo))
                        vmInstructionError($vm,$vmInstruction,
                                        "Cannot cast to type ".$typeNameTo);

        if($typeNameFrom==$typeNameTo)
        {
                //nothing to do
                return;
        }
        $conversionFunctionName=$typeNameFrom.'2'.ucfirst($typeNameTo);
        vmPushResult($vm,$value2);
        vmPushResult($vm,$conversionFunctionName);
        vmOperatorFunction_Call($vm,$vmInstruction);
}
?>

