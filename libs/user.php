<?php
require dirname(__FILE__) . '/../third-party/rb/rb-p533.php';

class user {
    public function __construct() {
        R::setup('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS);
    }

    public function getUserByUsername($username) {
        $user = R::findOne(
            constants::db_users,
            ' username = :username ',
            array(':username' => $username)
        );

        if($user) {
            return R::exportAll($user);
        } return array(
            constants::error => constants::not_found
        );
    }
}