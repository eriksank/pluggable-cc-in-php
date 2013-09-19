----          |----|------        |--- |---|---|---    |-----
code          |args|symbol        |pos |len|lin|col    |value
----          |----|------        |--- |---|---|---    |-----
PUSH_OPERAND  |    |IDENTIFIER    |48  |1  |3  |1      |a
PUSH_OPERAND  |    |NUMBER        |50  |3  |3  |3      |100
EXEC_OPERATOR |2   |ASSIGN        |49  |1  |3  |2      |=
RESET_STACK   |    |SEMICOLON     |53  |1  |3  |6      |;
JUMP          |    |              |56  |17 |5  |1      |<SWITCH_CASE_1_1>
LABEL         |    |              |56  |16 |5  |1      |<SWITCH_START_1>
PUSH_OPERAND  |    |IDENTIFIER    |63  |1  |5  |8      |a
PUSH_OPERAND  |    |NUMBER        |65  |1  |5  |10     |2
EXEC_OPERATOR |2   |DIVIDE        |64  |1  |5  |9      |/
RETURN        |    |BRACKET_LEFT  |62  |0  |5  |7      |
LABEL         |    |              |78  |17 |7  |9      |<SWITCH_CASE_1_1>
GOSUB         |    |              |78  |16 |7  |9      |<SWITCH_START_1>
PUSH_OPERAND  |    |NUMBER        |83  |1  |7  |14     |3
EXEC_OPERATOR |2   |EQ            |83  |4  |7  |14     |case
IF_FALSE      |    |              |83  |17 |7  |14     |<SWITCH_CASE_1_2>
PUSH_OPERAND  |    |STRING        |94  |8  |7  |25     |a is 3
PUSH_OPERAND  |    |IDENTIFIER    |86  |7  |7  |17     |println
EXEC_OPERATOR |2   |FUNCTION_CALL |86  |0  |7  |17     |
RESET_STACK   |    |SEMICOLON     |103 |1  |7  |34     |;
LABEL         |    |              |113 |17 |8  |9      |<SWITCH_CASE_1_2>
GOSUB         |    |              |113 |16 |8  |9      |<SWITCH_START_1>
PUSH_OPERAND  |    |NUMBER        |118 |2  |8  |14     |40
EXEC_OPERATOR |2   |EQ            |118 |4  |8  |14     |case
IF_FALSE      |    |              |118 |17 |8  |14     |<SWITCH_CASE_1_3>
PUSH_OPERAND  |    |STRING        |130 |9  |8  |26     |a is 40
PUSH_OPERAND  |    |IDENTIFIER    |122 |7  |8  |18     |println
EXEC_OPERATOR |2   |FUNCTION_CALL |122 |0  |8  |18     |
RESET_STACK   |    |SEMICOLON     |140 |1  |8  |36     |;
JUMP          |    |              |142 |14 |8  |38     |<SWITCH_END_1>
LABEL         |    |              |157 |17 |9  |9      |<SWITCH_CASE_1_3>
PUSH_OPERAND  |    |STRING        |174 |32 |9  |26     |hitting the default case for a
PUSH_OPERAND  |    |IDENTIFIER    |166 |7  |9  |18     |println
EXEC_OPERATOR |2   |FUNCTION_CALL |166 |0  |9  |18     |
RESET_STACK   |    |SEMICOLON     |207 |1  |9  |59     |;
JUMP          |    |              |225 |17 |10 |17     |<SWITCH_CASE_2_1>
LABEL         |    |              |225 |16 |10 |17     |<SWITCH_START_2>
PUSH_OPERAND  |    |IDENTIFIER    |232 |1  |10 |24     |a
RETURN        |    |BRACKET_LEFT  |231 |0  |10 |23     |
LABEL         |    |              |277 |17 |12 |25     |<SWITCH_CASE_2_1>
GOSUB         |    |              |277 |16 |12 |25     |<SWITCH_START_2>
PUSH_OPERAND  |    |NUMBER        |282 |2  |12 |30     |51
EXEC_OPERATOR |2   |EQ            |282 |4  |12 |30     |case
IF_FALSE      |    |              |282 |17 |12 |30     |<SWITCH_CASE_2_2>
PUSH_OPERAND  |    |STRING        |294 |9  |12 |42     |a is 51
PUSH_OPERAND  |    |IDENTIFIER    |286 |7  |12 |34     |println
EXEC_OPERATOR |2   |FUNCTION_CALL |286 |0  |12 |34     |
RESET_STACK   |    |SEMICOLON     |304 |1  |12 |52     |;
JUMP          |    |              |306 |14 |12 |54     |<SWITCH_END_2>
LABEL         |    |              |337 |17 |13 |25     |<SWITCH_CASE_2_2>
GOSUB         |    |              |337 |16 |13 |25     |<SWITCH_START_2>
PUSH_OPERAND  |    |STRING        |342 |16 |13 |30     |something else
EXEC_OPERATOR |2   |EQ            |342 |4  |13 |30     |case
IF_FALSE      |    |              |342 |17 |13 |30     |<SWITCH_CASE_2_3>
PUSH_OPERAND  |    |STRING        |368 |23 |13 |56     |a is "something else"
PUSH_OPERAND  |    |IDENTIFIER    |360 |7  |13 |48     |println
EXEC_OPERATOR |2   |FUNCTION_CALL |360 |0  |13 |48     |
RESET_STACK   |    |SEMICOLON     |392 |1  |13 |80     |;
JUMP          |    |              |394 |14 |13 |82     |<SWITCH_END_2>
LABEL         |    |              |425 |17 |14 |25     |<SWITCH_CASE_2_3>
GOSUB         |    |              |425 |16 |14 |25     |<SWITCH_START_2>
PUSH_OPERAND  |    |NUMBER        |430 |3  |14 |30     |100
EXEC_OPERATOR |2   |EQ            |430 |4  |14 |30     |case
IF_FALSE      |    |              |430 |17 |14 |30     |<SWITCH_CASE_2_4>
PUSH_OPERAND  |    |STRING        |443 |10 |14 |43     |a is 100
PUSH_OPERAND  |    |IDENTIFIER    |435 |7  |14 |35     |println
EXEC_OPERATOR |2   |FUNCTION_CALL |435 |0  |14 |35     |
RESET_STACK   |    |SEMICOLON     |454 |1  |14 |54     |;
JUMP          |    |              |456 |14 |14 |56     |<SWITCH_END_2>
LABEL         |    |              |487 |17 |15 |25     |<SWITCH_CASE_2_4>
PUSH_OPERAND  |    |STRING        |504 |46 |15 |42     |a is neither 51 nor "something else" nor 100
PUSH_OPERAND  |    |IDENTIFIER    |496 |7  |15 |34     |println
EXEC_OPERATOR |2   |FUNCTION_CALL |496 |0  |15 |34     |
RESET_STACK   |    |SEMICOLON     |551 |1  |15 |89     |;
LABEL         |    |              |225 |17 |10 |17     |<SWITCH_CASE_2_5>
LABEL         |    |              |225 |14 |10 |17     |<SWITCH_END_2>
JUMP          |    |              |587 |17 |17 |17     |<SWITCH_CASE_3_1>
LABEL         |    |              |587 |16 |17 |17     |<SWITCH_START_3>
PUSH_OPERAND  |    |IDENTIFIER    |594 |1  |17 |24     |a
PUSH_OPERAND  |    |NUMBER        |596 |1  |17 |26     |2
EXEC_OPERATOR |2   |MULTIPLY      |595 |1  |17 |25     |*
RETURN        |    |BRACKET_LEFT  |593 |0  |17 |23     |
LABEL         |    |              |641 |17 |19 |25     |<SWITCH_CASE_3_1>
GOSUB         |    |              |641 |16 |19 |25     |<SWITCH_START_3>
PUSH_OPERAND  |    |NUMBER        |646 |3  |19 |30     |200
EXEC_OPERATOR |2   |EQ            |646 |4  |19 |30     |case
IF_FALSE      |    |              |646 |17 |19 |30     |<SWITCH_CASE_3_2>
PUSH_OPERAND  |    |STRING        |659 |18 |19 |43     |a times 2 is 200
PUSH_OPERAND  |    |IDENTIFIER    |651 |7  |19 |35     |println
EXEC_OPERATOR |2   |FUNCTION_CALL |651 |0  |19 |35     |
RESET_STACK   |    |SEMICOLON     |678 |1  |19 |62     |;
LABEL         |    |              |704 |17 |20 |25     |<SWITCH_CASE_3_2>
PUSH_OPERAND  |    |STRING        |721 |45 |20 |42     |always hit the default, unless we break out
PUSH_OPERAND  |    |IDENTIFIER    |713 |7  |20 |34     |println
EXEC_OPERATOR |2   |FUNCTION_CALL |713 |0  |20 |34     |
RESET_STACK   |    |SEMICOLON     |767 |1  |20 |88     |;
LABEL         |    |              |587 |17 |17 |17     |<SWITCH_CASE_3_3>
LABEL         |    |              |587 |14 |17 |17     |<SWITCH_END_3>
LABEL         |    |              |56  |17 |5  |1      |<SWITCH_CASE_1_4>
LABEL         |    |              |56  |14 |5  |1      |<SWITCH_END_1>
