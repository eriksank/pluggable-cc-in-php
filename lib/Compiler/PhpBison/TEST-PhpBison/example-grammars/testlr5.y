%token NUMBER MINUS PLUS MULT DIV EXPONENTIATE BRACKET_LEFT BRACKET_RIGHT
%left MINUS PLUS
%left MULT DIV
%left UNARY     /* negation--unary minus */
%right EXPONENTIATE    /* exponentiation */
%%
exp:      NUMBER
     | exp PLUS exp
     | exp MINUS exp
     | exp MULT exp
     | exp DIV exp
     | MINUS exp         %prec UNARY
     | PLUS exp          %prec UNARY
     | exp EXPONENTIATE exp
     | BRACKET_LEFT exp BRACKET_RIGHT
;
%%

