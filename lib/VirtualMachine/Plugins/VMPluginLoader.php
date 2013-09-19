<?php
/*
        Virtual Machine plugin loader

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function vmInitPlugins($vm)
{
        vmLoadPlugins('Debug');
        vmLoadPlugins('Mechanism');

        $vm->instructionCallbacks=array();
        vmLoadPlugins('Instruction',$vm->instructionCallbacks);

        $vm->operandCallbacks=array();
        vmLoadPlugins('Operand',$vm->operandCallbacks);

        $vm->operatorCallbacks=array();
        $vm->binaryOperators=array();

        //store binary operators separately, because they are called with another signature
        //than other operators
        $pluginKeys=vmLoadPluginFolder('BinaryOperator','Operator',$vm->operatorCallbacks);

        //store an index of binary operators
        foreach($pluginKeys as $pluginKey)
        { 
                $vm->binaryOperators[$pluginKey]=$pluginKey;
        }

        //other operators
        vmLoadPlugins('Operator',$vm->operatorCallbacks);

        //builtin functions
        //functions are stored as variables, so initialize variables
        vmInstructionResetVariables($vm); 
        vmLoadPlugins('Function',$vm->variables,false);
}

function vmCleanRequireOnce($filePath)
{
        ob_start();
        require_once($filePath);
        ob_end_clean();
}

function vmIsValidPluginFileName($fileName)
{
        if($fileName=='.') return false;
        if($fileName=='..') return false;
        if(!preg_match('/.*\.php/',$fileName)) return false;
        return true;
}

function vmLoadPlugins($pluginTypePrefix,&$array=null,$enforceUpperCaseForPluginKeys=true)
{
        //default the folder to the function prefix
        vmLoadPluginFolder($pluginTypePrefix,$pluginTypePrefix,&$array,$enforceUpperCaseForPluginKeys);
}

function vmLoadPluginFolder($folder,$pluginTypePrefix,&$array=null,$enforceUpperCaseForPluginKeys=true)
{
        $pluginKeys=array();
        $pluginNames=vmLoadFolderFiles($folder);
        foreach($pluginNames as $pluginName)
        { 
                if($enforceUpperCaseForPluginKeys)
                        $pluginKey=strtoupper($pluginName);
                else $pluginKey=$pluginName;

                $pluginKeys[]=$pluginKey;
                $functionName="vm$pluginTypePrefix$pluginName";
                $array[$pluginKey]=$functionName;
        }
        return $pluginKeys;
}

function vmLoadFolderFiles($folder)
{
        $entries=array();
        $dirPath=dirname(__FILE__).'/'.$folder;
        $dir=dir($dirPath);
        $entry=$dir->read();
        while($entry!=false)
        {
                if(vmIsValidPluginFileName($entry)) 
                {
                        $filePath="$dirPath/$entry";
                        vmCleanRequireOnce($filePath);
                        $fileName=basename($filePath,'.php');

                        //do not register files starting with an underscore
                        if(substr($fileName,0,1)!='_')
                        {
                                $entries[]=$fileName;
                        }
                }
                $entry=$dir->read();
        }
        return $entries;
}
?>
