<?php
/*
	Phnom Penh, Cambodia, December 2011
	Written by Erik Poupaert, erik@sankuru.biz
	Licensed under the LGPL
*/

/*
--------------
BisonTables class
--------------
*/

class BisonTables
{
        var $xmlDocument=null;

        /* -----------------------------
                constructor
        -----------------------------*/

        function __construct($xmlString)
        {
                $this->xmlDocument=new SimpleXMLElement($xmlString);
        }

        /* -----------------------------
                error handling 
        -----------------------------*/

        function error($msg)
        {
                throw new Exception($msg);
        }

        function tokenError($msg,$token)
        {
                $this->error($msg.": '".$token->symbol."' with value '". $token->value ."' in line ".
                                $token->lineNumber.' column '.$token->columnNumber.'.');
        }

        /* -----------------------------
                xpath
        -----------------------------*/

        function xpath($query)
        {
                return $this->xmlDocument->xpath($query);
        }

        function isEmpty($array)
        {
                if(count($array)==0)
                        return true;
                else return false;
        }

        /* -----------------------------
                finders
        -----------------------------*/

        function findReductions($stateNumber)
        {
                $query="automaton/state[@number='$stateNumber']/actions/reductions/reduction";
                return $this->xpath($query);
        }

        function findTransitions($stateNumber,$type)
        {
                $query="automaton/state[@number='$stateNumber']/actions/transitions/transition[@type='$type']";
                return $this->xpath($query);
        }

        function findLookaheads($stateNumber)
        {
                $query="automaton/state[@number='$stateNumber']/itemset/item/lookaheads/symbol";
                return $this->xpath($query);
        }

        function findSolvedConflicts($stateNumber)
        {
                $query="automaton/state[@number='$stateNumber']/solved-conflicts/resolution";
                return $this->xpath($query);
        }

        function defaultRuleNumberForStateNumber($stateNumber)
        {
                $query="automaton/state[@number='$stateNumber']/actions/reductions/reduction";
                $result=$this->xpath($query);
                $result=$result[0]; //take first rule
                return intval($result['rule']);
        }

        function findRule($ruleNumber)
        {
                $query="grammar/rules/rule[@number='$ruleNumber']";
                $result=$this->xpath($query);
                $result=$result[0]; //take first rule
                return $result;
        }

        function findRuleNumbers()
        {
                $query="grammar/rules/rule/@number";
                $result=$this->xpath($query);
                return $result;
        }

        function findRuleNumbersForRHSSymbol($symbol)
        {
                $ruleNumbers=array();
                $allRuleNumbers=$this->findRuleNumbers();
                foreach($allRuleNumbers as $ruleNumber)
                {
                        $ruleNumber=$ruleNumber['number'];
                        if($this->hasRHSSymbol($ruleNumber,$symbol))
                        {
                                $ruleNumbers[]=$ruleNumber;
                        }
                }    
                return $ruleNumbers;
        }

        function findFirstRuleNumberForRHSSymbol($symbol)
        {
                $ruleNumbers=$this->findRuleNumbersForRHSSymbol($symbol);
                if(count($ruleNumbers)>0) return intval($ruleNumbers[0]);
                else return null; //not found
        }

        function findRHSSymbolsForRuleNumber($ruleNumber)
        {
                $query="grammar/rules/rule[@number=$ruleNumber]/rhs/symbol";
                $result=$this->xpath($query);
                return $result;
        }

        function findLHSForRuleNumber($ruleNumber)
        {
                $query="grammar/rules/rule[@number=$ruleNumber]/lhs";
                $result=$this->xpath($query);
                return $result[0];
        }

        function findFirstRuleNumberForRHSSymbolAndNumberOfTerms($symbol,$numberOfTerms)
        {
                $ruleNumbers=$this->findRuleNumbersForRHSSymbol($symbol);
                foreach($ruleNumbers as $ruleNumber)
                {
                        $ruleNumber=$ruleNumber[0];
                        $terms=$this->findRHSSymbolsForRuleNumber($ruleNumber);
                        $count=count($terms);
                        if($count==$numberOfTerms) return intval($ruleNumber);
                }
                return null; //not found
        }

