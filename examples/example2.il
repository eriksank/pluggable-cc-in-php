----          |----|------        |--- |---|---|---    |-----
code          |args|symbol        |pos |len|lin|col    |value
----          |----|------        |--- |---|---|---    |-----
PUSH_OPERAND  |    |IDENTIFIER    |44  |1  |3  |5      |x
PUSH_OPERAND  |    |NUMBER        |46  |1  |3  |7      |5
EXEC_OPERATOR |2   |ASSIGN        |45  |1  |3  |6      |=
JUMP          |    |              |44  |19 |3  |5      |<FOR_BLOCK_START_1>
LABEL         |    |              |44  |17 |3  |5      |<FOR_CONDITION_1>
PUSH_OPERAND  |    |TRUE          |44  |4  |3  |5      |true
PUSH_OPERAND  |    |IDENTIFIER    |49  |1  |3  |10     |x
PUSH_OPERAND  |    |NUMBER        |53  |2  |3  |14     |10
EXEC_OPERATOR |2   |LT            |51  |1  |3  |12     |<
IF_TRUE       |    |              |49  |19 |3  |10     |<FOR_BLOCK_START_1>
JUMP          |    |              |49  |11 |3  |10     |<FOR_END_1>
LABEL         |    |              |49  |23 |3  |10     |<FOR_BLOCK_LOOP_NEXT_1>
PUSH_OPERAND  |    |IDENTIFIER    |57  |1  |3  |18     |x
PUSH_OPERAND  |    |IDENTIFIER    |59  |1  |3  |20     |x
PUSH_OPERAND  |    |NUMBER        |61  |1  |3  |22     |1
EXEC_OPERATOR |2   |PLUS          |60  |1  |3  |21     |+
EXEC_OPERATOR |2   |ASSIGN        |58  |1  |3  |19     |=
JUMP          |    |              |57  |17 |3  |18     |<FOR_CONDITION_1>
LABEL         |    |              |57  |19 |3  |18     |<FOR_BLOCK_START_1>
PUSH_OPERAND  |    |IDENTIFIER    |78  |1  |5  |13     |y
PUSH_OPERAND  |    |NUMBER        |80  |1  |5  |15     |0
EXEC_OPERATOR |2   |ASSIGN        |79  |1  |5  |14     |=
PUSH_OPERAND  |    |IDENTIFIER    |82  |1  |5  |17     |z
PUSH_OPERAND  |    |NUMBER        |84  |1  |5  |19     |0
EXEC_OPERATOR |2   |ASSIGN        |83  |1  |5  |18     |=
JUMP          |    |              |78  |19 |5  |13     |<FOR_BLOCK_START_2>
LABEL         |    |              |78  |17 |5  |13     |<FOR_CONDITION_2>
PUSH_OPERAND  |    |TRUE          |78  |4  |5  |13     |true
PUSH_OPERAND  |    |IDENTIFIER    |87  |1  |5  |22     |y
PUSH_OPERAND  |    |NUMBER        |89  |1  |5  |24     |7
EXEC_OPERATOR |2   |LT            |88  |1  |5  |23     |<
IF_TRUE       |    |              |87  |19 |5  |22     |<FOR_BLOCK_START_2>
JUMP          |    |              |87  |11 |5  |22     |<FOR_END_2>
LABEL         |    |              |87  |23 |5  |22     |<FOR_BLOCK_LOOP_NEXT_2>
PUSH_OPERAND  |    |IDENTIFIER    |92  |1  |5  |27     |y
PUSH_OPERAND  |    |IDENTIFIER    |94  |1  |5  |29     |y
PUSH_OPERAND  |    |NUMBER        |96  |1  |5  |31     |1
EXEC_OPERATOR |2   |PLUS          |95  |1  |5  |30     |+
EXEC_OPERATOR |2   |ASSIGN        |93  |1  |5  |28     |=
PUSH_OPERAND  |    |IDENTIFIER    |99  |1  |5  |34     |z
PUSH_OPERAND  |    |IDENTIFIER    |101 |1  |5  |36     |z
PUSH_OPERAND  |    |NUMBER        |103 |1  |5  |38     |1
EXEC_OPERATOR |2   |PLUS          |102 |1  |5  |37     |+
EXEC_OPERATOR |2   |ASSIGN        |100 |1  |5  |35     |=
JUMP          |    |              |92  |17 |5  |27     |<FOR_CONDITION_2>
LABEL         |    |              |92  |19 |5  |27     |<FOR_BLOCK_START_2>
PUSH_OPERAND  |    |IDENTIFIER    |135 |1  |7  |20     |z
PUSH_OPERAND  |    |NUMBER        |138 |1  |7  |23     |3
EXEC_OPERATOR |2   |EQ            |136 |2  |7  |21     |==
PUSH_OPERAND  |    |IDENTIFIER    |143 |1  |7  |28     |z
PUSH_OPERAND  |    |NUMBER        |146 |1  |7  |31     |5
EXEC_OPERATOR |2   |EQ            |144 |2  |7  |29     |==
EXEC_OPERATOR |2   |OR            |140 |2  |7  |25     |||
IF_FALSE      |    |              |132 |8  |7  |17     |<ELSE_3>
PUSH_OPERAND  |    |STRING        |157 |47 |7  |42     |we don't print values for z, when z is 3 or 5
PUSH_OPERAND  |    |IDENTIFIER    |149 |7  |7  |34     |println
EXEC_OPERATOR |2   |FUNCTION_CALL |149 |0  |7  |34     |
RESET_STACK   |    |SEMICOLON     |205 |1  |7  |90     |;
JUMP          |    |              |132 |10 |7  |17     |<IF_END_3>
LABEL         |    |              |132 |8  |7  |17     |<ELSE_3>
PUSH_OPERAND  |    |STRING        |236 |15 |8  |30     |(outer for)x:
PUSH_OPERAND  |    |IDENTIFIER    |252 |1  |8  |46     |x
EXEC_OPERATOR |2   |CONCAT        |251 |1  |8  |45     |.
PUSH_OPERAND  |    |STRING        |254 |5  |8  |48     | y:
EXEC_OPERATOR |2   |CONCAT        |253 |1  |8  |47     |.
PUSH_OPERAND  |    |IDENTIFIER    |260 |1  |8  |54     |y
EXEC_OPERATOR |2   |CONCAT        |259 |1  |8  |53     |.
PUSH_OPERAND  |    |STRING        |262 |5  |8  |56     | z:
EXEC_OPERATOR |2   |CONCAT        |261 |1  |8  |55     |.
PUSH_OPERAND  |    |IDENTIFIER    |268 |1  |8  |62     |z
EXEC_OPERATOR |2   |CONCAT        |267 |1  |8  |61     |.
PUSH_OPERAND  |    |IDENTIFIER    |228 |7  |8  |22     |println
EXEC_OPERATOR |2   |FUNCTION_CALL |228 |0  |8  |22     |
RESET_STACK   |    |SEMICOLON     |270 |1  |8  |64     |;
LABEL         |    |              |132 |10 |7  |17     |<IF_END_3>
PUSH_OPERAND  |    |IDENTIFIER    |288 |1  |9  |17     |i
PUSH_OPERAND  |    |NUMBER        |290 |1  |9  |19     |0
EXEC_OPERATOR |2   |ASSIGN        |289 |1  |9  |18     |=
RESET_STACK   |    |SEMICOLON     |291 |1  |9  |20     |;
LABEL         |    |              |310 |15 |11 |17     |<WHILE_START_4>
PUSH_OPERAND  |    |IDENTIFIER    |316 |1  |11 |23     |i
PUSH_OPERAND  |    |IDENTIFIER    |318 |1  |11 |25     |x
PUSH_OPERAND  |    |NUMBER        |320 |1  |11 |27     |4
EXEC_OPERATOR |2   |DIVIDE        |319 |1  |11 |26     |/
EXEC_OPERATOR |2   |LT            |317 |1  |11 |24     |<
IF_FALSE      |    |              |310 |13 |11 |17     |<WHILE_END_4>
PUSH_OPERAND  |    |STRING        |373 |37 |13 |33     |(inner while) print from 0 to x/4: 
PUSH_OPERAND  |    |IDENTIFIER    |411 |1  |13 |71     |i
EXEC_OPERATOR |2   |CONCAT        |410 |1  |13 |70     |.
PUSH_OPERAND  |    |IDENTIFIER    |365 |7  |13 |25     |println
EXEC_OPERATOR |2   |FUNCTION_CALL |365 |0  |13 |25     |
RESET_STACK   |    |SEMICOLON     |413 |1  |13 |73     |;
PUSH_OPERAND  |    |IDENTIFIER    |439 |1  |14 |25     |i
PUSH_OPERAND  |    |IDENTIFIER    |441 |1  |14 |27     |i
PUSH_OPERAND  |    |NUMBER        |443 |1  |14 |29     |1
EXEC_OPERATOR |2   |PLUS          |442 |1  |14 |28     |+
EXEC_OPERATOR |2   |ASSIGN        |440 |1  |14 |26     |=
RESET_STACK   |    |SEMICOLON     |444 |1  |14 |30     |;
JUMP          |    |              |310 |15 |11 |17     |<WHILE_START_4>
LABEL         |    |              |310 |13 |11 |17     |<WHILE_END_4>
LABEL         |    |              |481 |12 |17 |17     |<DO_START_5>
PUSH_OPERAND  |    |STRING        |534 |40 |19 |33     |(inner do while) print from 0 to x/4: 
PUSH_OPERAND  |    |IDENTIFIER    |575 |1  |19 |74     |i
EXEC_OPERATOR |2   |CONCAT        |574 |1  |19 |73     |.
PUSH_OPERAND  |    |IDENTIFIER    |526 |7  |19 |25     |println
EXEC_OPERATOR |2   |FUNCTION_CALL |526 |0  |19 |25     |
RESET_STACK   |    |SEMICOLON     |577 |1  |19 |76     |;
PUSH_OPERAND  |    |IDENTIFIER    |603 |1  |20 |25     |i
PUSH_OPERAND  |    |IDENTIFIER    |605 |1  |20 |27     |i
PUSH_OPERAND  |    |NUMBER        |607 |1  |20 |29     |1
EXEC_OPERATOR |2   |PLUS          |606 |1  |20 |28     |+
EXEC_OPERATOR |2   |ASSIGN        |604 |1  |20 |26     |=
RESET_STACK   |    |SEMICOLON     |608 |1  |20 |30     |;
PUSH_OPERAND  |    |IDENTIFIER    |650 |1  |22 |23     |i
PUSH_OPERAND  |    |IDENTIFIER    |652 |1  |22 |25     |x
PUSH_OPERAND  |    |NUMBER        |654 |1  |22 |27     |5
EXEC_OPERATOR |2   |DIVIDE        |653 |1  |22 |26     |/
EXEC_OPERATOR |2   |LT            |651 |1  |22 |24     |<
IF_TRUE       |    |              |481 |12 |17 |17     |<DO_START_5>
LABEL         |    |              |481 |10 |17 |17     |<DO_END_5>
JUMP          |    |              |114 |23 |6  |9      |<FOR_BLOCK_LOOP_NEXT_2>
LABEL         |    |              |114 |11 |6  |9      |<FOR_END_2>
JUMP          |    |              |64  |23 |4  |1      |<FOR_BLOCK_LOOP_NEXT_1>
LABEL         |    |              |64  |11 |4  |1      |<FOR_END_1>
