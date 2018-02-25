<?php

include 'Model.php';
include 'Player.php';
include 'Action.php';
include 'Game.php';
include 'Team.php';

$player = Player::search( [ 'PlayerName' => 'Lebron James' ] );
echo $player->team()->leaderIn('Points')->describe();



