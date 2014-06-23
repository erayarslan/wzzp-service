<?php
require_once dirname(__FILE__) . '/../utils/constants.php';

class main {
    public function __construct() {

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
        if($username == constants::admin_username
        && $password == constants::admin_password) {
            return constants::admin_token;
        } return false;
    }

    public function checkToken($token) {
        if($token == constants::admin_token) {
            return constants::admin_username;
        } return false;
    }
}


