<?php
/*
	Phnom Penh, Cambodia, December 2011
	Written by Erik Poupaert
	Licensed under the LGPL
*/

/*
------------------
StackState class
------------------
*/

class StackState
{
        var $stateNumber=null;
        var $token=null;
        var $symbol=null; //only filled out after reduction

        function __construct($stateNumber,$token)
        {
                $this->stateNumber=$stateNumber;
                $this->token=$token;
        }
}


/*
----------------------
Parser class
----------------------
*/

require_once('BisonTables.php');

class Parser
{
        var $stack=null;
        var $bisonTables=null;
        var $reduceCallbacks=null;
        var $defaultReduceCallback=null;
        var $ruleNumbers=null; //associates: $ruleNumbers[$ruleName]=$ruleNumber
        var $DEBUG=false;

        function __construct($xmlString)
        {
                $this->bisonTables=new BisonTables($xmlString);
                $this->stack=array();
        }

        function registerReduceCallback($ruleNumber,$function)
        {
                if($this->reduceCallbacks==null) $this->reduceCallbacks=array();
                $this->reduceCallbacks['R'.$ruleNumber]=$function;
        }

        function registerNamedReduceCallback($ruleName,$function)
        {
                if(!array_key_exists($ruleName,$this->ruleNumbers))
                        $this->error("There is no rule with name '$ruleName'");
                $ruleNumber=$this->ruleNumbers[$ruleName];
                $this->registerReduceCallback($ruleNumber,$function);
        }

        function setDefaultReduceCallback($function)
        {
                $this->defaultReduceCallback=$function;
        }

        function currentStackState()
        {
                //watch out if stack is empty
                if(count($this->stack)==0) 
                        $this->error('no current state present on stack');
                //return the last element in the stack
                return $this->stack[count($this->stack)-1];
        }
        
        function parse($lexer)
        {
                //initialize stack
                $this->stack[]=new StackState(0,null);
                //read first token
                $token=$lexer->readToken();
                $this->debugPrintToken($token);
                //at end, the lexer will send an $end
                while($token->symbol!='$end')
                {            
                        $this->reduce($token);
                        $this->shift($token);
                        $token=$lexer->readToken();
                        $this->debugPrintToken($token);
                }
                //do a last (reduce-shift $end-reduce) round for the $end symbol
                $this->reduce($token);
                $this->shift($token);
                $this->reduce($token);
        }

        function error($msg)
        {
                throw new Exception($msg);
        }

        function debugPrintToken($token)
        {
                $this->debug('just read token ('.$token->symbol.':'.$token->value.')');
        }

        function debugPrintStack()
        {
                $this->debug('stack='.$this->debugGetStackElements($this->stack));
        }

        function debugGetStackElements($array)
        {
                $buffer='[';
                foreach($array as $stackState)
                {
                        $buffer.='{';
                        $buffer.='state:'.$stackState->stateNumber.',token:';
                        if($stackState->token!=null) 
                                $buffer.='('.$stackState->token->symbol.':'.$stackState->token->value.')';
                        else $buffer.='(null:null)';
                        $buffer.='} ';
                }
                $buffer.=']';
                return $buffer;
        }

        function debugPrintAnswerNo()
        {
                $this->debug('answer:no');
        }

        function debug($msg)
        {
                if($this->DEBUG)
                {
                        echo "$msg\n";
                }
        }

