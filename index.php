<?php
  include("vendor/autoload.php");
  include("secret.php");
  
  foreach (glob("./modules/*.php") as $filename){
    include $filename;
  }

  db()->connect([
    'dbtype' => 'mysql',
    'charset' => 'utf8',
    'host' => $dbhost,
    'username' => $dbuser,
    'password' => $dbpass,
    'dbname' => $dbname,
  ]);

  include("config.php");

  include("router.php");
  
  app()->run();