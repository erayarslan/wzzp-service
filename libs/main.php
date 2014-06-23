<?php
require_once dirname(__FILE__) . '/../utils/constants.php';
require_once dirname(__FILE__) . '/../configs/db.php';
require dirname(__FILE__) . '/../third-party/rb/rb-p533.php';

class main {
    public function __construct() {
        R::setup('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS);
    }

    public function errorNotFound() {
        return array(
            constants::error => constants::not_found
        );
    }

    public function status() {
        return array(
            constants::version => constants::version_number
        );
    }

    public function auth($username, $password) {
        $user = R::findOne(
            'users',
            ' username = :username and password = :password ',
            array(':username' => $username, ':password' => $password)
        );

        if($user) {
            return constants::admin_token;
        } return false;
    }

    public function checkToken($token) {
        if($token == constants::admin_token) {
            return constants::admin_username;
        } return false;
    }
}