        function determineReduceDecision($stateNumber,$token)
        {
                $this->debug("determining if state $stateNumber has reductions");
                $hasReductions=$this->bisonTables->hasReductions($stateNumber);
                if(!$hasReductions) $this->debugPrintAnswerNo();
                if(!$hasReductions) return 'shift';
                $this->debug("confirmed: state $stateNumber has reductions");
                //----------------------------------------------------------------
                $this->debug("determining if state $stateNumber has lookaheads");
                $hasLookaheads=$this->bisonTables->hasLookaheads($stateNumber);
                if(!$hasLookaheads) $this->debugPrintAnswerNo();
                if(!$hasLookaheads) return 'reduce';
                $this->debug("confirmed: state $stateNumber has lookaheads");
                //----------------------------------------------------------------
                $this->debug("determining if state $stateNumber has '{$token->symbol}' as lookahead");
                $hasLookaheadForToken=$this->bisonTables->hasLookahead($stateNumber,$token);
                if(!$hasLookaheadForToken) $this->debugPrintAnswerNo();
                if(!$hasLookaheadForToken) return 'shift';
                $this->debug("confirmed: state $stateNumber has '{$token->symbol}' as lookahead");
                //----------------------------------------------------------------
                $this->debug("determining if state $stateNumber has solved conflicts");
                $hasSolvedConflicts=$this->bisonTables->hasSolvedConflicts($stateNumber);
                if(!$hasSolvedConflicts) $this->debugPrintAnswerNo();
                //----------------------------------------------------------------
                if(!$hasSolvedConflicts) 
                {
                        $this->debug("determining if state $stateNumber has an unsolved conflict for lookahead '{$token->symbol}'");
                        $hasUnsolvedConflictForLookahead=
                                        $this->bisonTables->hasUnsolvedConflictForLookahead($stateNumber,$token);                
                        if(!$hasUnsolvedConflictForLookahead) $this->debugPrintAnswerNo();
                        if(!$hasUnsolvedConflictForLookahead) return 'reduce';
                        $this->debug("confirmed: state $stateNumber has an unsolved conflict for lookahead '{$token->symbol}'");
                        return 'shift';
                }
                //----------------------------------------------------------------
                $this->debug("determining if state $stateNumber has a solved conflict for '{$token->symbol}'");
                $hasSolvedConflictForToken=$this->bisonTables->hasSolvedConflict($stateNumber,$token);
                if(!$hasSolvedConflictForToken) $this->debugPrintAnswerNo();
                if(!$hasSolvedConflictForToken) return 'reduce';
                $this->debug("confirmed: state $stateNumber has a solved conflict for '{$token->symbol}'");
                //----------------------------------------------------------------
                $this->debug("determining operation for $stateNumber in solved conflict for '{$token->symbol}'");
                return $this->bisonTables->findSolvedConflictOperation($stateNumber,$token);
        }

        function reduce($token)
        {
                //keep trying to reduce, for as long as the current stack state keeps changing 
                while(true)
                {
                        $stateNumber=$this->currentStackState()->stateNumber;
                        $decision=$this->determineReduceDecision($stateNumber,$token);
                        $this->debug("decision in state $stateNumber for '{$token->symbol}' is '$decision'");
                        switch($decision)
                        {
                                case 'shift': return;
                                case 'reduce': $ruleNumber=$this->bisonTables->defaultRuleNumberForStateNumber($stateNumber);
                                                break;
                                case 'accept': $ruleNumber=0; break;
                        }
                        $termsReduced=$this->reduceRule($ruleNumber);
                        //inform the caller that we have reduced a rule
                        $this->processReduceCallbacks($ruleNumber,$termsReduced);
                        //stop if rule is number 0
                        if($ruleNumber==0) return;
                }
        }

        function reduceRule($ruleNumber)
        {
                 $this->debug("reducing rule $ruleNumber");
                $rule=$this->bisonTables->findRule($ruleNumber);
                $termsReduced=$this->reduceStack($rule->rhs);
                $stateNumber=$this->currentStackState()->stateNumber;
                $lhs=(string)$rule->lhs;
                if($lhs!='$accept')
                {
                        $nextStateNumber=$this->bisonTables->findNextStateNumberForLHS($stateNumber,$lhs);
                        $this->stackGoto($nextStateNumber,$lhs,$termsReduced);
                }
                 $this->debug("done: reducing rule $ruleNumber");
                return $termsReduced;
        }

        function stackGoto($stateNumber, $symbol, $termsReduced)
        {
                $this->debug("goto state $stateNumber");
                $this->stack[]=new StackState($stateNumber,new Token($symbol,$termsReduced,0,0,0));
                $this->debug("done: goto state $stateNumber");
                $stack=$this->debugPrintStack();
        }

