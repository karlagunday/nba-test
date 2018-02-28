<?php

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
        $sql = "
            SELECT
            p.PlayerId, t.TeamId, SUM(a." . $stat . ") AS total
            FROM
                action AS a
            INNER JOIN player AS p
            ON a.PlayerId = p.PlayerId
            INNER JOIN team AS t
            ON a.TeamId = t.TeamId
            GROUP BY p.PlayerId
            HAVING t.TeamId = '" . $this->TeamId . "'
            ORDER BY total DESC
            LIMIT 0,1        
        ";

        $result = $this->query($sql);

        if(isset($result[0])){
            $player = new Player();
            return $player->retrieve($result[0]['PlayerId']);
        }

        return null;
    }

    public function total($stat){
        $total = Action::getTotal($stat, $this->TeamId, 'Team');
        return ($total  == false) ? "Invalid statistic: " . $stat : $total;
    }
}