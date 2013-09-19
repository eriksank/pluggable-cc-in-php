<?php
/*
        Compiler bytecode emitter support functions for labeled instructions

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
class LabelStackItem
{
        var $semantics=null; //for debugging
        var $labelNumber=null;
        var $labelPrefixForBreak=null;
        var $labelPrefixForContinue=null;
        var $subLabelNumber=null;


        function __construct($semantics,$labelNumber,$labelPrefixForBreak,$labelPrefixForContinue,$subLabelNumber=0)
        {
                $this->semantics=$semantics;
                $this->labelNumber=$labelNumber;
                $this->subLabelNumber=$subLabelNumber;
                $this->labelPrefixForBreak=$labelPrefixForBreak;
                $this->labelPrefixForContinue=$labelPrefixForContinue;
        }
}

function pushLabel($compiler,$semantics,$labelPrefixForBreak=null,$labelPrefixForContinue=null)
{
        //increment label number
        $compiler->lastLabelNumber++;
        //push it on the label-number stack
        $compiler->labelStack[]=
                new LabelStackItem($semantics,$compiler->lastLabelNumber,$labelPrefixForBreak,$labelPrefixForContinue);
}

function assertLastLabelStackItemExists($compiler)
{
        //watch out for empty stack
        if(count($compiler->labelStack)==0)
                $compiler->error('Illegal attempt to look up label number in empty stack');
}

function lastLabelIndex($compiler)
{
        return count($compiler->labelStack)-1;
}

function labelDescendStack($compiler,$stackItemFieldName)
{
        $labelIndex=lastLabelIndex($compiler);
        $label=lastLabelStackItem($compiler);
        while($label->$stackItemFieldName==null && $labelIndex>=0)
        {
                $labelIndex--;
                $label=$compiler->labelStack[$labelIndex];
        }
        return $label;
}

function lastLabelStackItem($compiler)
{
        assertLastLabelStackItemExists($compiler);
        return $compiler->labelStack[lastLabelIndex($compiler)];

}

function lastLabelNumber($compiler)
{
        return lastLabelStackItem($compiler)->labelNumber;
}

function lastSubLabelNumber($compiler)
{
        return lastLabelStackItem($compiler)->subLabelNumber;
}

function incSubLabelNumber($compiler)
{
        assertLastLabelStackItemExists($compiler);
        $compiler->labelStack[lastLabelIndex($compiler)]->subLabelNumber++;
}

function popLabel($compiler)
{
        assertLastLabelStackItemExists($compiler);
        array_pop($compiler->labelStack);
}
?>

