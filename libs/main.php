<?php
require_once dirname(__FILE__) . '/../utils/constants.php';
include_once dirname(__FILE__) . '/../configs/db.php';


class main {
    function __construct() {
        // service injection
        $folder = dirname(__FILE__) . "/.." . constants::servicesPath;
        if ($handle = opendir($folder)) {
            while (false !== ($entry = readdir($handle))) { if ($entry != "." && $entry != "..") { include $folder.$entry; } }
            closedir($handle);
        }
    }

    public function errorNotFound() {
        return array(
            "type" => constants::error,
            "message" => constants::not_found
        );
    }

    public function status() {
        return array(
            constants::version => constants::version_number
        );
    }

    public function auth($username, $password) {
        $user = R::findOne(
            constants::db_users,
            ' username = :username and password = :password ',
            array(':username' => $username, ':password' => $password)
        );

        if($user) {
            return $this->newToken($user->id);
        } return array(
            "type" => constants::error,
            "message" => constants::not_found
        );
    }

    public function logout($token) {
        $tokenMatch = R::findOne(
            constants::db_tokens,
            ' token = :token ',
            array(':token' => $token)
        );
        R::trash($tokenMatch);
    }

    public function checkToken($token) {
        $tokenMatch = R::findOne(
            constants::db_tokens,
            ' token = :token ',
            array(':token' => $token)
        );

        if($tokenMatch) {
            return array(
                constants::info => $tokenMatch->user_id
            );
        } return false;
    }

    private function newToken($userId) {
        $generatedToken = md5(uniqid(rand(), true));

        $token = R::dispense(constants::db_tokens);

        $token->user_id = $userId;
        $token->token = $generatedToken;
        $id = R::store($token);

        if($id) {
            return array(
                "type" => "token",
                "message" => $generatedToken,
                "id" => $userId
            );
        } else {
            return array(
                constants::error => constants::fucked_up
            );
        }
    }
}


