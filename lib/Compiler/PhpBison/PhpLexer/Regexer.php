<?php
/*
	Phnom Penh, Cambodia, December 2011
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/

/*

Regexer class

The regexer class accepts definitions and rules.
It uses PCRE to match a text against these rules.

*/

require_once('TextLines.php');
require_once('Token.php');

class Regexer
{
        var $text=null;
        var $textLines=null;
        var $lexerPattern=null;
        var $tokens=null;
        var $gaps=null;

        function tokenizeAll($lexerPattern,$text)
        {
                $this->text=$text;
                $this->textLines=new TextLines($this->text);
                $this->lexerPattern=$lexerPattern;
                $this->findTokens();
                $this->addEofToken();
                $this->findGaps();
        }

        function findTokens()
        {
                //match all patterns
                $matches=null;
                $result=preg_match_all($this->lexerPattern,$this->text,$matches,PREG_SET_ORDER|PREG_OFFSET_CAPTURE);
                if($result===FALSE) 
                        throw new Exception("Error compiling lexer pattern:\n{$this->lexerPattern}\n");

                //turn matches into tokens
                $this->tokens=array();
                foreach($matches as $match)
                {
                        $this->tokens[]=Token::fromPCREMatch($match,$this->textLines);
                }
        }
        
        function findGaps()
        {
                $gaps=array();

                $countTokens=count($this->tokens);

                //first token
                if($countTokens>0)
                {
                        $token=$this->tokens[0];
                        $gapLength=$token->absolutePosition;
                        if($gapLength>0)
                        {
                                $gap=substr($text,0,$gapLength);
                                $token=new Token('_GAP_',$gap,0,1,1);
                                $gaps[]=$token;
                        }
                }

        
                //second till last but one token
                for($i=0; $i<$countTokens-1; $i++)
                {
                        $token=$this->tokens[$i];
                        $nextToken=$this->tokens[$i+1];
                        $tokenLength=strlen($token->value);
                        $tokenEnd=$token->absolutePosition+$tokenLength;
                        $gapLength=$nextToken->absolutePosition-$tokenEnd;

                        if($gapLength>0)
                        {
                                $gapPosition=$tokenEnd;
                                $gap=substr($this->text,$gapPosition,$gapLength);
                                $line=$this->textLines->textLineForAbsolutePosition($gapPosition);
                                $token=new Token('_GAP_',$gap,$gapPosition,$line->lineNumber,$gapPosition-$line->start+1);
                                $gaps[]=$token;
                        }
                }

                //last token
                if($countTokens>0)
                {
                        $token=$this->tokens[$countTokens-1];
                        $tokenLength=strlen($token->value);
                        $tokenEnd=$token->absolutePosition+$tokenLength;
                        $lastPosition=strlen($this->text)-1;
                        $gapLength=$lastPosition-$tokenEnd+1;
                        if($gapLength>0)
                        {
                                $gapPosition=$tokenEnd;
                                $gap=substr($this->text,$gapPosition,$gapLength);
                                $line=$this->textLines->textLineForAbsolutePosition($gapPosition);
                                $token=new Token('_GAP_',$gap,$gapPosition,$line->lineNumber,$gapPosition-$line->start+1);
                                $gaps[]=$token;
                        }
                }
                $this->gaps=$gaps;
        }

        function addEofToken()
        {
                $countTokens=count($this->tokens);

                if($countTokens>0)
                {
                        $lastToken=$this->tokens[$countTokens-1];
                         $this->tokens[]=new Token('$end','$end',strlen($this->text),
                                                        $lastToken->lineNumber,$lastToken->columnNumber+1);
                }
                else
                {
                        $this->tokens[]=new Token('$end','$end',0,0,0);
                }
       }

        function hasGaps()
        {
                if(count($this->gaps)>0) return true;
                else return false;
        }

        function purgeUnimportantSymbol($unImportantSymbol)
        {
                $newTokens=array();
                foreach($this->tokens as $token)
                {
                        if($token->symbol!==$unImportantSymbol)
                        {
                                $newTokens[]=$token;
                        }
                }
                $this->tokens=$newTokens;
        }
        
        function renameSymbol($symbolFrom,$symbolTo)
        {
                foreach($this->tokens as $token)
                {
                        if($token->symbol===$symbolFrom)
                        {
                                $token->symbol=$symbolTo;
                        }
                }
        }

        static function debugPrintSectionTitle($sectionTitle)
        {
                        echo "\n===$sectionTitle===\n\n";
        }

        static function debugPrintTokens($sectionTitle,$tokens)
        {
                if(count($tokens)==0)
                {
                        self::debugPrintSectionTitle('NO '.$sectionTitle);
                }
                else
                {
                        self::debugPrintSectionTitle($sectionTitle);
                        Token::debugPrintColumnHeadings();
                        foreach($tokens as $token)
                        {
                                $token->debugPrint();
                        }
                }
        }

        function debugPrintLexerReport()
        {
                //show lexer pattern
                self::debugPrintSectionTitle('LEXER PATTERN');
                $pattern=$this->lexerPattern;
                echo "$pattern\n";
                $lexerPatternLength=strlen($pattern);
                echo "length: $lexerPatternLength\n";
                echo "\n";
        }

        function debugPrintTextReport()
        {
                //show text
                self::debugPrintSectionTitle('TEXT');
                echo $this->text."\n"   ;
                $textLength=strlen($this->text);
                echo "length: $textLength\n";
                echo "\n";
                //show tokens
                self::debugPrintTokens('TOKENS',$this->tokens);
                //show gaps
                self::debugPrintTokens('GAPS',$this->gaps);
        }
}
?>

