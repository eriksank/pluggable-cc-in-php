<?php
/*
        The instruction that the compiler generates

	Phnom Penh, Cambodia, December 2011
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
require_once('PhpBison/PhpLexer/Token.php');

class CompilerInstruction extends Token
{
        const INSTRUCTION_OUTPUT_FORMAT="%-14s|%-4s|%-14s|%-4s|%-3s|%-3s|%-7s|%-s\n";

        var $code=null;
        var $numArgs=null;

        function __construct($code,$numArgs,$symbol,$value,$absolutePosition,$lineNumber,$columnNumber)
        {
                $this->code=$code;
                $this->numArgs=$numArgs;
                $this->symbol=$symbol;
                $this->value=$value;
                $this->absolutePosition=$absolutePosition;
                $this->lineNumber=$lineNumber;
                $this->columnNumber=$columnNumber;
        }

        static function fromToken($token,$code,$numArgs)
        {
                $instruction=new CompilerInstruction
                (
                          $code
                        , $numArgs        
                        , $token->symbol
                        , $token->value
                        , $token->absolutePosition
                        , $token->lineNumber
                        , $token->columnNumber
                );
                return $instruction;
        }

        static function printColumnHeadings()
        {
                $text=self::columnHeadings();
                echo $text;
        }

        static function columnHeadings()
        {
                $buffer='';
                $buffer.=sprintf(self::INSTRUCTION_OUTPUT_FORMAT,'----','----','------','---','---','---','---','-----');
                $buffer.=sprintf(self::INSTRUCTION_OUTPUT_FORMAT,'code','args','symbol','pos','len','lin','col','value');
                $buffer.=sprintf(self::INSTRUCTION_OUTPUT_FORMAT,'----','----','------','---','---','---','---','-----');
                return $buffer;
        }

        static function unQuote($value)
        {
                if(substr($value,0,1)=='"' || substr($value,0,1)=="'") $value=substr($value,1,strlen($value)-1);
                if(substr($value,strlen($value)-1,1)=='"' || substr($value,strlen($value)-1,1)=="'") 
                                $value=substr($value,0,strlen($value)-1);
                return $value;
        }

        function __toString()
        {
                $tokenLength=strlen($this->value);
                $value=self::debugEscapeNewlines($this->value);
                if($this->symbol=='STRING') $value=self::unQuote($value);
                return sprintf(self::INSTRUCTION_OUTPUT_FORMAT,
                                        $this->code,
                                        $this->numArgs,
                                        $this->symbol,
                                        $this->absolutePosition,
                                        $tokenLength,
                                        $this->lineNumber,
                                        $this->columnNumber,
                                        $value
                                        );

        }

        function printInstruction()
        {
                echo $this->__toString();                
        }
}
?>

