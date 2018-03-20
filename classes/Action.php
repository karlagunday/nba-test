<?php

require_once 'classes/Model.php';

class Action extends Model{
    protected static $_tableName = 'action';
    protected static $_fields = array(
        'GameId',
        'TeamId',
        'PlayerId',
        'Minutes',
        'FieldGoalsMade',
        'FieldGoalAttempts',
        '3PointsMade',
        '3PointAttempts',
        'FreeThrowsMade',
        'FreeThrowAttempts',
        'PlusMinus',
        'OffensiveRebounds',
        'DefensiveRebounds',
        'TotalRebounds',
        'Assists',
        'PersonalFouls',
        'Steals',
        'Turnovers',
        'BlockedShots',
        'BlocksAgainst',
        'Points',
        'Starter'
    );

    public static function getTotal($stat, $parentId, $parentType){
        if(in_array($stat, static::$_fields) && isset($parentId) && isset($parentType)){
            $parentField = $parentType . "Id";

            $sql = "
                SELECT SUM(" . $stat . ") AS total
                FROM
                    " . static::$_tableName . "
                WHERE
                    $parentField = '" . $parentId . "'
                LIMIT 0,1
            ";

            $result = static::query($sql);

            if(isset($result[0])){
                return $result[0]['total'];
            }

            return 0;
        }
        return false;
    }

    public static function getCurrentTeam($playerId){

        $sql = "
            SELECT a.TeamId, MAX(g.Date) AS last_game
              FROM action AS a
            INNER JOIN game AS g
              ON a.GameId = g.GameId
            WHERE a.PlayerId='" . $playerId . "'
            GROUP BY a.TeamId
            ORDER BY last_game DESC
            LIMIT 0,1
        ";

        $result = static::query($sql);
        if(!isset($result[0])){
            return null;
        }

        $teamId = $result[0]['TeamId'];
        return Team::get($teamId);

    }
}