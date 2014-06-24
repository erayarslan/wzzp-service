<?php
include_once dirname(__FILE__) . '/../configs/db.php';

class userService {
    public static function getUserByUsername($username) {
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

