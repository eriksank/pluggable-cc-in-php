//This is a an example of the BREAK and CONTINUE statements in the FOR, WHILE, and DO WHILE statements

for(x=0; x < 10; x=x+1)
{
        if(x==6)
        {
                println('continuing loop at '.x);
                continue;
        }
        else if(x==8)
        {
                println('breaking loop at '.x);
                break;
        }
        println('(for loop) x:'.x);
} 

x=0;
while(x < 10)
{
        x=x+1;
        if(x==6)
        {
                println('continuing loop at '.x);
                continue;
        }
        else if(x==8)
        {
                println('breaking loop at '.x);
                break;
        }
        println('(while loop) x:'.x);
}

x=0;
do
{
        x=x+1;
        if(x==6)
        {
                println('continuing loop at '.x);
                continue;
        }
        else if(x==8)
        {
                println('breaking loop at '.x);
                break;
        }
        println('(do while loop) x:'.x);
}
while(x < 10);

