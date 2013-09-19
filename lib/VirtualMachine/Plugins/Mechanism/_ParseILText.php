<?php
/*
        Virtual Machine mechanism plugin

        Convention: vm+mechanism name

        The function is called with:
        $vm: a reference the virtual machine
        $vmILText: the IL program text

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function vmParseILText($vm,$ilText)
{
        //split the lines, depending on whether it's linux,windows, mac.
        $lines=preg_split('/(\n|\r\n|\r)/s',$ilText);

        //initialize label cache
        $vm->labelInstructionNumbers=array();

        //parse each line into an vmInstruction object
        $vm->vmInstructions=array();

        //some lines in the IL text are not instructions
        $textLineNumber=0; //text line numbers in the IL file
        $ilLineNumber=0; //instruction numbers in the instruction array loaded
        foreach($lines as $line)
        {
                $textLineNumber++;
                if($textLineNumber>3 && $line!="") //skip header
                {
                        //error messages must use the line number in the IL text
                        $vmInstruction=new VMInstruction($line,$textLineNumber);

                        if($vmInstruction->code=='LABEL')
                        {
                                //labels must use the line number of the instruction array
                                $vm->labelInstructionNumbers[$vmInstruction->value]=$ilLineNumber;
                        }

                        $vm->vmInstructions[]=$vmInstruction;
                        $ilLineNumber++;
                }
        }
}
?>

