<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adodb_loader {

    function __construct() {
        // check if adodb already loaded
        if (!class_exists('ADONewConnection')) {
            //require_once(APPPATH.'libraries/adodb5/adodb.inc'.EXT);
            require_once(BASEPATH . 'libraries/adodb5/adodb.inc' . EXT);
        }
    }

    function load($group = 'read') {
        $dbg = !empty($group) ? $group : '';
        $this->_init_adodb_library($dbg);
    }

    function _init_adodb_library($db_group) {
        // get CI instance
        $CI = & get_instance();

        // get database config
        $config_database = APPPATH.'config/'.ENVIRONMENT.'/database'.EXT;
        if(!file_exists($config_database)){
        	$config_database = APPPATH.'config/database'.EXT;
        }
        include($config_database);
        // check which database group settings to use
        // default to database setting default
        $db_group = (!empty($db_group)) ? $db_group : $active_group;
        $cfg = $db[$db_group];

        $dbh = !empty($cfg['alias']) ? $cfg['alias'] : 'adodb';

        if (isset($CI->$dbh) && $CI->$dbh instanceof ADODB_mysql) {
            return true;
        }

        // check that driver is set
        if (isset($cfg['dbdriver'])) {
            $CI->$dbh = & ADONewConnection($cfg['dbdriver']);

            // set debug
            $CI->$dbh->debug = $cfg['db_debug'];

            // check for persistent connection
            if ($cfg['pconnect']) {
                // persistent
                $CI->$dbh->PConnect($cfg['hostname'], $cfg['username'], $cfg['password'], $cfg['database']) or die("can't do it: " . $CI->$dbh->ErrorMsg());
            } else {
                // normal
                $CI->$dbh->Connect($cfg['hostname'], $cfg['username'], $cfg['password'], $cfg['database']) or die("can't do it: " . $CI->$dbh->ErrorMsg());
            }

            if ($cfg['char_set'] && $cfg['dbcollat']) {
                $CI->$dbh->Execute('SET character_set_results=' . $cfg['char_set']);
                $CI->$dbh->Execute('SET collation_connection=' . $cfg['dbcollat']);
                $CI->$dbh->Execute('SET NAMES ' . $cfg['char_set']);
            }
            // use associated array as default format
            $CI->$dbh->SetFetchMode(ADODB_FETCH_ASSOC);
        } else {
            die("database settings not set");
        }
    }

    
}
