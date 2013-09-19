#!/bin/bash
#	Phnom Penh, Cambodia, December 2011
#	Written by Erik Poupaert, erik@sankuru.biz
#	Licensed under the LGPL

#The tl command uses tlc to compile an tl program into il bytecode and 
#then calls the virtual machine with the vm command to execute it

filename=$(basename "$1")
dirname=$(dirname "$1")
extension=${filename##*.}
filename_no_extension=${filename%.*}
ilfile="$dirname/$filename_no_extension.il"
if [ -e $ilfile ]; then rm $ilfile; fi
./tlc "$1" || { echo 'tlc: compilation failed'; exit 1; }
./vm $ilfile

