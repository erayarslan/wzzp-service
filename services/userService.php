<?php
include_once dirname(__FILE__) . '/../configs/db.php';

class userService {
    public static function getUserByUsername($userId) {
        $user = R::findOne(
            constants::db_users,
            ' id = :id ',
            array(':id' => $userId)
        );

        if($user) {
            return R::exportAll($user);
        } return array(
            "type" => constants::error,
            "message" => constants::not_found
        );
    }
}

