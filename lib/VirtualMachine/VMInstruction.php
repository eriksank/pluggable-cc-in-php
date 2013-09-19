<?php
/*
        Virtual Machine instruction class

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
require_once(dirname(dirname(__FILE__)).'/Compiler/CompilerInstruction.php');
class VMInstruction extends CompilerInstruction
{
        var $textLineNumber=null;

        static function unEscapeNewlines($string)
        {
                /*
                        We escaped the tokens by turning a \ into a \\ and a newline into \n
                        Now we need to reverse this.

                        What if we read \\\\\n? What exactly is it? It is \\ \\ \n.
                        So, if we read an even sequence of backslashes, it is only a series of backlashes.
                        If we read an uneven sequence of backslashes, it is followed by an escape sequence.
                        In our case, it can only be followed by 'n': so: \n
                */

                $regexSlash='\\\\';
                $nl="{$regexSlash}n";
                $twoRegexSlashes=$regexSlash.$regexSlash;
                $regex="/((?P<nl>($twoRegexSlashes)*$nl)|(?P<s>($twoRegexSlashes)+))/";

                $result=preg_replace_callback(
                                $regex, 
                                function($matches)
                                {
                                        $is_match=function($matches,$key)
                                        {
                                                if(array_key_exists($key,$matches) && $matches[$key]!='')
                                                return true;
                                                else return false;
                                        };
                                        //uneven number of slashes
                                        if($is_match($matches,'nl'))
                                        {
                                                $value=$matches['nl'];
                                                $numSlashes=(strlen($value)-2)/2;
                                                return str_repeat('\\',$numSlashes)."\n";
                                        }
                                        //even number of slashes
                                        else if($is_match($matches,'s'))
                                        {
                                                $value=$matches['s'];
                                                $numSlashes = intval(strlen($value)/2);
                                                return str_repeat('\\',$numSlashes);
                                        }
                                        
                                }                
                                , $string
                        );
                return $result;
        }

        function __construct($line,$textLineNumber)
        {
                //there are 8 columns
                $lineParts=preg_split('/\|/',$line,8);

                //each column represents a field in the instruction object
                $this->code=trim($lineParts[0]);
                $this->args=intval(trim($lineParts[1]));
                $this->symbol=trim($lineParts[2]);
                $this->pos=intval(trim($lineParts[3]));
                $this->len=intval(trim($lineParts[4]));
                $this->lin=trim($lineParts[5]);
                $this->col=trim($lineParts[6]);
                //we must unescape the newlines in the value column
                $this->value=self::unEscapeNewLines($lineParts[7]);

                //handle integers and floats
                if($this->code=='PUSH_OPERAND' && $this->symbol=='NUMBER')
                {
                        if(intval($this->value)==floatval($this->value))
                        {
                                $this->value=intval($this->value);
                        }
                        else
                        {
                                $this->value=floatval($this->value);
                        }
                }

                //assign text line number
                $this->textLineNumber=$textLineNumber;
        }
}
?>
