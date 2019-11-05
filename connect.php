<?php
     define('DB_DSN','mysql:host=localhost;dbname=GOAT_CMS;charset=utf8'); //db url
     define('DB_USER','AlanSimpson'); //username
     define('DB_PASS','Password01'); //password     
     
     try {
         $db = new PDO(DB_DSN, DB_USER, DB_PASS);
     } catch (PDOException $e) {
         print "Error: " . $e->getMessage();
         die(); 
     }
 ?>