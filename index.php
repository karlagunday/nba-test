<?php

include 'Model.php';
include 'Player.php';
include 'Action.php';
include 'Game.php';
include 'Team.php';

$players = Team::search(array(
            'TeamName' => 'Minnesota Timberwolves'
        )
    )->players();

foreach($players as $player){
    echo $player->describe() . "\n";
}




