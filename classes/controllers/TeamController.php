<?php

require_once 'classes/controllers/Controller.php';
require_once 'classes/Team.php';

class TeamController extends Controller {
    public function get_all() {
        return Team::get_all();
    }

    public function get($id) {
        $result = Team::get($id);
        return isset($result) ? $result : null;
    }
}