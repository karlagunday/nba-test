<?php

/**
 * Created by PhpStorm.
 * User: karla_000
 * Date: 2/1/2018
 * Time: 8:16 PM
 */
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
}