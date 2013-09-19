%token a b
%%
S : X b b | a a b | b X a 
X : a 
%%

