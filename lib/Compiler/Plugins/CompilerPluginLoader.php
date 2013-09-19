<?php
/*
        The compiler plugin loader

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
function compilerInitPlugins($compiler)
{
        compilerLoadPlugins('Debug');
        compilerLoadPlugins('Mechanism');
        compilerLoadPlugins('Emitter');
        compilerLoadSemanticPlugins($compiler);
}

function compilerIsValidPluginFileName($fileName)
{
        if($fileName=='.') return false;
        if($fileName=='..') return false;
        if(!preg_match('/.*\.php/',$fileName)) return false;
        return true;
}

function compilerCleanRequireOnce($filePath)
{
        ob_start();
        require_once($filePath);
        ob_end_clean();
}

function compilerLoadSemanticPlugins($compiler)
{       
        if($compiler!=null) $compiler->semanticPlugins=array();
        $dirPath=dirname(__FILE__).'/Semantic';
        $dir=dir($dirPath);
        $entry=$dir->read();
        while($entry!=false)
        {
                if(compilerIsValidPluginFileName($entry)) 
                {
                        $filePath="$dirPath/$entry";
                        compilerCleanRequireOnce($filePath);
                        $className=basename($filePath,'.php');
                        $plugin=new $className();
                        if($compiler!=null) $compiler->semanticPlugins[$className]=$plugin;
                }
                $entry=$dir->read();
        }
}

function compilerLoadPlugins($pluginType)
{       
        $dirPath=dirname(__FILE__).'/'.$pluginType;
        $dir=dir($dirPath);
        $entry=$dir->read();
        while($entry!=false)
        {
                if(compilerIsValidPluginFileName($entry)) 
                {
                        $filePath="$dirPath/$entry";
                        compilerCleanRequireOnce($filePath);
                }
                $entry=$dir->read();
        }
}
?>