        function findFirstRuleNumberForLHSANdRHSSymbols($lhsSymbol,$rhsSymbol)
        {
                $ruleNumbers=$this->findRuleNumbersForRHSSymbol($rhsSymbol);
                foreach($ruleNumbers as $ruleNumber)
                {
                        $ruleNumber=$ruleNumber[0];
                        $lhs=$this->findLHSForRuleNumber($ruleNumber);
                        if($lhs==$lhsSymbol) return intval($ruleNumber);
                }
                return null; //not found
        }

        function findFirstRuleNumberForLHSSymbol($symbol)
        {
                $ruleNumbers=$this->findRuleNumbers();
                foreach($ruleNumbers as $ruleNumber)
                {
                        $ruleNumber=$ruleNumber[0];
                        $lhs=$this->findLHSForRuleNumber($ruleNumber);
                        if($lhs==$symbol) return intval($ruleNumber);
                }
                return null; //not found                                
        }

        /* -----------------------------
                check rule situation
        -----------------------------*/
        function hasRHSSymbol($ruleNumber,$symbol)
        {
                $query="grammar/rules/rule[@number='$ruleNumber']/rhs[symbol='$symbol']";
                $result=$this->xpath($query);
                if(count($result)>0) return true;
                else return false;
        }
        /* -----------------------------
                find for token
        -----------------------------*/

        function findNextStateNumberForToken($stateNumber,$token)
        {
                $transitions=$this->findTransitions($stateNumber,'shift');
                foreach($transitions as $transition)
                {
                        if($transition['symbol']==$token->symbol)
                        {
                                return intval($transition['state']);
                        }
                }
                $this->tokenError("unexpected token",$token);
        }

        function findNextStateNumberForLHS($stateNumber,$symbol)
        {
                $transitions=$this->findTransitions($stateNumber,'goto');
                foreach($transitions as $transition)
                {
                        if($transition['symbol']==$symbol)
                        {
                                return intval($transition['state']);
                        }
                }
                $this->error("unexpected LHS '$symbol'.");
        }

        function findSolvedConflictOperation($stateNumber,$token)
        {
                $solvedConflicts=$this->findSolvedConflicts($stateNumber);
                foreach($solvedConflicts as $solvedConflict)
                {
                        if($solvedConflict['symbol']==$token->symbol)
                        {
                                return $solvedConflict['type'];
                        }                        
                }
                $this->error("Cannot find solved conflict for '$symbol' in state $stateNumber.");
        }

        function hasUnsolvedConflictForLookahead($stateNumber,$token)
        {
                $reductions=$this->findReductions($stateNumber);
                foreach($reductions as $reduction)
                {
                        if($reduction['symbol']==$token->symbol && $reduction['enabled']=='false')
                        {
                                return true;
                        }
                }
                return false;
        }

        /* -----------------------------
                check state situation
        -----------------------------*/

        function hasReductions($stateNumber)
        {
                return !$this->isEmpty($this->findReductions($stateNumber));
        }


        function hasLookaheads($stateNumber)
        {
                return !$this->isEmpty($this->findLookaheads($stateNumber));
        }


        function hasSolvedConflicts($stateNumber)
        {
                return !$this->isEmpty($this->findSolvedConflicts($stateNumber));
        }

        /* -----------------------------
                check state/token situation
        -----------------------------*/

        function hasSolvedConflict($stateNumber,$token)
        {
                $solvedConflicts=$this->findSolvedConflicts($stateNumber);
                foreach($solvedConflicts as $solvedConflict)
                {
                        if((string)$solvedConflict['symbol']==$token->symbol) return true;
                }
                return false;
        }

        function hasLookahead($stateNumber,$token)
        {
                $lookaheads=$this->findLookaheads($stateNumber);
                foreach($lookaheads as $lookahead)
                {
                        if((string)$lookahead == $token->symbol) return true; 
                }
                return false;
        }
}

?>

