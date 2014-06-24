<?php
require_once dirname(__FILE__) . '/../utils/constants.php';
include_once dirname(__FILE__) . '/../configs/db.php';


class main {
    function __construct() {
        if ($handle = opendir("./..".constants::servicesPath)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") { include dirname(__FILE__) . "/.." . constants::servicesPath .$entry; }
            } closedir($handle);
        }
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
            constants::db_users,
            ' username = :username and password = :password ',
            array(':username' => $username, ':password' => $password)
        );

        if($user) {
            return $this->newToken($user->id);
        } return array(
            constants::error => constants::not_found
        );
    }

    public function checkToken($token) {
        $token = R::findOne(
            constants::db_tokens,
            ' token = :token ',
            array(':token' => $token)
        );

        if($token) {
            return array(
                constants::info => $token->user_id
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
                constants::info => $generatedToken
            );
        } else {
            return array(
                constants::error => constants::fucked_up
            );
        }
    }
}


