<?php
/*
        The default lexer pattern for the compiler

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
require_once('PhpBison/PhpLexer/LexerPattern.php');

class CompilerLexerPattern extends LexerPattern
{
        function __construct()
        {
                parent::__construct();
                $this->initDefaultDefinitions();
        }

        function initDefaultDefinitions()
        {
                $this->addDefinition('ANY','*');
                $this->addDefinition('SOME','+');
                $this->addDefinition('IS_OPTIONAL','?');
                $this->addDefinition('WITH_NAME','?P');
                $this->addDefinition('MATCHING','?P=');
                $this->addDefinition('ANY_CHAR_LAZY','.*?');
                $this->addDefinition('ANY_CHAR_LAZY','.*?');
                $this->addDefinition('ANY_CHAR_LAZY_NO_NEWLINE','[^\n]*?');
                $this->addDefinition('ANY_CHAR_NO_NEWLINE','[^\n]*');
                $this->addDefinition('FOLLOWED_BY','?=');
                $this->addDefinition('PRECEDED_BY','?<=');
                $this->addDefinition('NOT_FOLLOWED_BY','?!');
                $this->addDefinition('NOT_PRECEDED_BY','?<!');
                $this->addDefinition('NEWLINE','\n');
                $this->addDefinition('DOT','\.');
                $this->addDefinition('STAR','\*');
                $this->addDefinition('SLASH_FORWARD','\/');
                $this->addDefinition('BACKSLASH','\\\\\\'); //disastrous escaping
                $this->addDefinition('MINUS','-');
                $this->addDefinition('DIGIT','\d'); //existing macro
                $this->addDefinition('ONE_TIME_ONLY',"{1}");
                $this->addDefinition('IDENTIFIER','\b[a-zA-Z_$][a-zA-Z0-9_$]*\b');
                $this->addDefinition('BRACKET_LEFT','\(');
                $this->addDefinition('BRACKET_RIGHT','\)');
                $this->addDefinition('WHITESPACE_OPTIONAL','\s*');

        }
}
?>
