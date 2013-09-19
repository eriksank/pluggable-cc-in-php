<?php
/*
	Phnom Penh, Cambodia, December 2011
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/

/*

PhpLexer class

The PhpLexer implements a ReadToken() method.

*/

require_once('ILexer.php');
require_once('Regexer.php');

class PhpLexer extends Regexer implements ILexer
{
        var $index=null;

        function __construct($lexerPattern)
        {
                $this->lexerPattern=$lexerPattern;
        }

        function lex($text)
        {
                $this->tokenizeAll($this->lexerPattern, $text);
                $this->index=0;
        }

        function eof()
        {
                if($this->index>=count($this->tokens))
                        return true;
                else return false;
        }

        function readToken()
        {
                if(!$this->eof())
                {
                        return $this->tokens[$this->index++];
                }
                else
                {
                        return null;
                }
        }
}

