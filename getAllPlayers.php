<?php

include 'classes/Model.php';
include 'classes/Player.php';
include 'classes/Action.php';
include 'classes/Game.php';
include 'classes/Team.php';

$items = isset($_REQUEST['items']) ? $_REQUEST['items'] : NULL;
$start = isset($_REQUEST['start']) ? $_REQUEST['start'] : NULL;

$players = Player::getAll($items, $start);

echo json_encode($players);

die();