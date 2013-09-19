<?php
/*
	Phnom Penh, Cambodia, December 2011
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/

/*

Regexer class

The LexerPattern class accepts definitions and rules.
It generates a PCRE regular expression from its definitions and rules.

*/

class LexerDefinition
{
        var $macro;
        var $replacement;
        
        function __construct($macro,$replacement)
        {
                $this->macro=$macro;
                $this->replacement=$replacement;
        }
}

class LexerRule
{
        var $symbol;
        var $regex;
        
        function __construct($symbol,$regex)
        {
                $this->symbol=$symbol;
                $this->regex=$regex;
        }

        function __toString()
        {
                return "(?P<{$this->symbol}>{$this->regex})";
        }
}

class LexerPattern
{

        var $lexerDefinitions=null;
        var $lexerRules=null;

        function __construct()
        {
                $this->lexerRules=array();
                $this->lexerDefinitions=array();
        }

        function addDefinition($macro,$replacement)
        {
                $this->lexerDefinitions[]=new LexerDefinition($macro,$replacement);
        }

        function addRule($symbol,$regex)
        {
                $this->lexerRules[]=new LexerRule($symbol,$regex);
        }

        function expandedLexerRules()
        {
                //if there are no lexer definitions, we don't need to do anything
                if(count($this->lexerDefinitions)==0) return $this->lexerRules;

                //assemble array of patterns and replacements
                $patterns=array();
                $replacements=array();
                foreach($this->lexerDefinitions as $lexerDefinition)
                {
                        $patterns[]='/\{'.$lexerDefinition->macro.'\}/';
                        $replacements[]=$lexerDefinition->replacement;
                }

                //expand regular expressions
                $lexerRegex=array();
                foreach($this->lexerRules as $lexerRule)
                {
                        $lexerRegex[]=$lexerRule->regex;
                }
                $expandedLexerRegexes=preg_replace($patterns,$replacements,$lexerRegex,-1);

                //create expanded rules
                $expandedLexerRules=array();
                for($i=0; $i<count($this->lexerRules); $i++)
                {
                        $lexerRule=$this->lexerRules[$i];
                        $expandedLexerRegex=$expandedLexerRegexes[$i];
                        $expandedLexerRules[]=new LexerRule($lexerRule->symbol,$expandedLexerRegex);
                }

                //return result
                return $expandedLexerRules;
        }

        function regex()
        {
                $regexStrings=array();
                foreach($this->expandedLexerRules() as $lexerRule)
                {
                        $regexStrings[]=$lexerRule->__toString();
                }
                $lexerPattern='/'.implode($regexStrings,'|').'/s';                
                return $lexerPattern;
        }
}
?>

