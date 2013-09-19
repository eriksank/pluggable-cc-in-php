<?php
/*
	Phnom Penh, Cambodia, December 2011
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/

/*

The TextLines class, splits a file into lines, keeping track of the
start and end for each line number.

*/

class TextLine
{
        var $lineNumber=null;
        var $start=null;
        var $end=null;
        var $line=null;

        function __construct($lineNumber,$start,$end,$line)
        {
                $this->lineNumber=$lineNumber;
                $this->start=$start;
                $this->end=$end;
                $this->line=$line;
        }
}

class TextLines
{
        var $lines=null;

        function __construct($text)
        {
                $result=preg_match_all('/\n/',$text,$matches,PREG_SET_ORDER|PREG_OFFSET_CAPTURE);
                if($result===false) throw new Exception('cannot parse text into lines');
                $this->lines=array();
                $lineNumber=1;
                $start=0;
                $position=0;
                foreach($matches as $match)
                {
                        $value=$match[0][0];
                        $position=$match[0][1];
                        $end=$position-1;
                        //store line until newline
                        $line=substr($text,$start,$end-$start+1);
                        $this->lines[]=new TextLine($lineNumber,$start,$end,$line);
                        $start=$position+1;
                        $lineNumber++;
                }
                //handle last line
                $end=strlen($text)-1;
                if($position<=$end)
                {
                        if($position==$end) $line='';
                        else $line=substr($text,$position+1);
                        $this->lines[]=new TextLine($lineNumber,$position,$end,$line);                
                }
        }

        function textLineForAbsolutePosition($position)
        {
                for($i=0; $i<count($this->lines)-1; $i++)
                {
                        $line=$this->lines[$i];
                        $nextLine=$this->lines[$i+1];
                        if($position>=$line->start && $position<$nextLine->start) return $line;
                }
                //last line
                //any position beyond the last line's starting point, is on the last line
                $line=$this->lines[count($this->lines)-1];
                if($position>=$line->start) return $line;
        }
}

?>

