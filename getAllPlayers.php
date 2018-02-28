<?php

include 'classes/Model.php';
include 'classes/Player.php';
include 'classes/Action.php';
include 'classes/Game.php';
include 'classes/Team.php';

$players = Player::getAll(10);

echo json_encode($players);

die();