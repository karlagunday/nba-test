<?php

include 'Model.php';
include 'Player.php';
include 'Action.php';
include 'Game.php';
include 'Team.php';


//$results = Game::search(1);

$player = new Player(array(
    'PlayerName' => 'Karl Agunday'
));

$player->save();

echo Player::get(23)->team()->describe();