        function reduceStack($rhs)
        {                
                $symbols=array();
                $rhsChildren=$rhs->children();

                //watch out. If the rhs is empty, it will contain the dummy child 'empty'
                //we must take it out
                if(count($rhsChildren)==1)
                {
                        if($rhsChildren->getName()=='empty')
                        {
                                //make it simply empty, as we would have
                                //expected in the first place
                                $rhsChildren=array();
                        }
                }

                foreach($rhsChildren as $symbol)
                {
                        $symbols[]=(string)$symbol;
                }

                $termsReduced=array();
                while(count($symbols)>0)
                {
                        $symbol=array_pop($symbols);
                        $stackState=array_pop($this->stack);
                        $stackState->symbol=$symbol;
                        $termsReduced[]=$stackState;                        
                }
                $termsReduced=array_reverse($termsReduced);
                $this->debug('terms reduced='.$this->debugGetStackElements($termsReduced));
                $stack=$this->debugPrintStack();
                return $termsReduced;
        }

        function shift($token)
        {       
                $nextStateNumber=
                        $this->bisonTables->findNextStateNumberForToken($this->currentStackState()->stateNumber,$token);
                $this->debug("shifting; next state is $nextStateNumber");
                $this->stack[]=new StackState($nextStateNumber,$token);
                $this->debug("done: shifting; next state is $nextStateNumber");
                $stack=$this->debugPrintStack();
        }

        function processReduceCallbacks($ruleNumber,$termsReduced)
        {
                if($this->defaultReduceCallback!=null)
                {
                        $function=$this->defaultReduceCallback;
                        $function($ruleNumber,$termsReduced);
                }
                if($this->reduceCallbacks!=null)
                {
                        if(array_key_exists('R'.$ruleNumber, $this->reduceCallbacks))
                        {
                                $reduceCallback=$this->reduceCallbacks['R'.$ruleNumber];
                                $reduceCallback($this,$termsReduced);
                        }
                }
        }                                

        function associateRuleNumberForRHSSymbol($symbol)
        {
                $ruleNumber=$this->bisonTables->findFirstRuleNumberForRHSSymbol($symbol);
                if($ruleNumber==null) $this->error("Cannot find rule number for RHS symbol '$symbol'");
                $this->ruleNumbers[$symbol]=$ruleNumber;
        }

        function associateRuleNumberForRHSSymbolAndNumberOfTerms($ruleName,$symbol,$numberOfTerms)
        {
                $ruleNumber=$this->bisonTables->findFirstRuleNumberForRHSSymbolAndNumberOfTerms($symbol,$numberOfTerms);
                if($ruleNumber==null) $this->error("Cannot find rule number for RHS symbol '$symbol'".
                                                        " and $numberOfTerms RHS terms");
                $this->ruleNumbers[$ruleName]=$ruleNumber;
        }

        function associateRuleNumberForLHSAndRHSSymbols($ruleName,$lhsSymbol,$rhsSymbol)
        {
                $ruleNumber=$this->bisonTables->findFirstRuleNumberForLHSANdRHSSymbols($lhsSymbol,$rhsSymbol);        
                if($ruleNumber==null) $this->error("Cannot find rule number for LHS symbol '$lhsSymbol'".
                                                        " and RHS symbol '$rhsSymbol' ");
                $this->ruleNumbers[$ruleName]=$ruleNumber;
        }

        function associateRuleNumberForLHSSymbol($ruleName,$lhsSymbol)
        {
                $ruleNumber=$this->bisonTables->findFirstRuleNumberForLHSSymbol($lhsSymbol);        
                if($ruleNumber==null) $this->error("Cannot find rule number for LHS symbol '$lhsSymbol'");
                $this->ruleNumbers[$ruleName]=$ruleNumber;
        }

        static function isTree($terms)
        {
                foreach($terms as $term)
                {
                        if(is_array($term->token->value)) return true;
                }
                return false;
        }

        static function debugPrintSingleLevel($terms)
        {
                foreach($terms as $term)
                {
                        echo $term->token->symbol.':'.$term->token->value.' ';
                }
        }

        static function debugPrintTree($terms)
        {
                if(self::isTree($terms))
                {
                        self::debugPrintNodes($terms,0);
                }
                else
                {
                        self::debugPrintSingleLevel($terms);
                }
                echo "\n";

        }

        static function debugPrintNodes($terms,$level)
        {

                $spaces='        ';
                for($i=0;$i<$level*2;$i++) $spaces.='--';
                foreach($terms as $term)
                {
                        echo "\n".$spaces.$term->token->symbol.':';
                        if(is_array($term->token->value)) self::debugPrintNodes($term->token->value,$level+1);
                        else echo $term->token->value;
                }
        }
}
?>

