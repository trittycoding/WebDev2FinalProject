<?php

define('ADMIN_LOGIN','1');

define('ADMIN_PASSWORD','Password01');

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])

    || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)

    || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) {

  header('HTTP/1.1 401 Unauthorized');

  header('WWW-Authenticate: Basic realm="Our Blog"');

  exit(": Username and password required.");

}

 

?>