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
}


