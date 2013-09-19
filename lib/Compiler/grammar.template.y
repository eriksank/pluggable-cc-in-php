/*
        The template bison grammar

	Phnom Penh, Cambodia, January 2012
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/
%token BRACKET_LEFT BRACKET_RIGHT
//{tokens}//

//{priorities}//

//{conflicts_expected}//

%%
/* the following rules are the basic rules for a simple expression parser */

script: statements;
script : ;
statements: statements statement;
statements: statement;

statement: expression_statement;
expression_statement: expression SEMICOLON;
expression: BRACKET_LEFT expression BRACKET_RIGHT;
//{rules}//
%%

