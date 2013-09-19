//This is a an example of the SWITCH statement

a=100;

switch(a/2)
{
        case 3: println('a is 3');
        case 40: println('a is 40'); break;
        default: println('hitting the default case for a');
                switch(a)
                {
                        case 51: println('a is 51'); break;
                        case "something else": println('a is "something else"'); break;
                        case 100: println('a is 100'); break;
                        default: println('a is neither 51 nor "something else" nor 100');
                }
                switch(a*2)
                {
                        case 200: println('a times 2 is 200');
                        default: println('always hit the default, unless we break out');
                }

}

