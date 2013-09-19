%token mult plus number
%%
E : E mult B ;
E : E plus B ;
E : B ;
B : number ;
%%

