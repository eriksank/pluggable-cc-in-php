<?php
/*
        Virtual Machine expression stack item

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class VMExpressionStackItem
{
        var $hasName; //true, if the stack item has a name
        var $name;
        var $hasValue; //true if the stack item has a value
        var $value;
        

        function __construct($hasName,$name,$hasValue,$value)
        {
                $this->hasName=$hasName;
                $this->name=$name;
                $this->hasValue=$hasValue;
                $this->value=$value;
        }
}
?>
