//This is a an example of the for loop

for(x=5; x < 10; x=x+1)
{
        for(y=0,z=0; y<7; y=y+1, z=z+1)
        {
                if(z==3 || z==5) println("we don't print values for z, when z is 3 or 5");
                else println('(outer for)x:'.x.' y:'.y.' z:'.z);
                i=0;

                while(i<x/4)
                {
                        println('(inner while) print from 0 to x/4: '.i);
                        i=i+1;
                }

                do
                {
                        println('(inner do while) print from 0 to x/4: '.i);
                        i=i+1;
                }
                while(i<x/5);

        }
} 

