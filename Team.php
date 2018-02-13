<?php

/**
 * Created by PhpStorm.
 * User: karla_000
 * Date: 2/1/2018
 * Time: 8:16 PM
 */
class Team extends Model{
    protected static $_tableName = 'team';
    protected static $_fields = array(
        'TeamId',
        'TeamName'
    );

    protected static $_idField = 'TeamId';


    public function describe() {
        return $this->TeamName;
    }

    public function players(){
        $sql = "
            SELECT a.PlayerId as PlayerId, MAX(g.Date) AS last_game
            FROM
              action AS a
            INNER JOIN game AS g 
              ON a.GameId = g.GameId
            WHERE a.TeamId = '" . $this->TeamId . "'
            GROUP BY a.PlayerId
            ORDER BY last_game
        ";

        $results = $this->query($sql);

        $players = array();
        if(isset($results[0])){
            foreach ($results as $result){
                $player = new Player();
                $players[] = $player->retrieve($result['PlayerId']);

            }
        }
        return $players;
    }

    public function leaderIn($stat){

    }
}