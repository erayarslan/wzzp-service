<?php
require dirname(__FILE__) . '/../third-party/rb/rb-p533.php';

// do u think that fucking smart?
// please h'ck me!

define("DB_HOST", "94.73.144.187");
define("DB_NAME", "wzzp_db");
define("DB_USER", "wzzp_root");
define("DB_PASS", "db123456");

R::setup('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS); // uh :(