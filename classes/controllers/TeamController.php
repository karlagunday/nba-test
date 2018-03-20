<?php

require_once 'classes/controllers/Controller.php';
require_once 'classes/Team.php';

class TeamController extends Controller {
    public function summary() {
        $results = Team::getAll();

        $teams = array();
        foreach ($results  as $team){
            $teams[$team->TeamId] = $team->TeamName;
        }

        return $teams;
    }
}