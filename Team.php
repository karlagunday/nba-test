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
}