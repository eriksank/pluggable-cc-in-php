* Pluggable compiler in PHP



|-- build-grammar : Generates the grammar file and calls bison to the generate the XML file
|-- examples
|   |-- example1.il : example file in intermediate language
|   |-- example1.tl : example source file
...
|-- generate-grammar-file : composes the bison input grammar
|-- lib : the implementation
|   |-- Compiler : this is the compiler part
|   |   |-- CompilerGrammarGenerator.php
|   |   |-- CompilerInstruction.php
|   |   |-- CompilerLexerPattern.php
|   |   |-- Compiler.php
|   |   |-- grammar.template.y
|   |   |-- grammar.xml
|   |   |-- grammar.y
|   |   |-- LexerPriorities.php
|   |   |-- ParserOperatorPriorities.php
|   |   |-- PhpBison
|   |   |   |-- BisonTables.php
|   |   |   |-- Parser.php
|   |   |   |-- PhpLexer
|   |   |   |   |-- ILexer.php
|   |   |   |   |-- LexerPattern.php
|   |   |   |   |-- PhpLexer.php
|   |   |   |   |-- Regexer.php
|   |   |   |   |-- TEST-Regexer
|   |   |   |   |   |-- TEST-Regexer.php
|   |   |   |   |   `-- TEST-TextLines.php
|   |   |   |   |-- TextLines.php
|   |   |   |   `-- Token.php
|   |   |   `-- TEST-PhpBison
|   |   |       |-- example5.php
|   |   |       |-- example-grammars
|   |   |       |   |-- test4lr.xml
|   |   |       |   |-- testlr1.y
...
|   |   |       `-- examples.php
|   |   `-- Plugins
|   |       |-- CompilerPluginLoader.php
|   |       |-- CompilerSemanticPluginBinaryOperator.php
|   |       |-- CompilerSemanticPluginOperand.php
|   |       |-- Debug
|   |       |   |-- _printConfigReport.php
|   |       |   |-- printFullTextReport.php
|   |       |   `-- printTextReport.php
|   |       |-- Emitter
|   |       |   |-- _BinaryOperator.php
|   |       |   |-- FunctionCall.php
|   |       |   |-- GoSub.php
|   |       |   |-- IfFalse.php
|   |       |   |-- IfTrue.php
|   |       |   |-- InjectedEquals.php
|   |       |   |-- InjectedOperand.php
|   |       |   |-- Jump.php
|   |       |   |-- _LabeledInstruction.php
|   |       |   |-- Label.php
|   |       |   |-- _Operand.php
|   |       |   |-- _Operator.php
|   |       |   `-- Return.php
|   |       |-- ICompilerSemanticPlugin.php
|   |       |-- Mechanism
|   |       |   |-- _CountListElements.php
|   |       |   |-- FindFirstTokenWithLineNumber.php
|   |       |   |-- _LabelStack.php
|   |       |   `-- _PrintInstructions.php
|   |       `-- Semantic
|   |           |-- _And.php
|   |           |-- _Assign.php
|   |           |-- _Block.php
|   |           |-- _Break.php
|   |           |-- _Cast.php
|   |           |-- _Comments.php
|   |           |-- _Concat.php
|   |           |-- _Continue.php
|   |           |-- _Divide.php
|   |           |-- _DoWhile.php
|   |           |-- _Equals.php
|   |           |-- _Exponentiate.php
|   |           |-- _False.php
|   |           |-- _For.php
|   |           |-- _FunctionCall.php
|   |           |-- _GreaterOrEqual.php
|   |           |-- _GreaterThan.php
|   |           |-- _Identifier.php
|   |           |-- _If.php
|   |           |-- _LessOrEqual.php
|   |           |-- _LessThan.php
|   |           |-- _Minus.php
|   |           |-- _Modulo.php
|   |           |-- _Multiply.php
|   |           |-- _NotEqual.php
|   |           |-- _Not.php
|   |           |-- _Null.php
|   |           |-- _Number.php
|   |           |-- _Or.php
|   |           |-- _Plus.php
|   |           |-- _SemiColon.php
|   |           |-- _String.php
|   |           |-- _Switch.php
|   |           |-- _True.php
|   |           |-- _UnaryMinus.php
|   |           |-- _While.php
|   |           `-- _Whitespace.php
|   `-- VirtualMachine : This is the virtual machine part
|       |-- Plugins
|       |   |-- BinaryOperator
|       |   |   |-- And.php
|       |   |   |-- Cast.php
|       |   |   |-- Concat.php
|       |   |   |-- Divide.php
|       |   |   |-- EQ.php
|       |   |   |-- Exponentiate.php
|       |   |   |-- GE.php
|       |   |   |-- GT.php
|       |   |   |-- LE.php
|       |   |   |-- LT.php
|       |   |   |-- Minus.php
|       |   |   |-- Multiply.php
|       |   |   |-- NE.php
|       |   |   |-- Or.php
|       |   |   `-- Plus.php
|       |   |-- Debug
|       |   |   |-- _Bool2String.php
|       |   |   |-- _PrintStack.php
|       |   |   `-- _PrintVariables.php
|       |   |-- Function
|       |   |   |-- float2Int.php
|       |   |   |-- float2String.php
|       |   |   |-- int2Float.php
|       |   |   |-- int2String.php
|       |   |   |-- println.php
|       |   |   |-- string2Float.php
|       |   |   `-- string2Int.php
|       |   |-- Instruction
|       |   |   |-- _BranchConditionally.php
|       |   |   |-- Exec_Operator.php
|       |   |   |-- GoSub.php
|       |   |   |-- If_False.php
|       |   |   |-- If_True.php
|       |   |   |-- Jump.php
|       |   |   |-- Label.php
|       |   |   |-- Push_Operand.php
|       |   |   |-- Reset_Stack.php
|       |   |   `-- Return.php
|       |   |-- Mechanism
|       |   |   |-- _AssertMinimalStackSize.php
|       |   |   |-- _AssertNumberOfFunctionArgs.php
|       |   |   |-- _Error.php
|       |   |   |-- _ExecInstruction.php
|       |   |   |-- _functionArgs.php
|       |   |   |-- _MainLoop.php
|       |   |   |-- _ParseILText.php
|       |   |   |-- _popItem.php
|       |   |   |-- _PushResult.php
|       |   |   `-- _ResetVariables.php
|       |   |-- Operand
|       |   |   |-- _Constant.php
|       |   |   |-- False.php
|       |   |   |-- _Identifier.php
|       |   |   |-- Identifier.php
|       |   |   |-- _NamedConstant.php
|       |   |   |-- Null.php
|       |   |   |-- Number.php
|       |   |   |-- String.php
|       |   |   |-- True.php
|       |   |   `-- Type.php
|       |   |-- Operator
|       |   |   |-- Assign.php
|       |   |   |-- Function_Call.php
|       |   |   |-- Not.php
|       |   |   `-- Unary_Minus.php
|       |   `-- VMPluginLoader.php
|       |-- VirtualMachine.php
|       |-- VMExpressionStackItem.php
|       `-- VMInstruction.php
|-- LICENSE
|-- README.md
|-- tl
|-- tlc : to call the compiler with a .tl file
|-- VERSION
`-- vm : to call the virtual machine with an .il file


** HARD PREREQUISITE: PHP

You must have the commandline version of php installed on your system to execute the scripts

$ sudo apt-get install php5-cli bison

** SOFT PREREQUISITE: LINUX

This source code was tested on linux only. Windows (\r\n) and Mac (\r) have other new line conventions than Linux (\n). If this causes trouble, switch your Windows or Mac machine in some kind of Linux compabitility mode, or else change the definitions for newline in the source code.

** INSTALL

Unzip this library in any folder. Next, navigate from the commandline to the library. You can execute the tests included.

** INSTALLING INTO YOUR OWN PROGRAM SOURCE TREE

This can be effected through copying/pasting the folder or subfolder that you want to use in your own Php program.

