<?php

namespace application\lib;

use PDO;
use PDOException;

class Loader
{
    
    public static function check() {
        if(!Loader::checkSettings()) {
            return false;
        }
        if(!Loader::checkDB()) {
            return false;
        }
        if(!Loader::checkHeadAdmin()) {
            return false;
        }
        return true;
    }

    public static function checkSettings() {
        $settings = Loader::getSettings();
        if(empty($settings)
            || !isset($settings['db'])
            || !isset($settings['db']['host'])
            || !isset($settings['db']['user'])
            || !isset($settings['db']['password'])
            || !isset($settings['db']['db_name'])) {
            return false;
        }
        return true;
    }

    public static function checkDB() {
        $result = false;
        $settings = Loader::getSettings();
        if($settings['db']['db_name'] === "") {
            return $result;
            //$settings['db']['db_name'] = "restaurant_helper";
            //Loader::setSettings($settings);
        }
        try {
            $db = new DataBase();
            $result = true;
        } catch (PDOException $e) {

        }
        return $result;
    }

    public static function checkHeadAdmin() {
        $db = new DataBase();
        $sql = "SELECT user_position.id_user FROM user_position"
            ." JOIN positions ON positions.id = user_position.id_position"
            ." WHERE positions.code_name = 'head_admin';";
        $rowCount = $db->rowCount($sql);
        return $rowCount > 0;
    }

    public static function setSettings($settings) {
        file_put_contents('application/config/settings.json', json_encode($settings));
    }
    public static function getSettings() {
        $path = 'application/config/settings.json';
        if(!file_exists($path)) {
            file_put_contents($path, '');
        }
        return json_decode(file_get_contents($path), true);
    }
}