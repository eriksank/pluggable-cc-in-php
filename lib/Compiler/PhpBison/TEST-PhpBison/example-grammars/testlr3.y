%token id equals deref
%%
S: L equals R ;
S: R ;
L : deref R ;
L : id ;
R : L ;
%%

