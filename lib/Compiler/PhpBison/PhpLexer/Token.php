<?php
/*
	Phnom Penh, Cambodia, December 2011
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/

/*

Token class

Stores a token with symbol, value, absolute character position the text (starting from 0),
line number (starting from 1) and column number within the line (starting from 1) 
*/

define('TOKEN_OUTPUT_FORMAT',"%-4s %-3s %-7s %-14s %-s\n");

class Token
{
        var $symbol=null;
        var $value=null;
        var $absolutePosition=null;
        var $lineNumber=null;
        var $columnNumber=null;

        function __construct($symbol,$value,$absolutePosition,$lineNumber,$columnNumber)
        {
                $this->symbol=$symbol;
                $this->value=$value;
                $this->absolutePosition=$absolutePosition;
                $this->lineNumber=$lineNumber;
                $this->columnNumber=$columnNumber;
        }

        function getMatchSymbol($match)
        {
                foreach($match as $key=>$value)
                {
                        if(is_string($key) && $value[0]!='') return $key;
                }
                return null;
        }

        static function FromPCREMatch($match,$textLines)
        {
                $symbol=self::getMatchSymbol($match);
                $value=$match[0][0];
                $position=$match[0][1];
                $textLine=$textLines->textLineForAbsolutePosition($position);
                $lineNumber=$textLine->lineNumber;
                $columnNumber=$position-$textLine->start+1;
                return new Token($symbol,$value,$position,$lineNumber,$columnNumber);                        
        }

        static function debugEscapeNewlines($string)
        {
                $string=str_replace("\\",'\\\\',$string);
                $string=str_replace("\n",'\n',$string);
                return $string;
        }

        static function debugPrintColumnHeadings()
        {
                printf(TOKEN_OUTPUT_FORMAT,'pos','len','lin/col','','');
        }

        function debugPrint()
        {
                $tokenLength=strlen($this->value);
                $value=self::debugEscapeNewlines($this->value);
                printf(TOKEN_OUTPUT_FORMAT,
                        $this->absolutePosition,
                        $tokenLength,
                        $this->lineNumber.'/'.$this->columnNumber,
                        $this->symbol,
                        $value);
        }
}

?>

