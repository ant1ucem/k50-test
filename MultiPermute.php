<?php

include 'LinkedList.php';

/**
 * Class MultiPermute
 *
 * Generate permutations with efficient Aaron Williams algorithm 
 * http://webhome.cs.uvic.ca/~haron/
 */
class MultiPermute {

    private function init($multiset){
        sort($multiset);
        $list = new LinkedList();
        for($i = 0; $i<count($multiset); $i++){
            $list->insertFirst($multiset[$i]);
        }

        return [$list->_firstNode, $list->getNthElement(count($multiset) - 2), $list->getNthElement(count($multiset) - 1)];
    }

    private function visit(Node $list){
        $o = $list;
        $out = [];
        while($o !== null){
            $out[] = $o->data;
            $o = $o->next;
        }

        return $out;
    }

    public static function generate($multiset, Closure $callback){
        $l = self::init($multiset);

        list($head, $i, $j) = $l;
        $out = self::visit($head);
        $callback($out);

        while($j->next || $j->data < $head->data){
            if($j->next && $i->data >= $j->next->data){
                $s = $j;
            }else{
                $s = $i;
            }

            $t = $s->next;
            $s->next = $t->next;
            $t->next = $head;

            if($t->data < $head->data){
                $i = $t;
            }

            $j = $i->next;
            $head = $t;

            $callback(self::visit($head));
        }
    }
}