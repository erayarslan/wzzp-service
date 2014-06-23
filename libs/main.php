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
        } return array(
            constants::error => constants::not_found
        );
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


