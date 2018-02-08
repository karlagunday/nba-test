<?php


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

        $sql = "
            SELECT a.TeamId, MAX(g.Date) AS last_game
              FROM action AS a
            INNER JOIN game AS g
              ON a.GameId = g.GameId
            WHERE a.PlayerId='" . $this->PlayerId . "'
            GROUP BY a.TeamId
            ORDER BY last_game DESC
            LIMIT 0,1
        ";

        $result = $this->query($sql);
        if(!isset($result[0])){
            return null;
        }

        $teamId = $result[0]['TeamId'];
        return Team::get($teamId);
    }
}