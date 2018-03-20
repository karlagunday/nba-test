<?php

require_once 'classes/Model.php';

class Player extends Model{
    protected static $_tableName = 'player';
    protected static $_fields = array(
        'PlayerId',
        'PlayerName'
    );
    protected static $_idField = 'PlayerId';

    public function describe() {
        return $this->PlayerName;
    }

    public function team() {
        return Action::getCurrentTeam($this->PlayerId);
    }

    public function gamesPlayed(){

    }

    public function total($stat){
        $total = Action::getTotal($stat, $this->PlayerId, 'Player');
        return ($total  == false) ? "Invalid statistic: " . $stat : $total;
    }
}