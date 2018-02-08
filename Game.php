<?php
class Game extends Model{
    protected static $_tableName = 'game';
    protected static $_fields = array(
        'GameId',
        'Team1Id',
        'Team2Id',
        'ResultOfTeam1',
        'URL',
        'Date'
    );

    protected static $_idField = 'GameId';

}