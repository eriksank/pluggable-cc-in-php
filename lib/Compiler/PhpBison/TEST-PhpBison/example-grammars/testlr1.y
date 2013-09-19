%token A B

%%
S : X X ; 
X : A X  
  | B
  ;
%%

