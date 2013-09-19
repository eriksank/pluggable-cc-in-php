//This is a turing-complete-language program
a=0;

ifmyfriend=5;
while(a<15)
{
        if(a<5) println('a is smaller than 5');
        else println('a is larger than 5');
        if(a>=9 && a<=10) println('a is between 9 and 10');
        if(a==1 || a==9) println('a is now 1 or 9');
        println('a:'.a);
        a=a+1;
}

x=1;

do
{
        y=x^2;
        println('x is:'.x.' and y is:'.y);
        if(x==4 || (y>4 && y<30)) 
        {
                println('x is 4 or y is larger than 4, but smaller than 30');
        }
        else
        {
                println('nothing special to mention about x or y');
        }
        x=x+1;
}
while(x<10);

