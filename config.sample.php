<?php
  $baseUrl = "http://localhost/";
  $basePath = "/";

  //APP CONFIG
  app()->config('debug', false);
  app()->config("app.down", false);

  //BLADE
  app()->blade = new Leaf\Blade;
  app()->blade->configure("templates", "templates/cache");

  //AUTH
  auth()->config('DB_TABLE', 'users');
  auth()->config('PASSWORD_KEY', 'Password');
  auth()->config('ID_KEY', 'UserID');
  auth()->config("LOGIN_PARAMS_ERROR", "Username o password non corretti!");
  auth()->config("LOGIN_PASSWORD_ERROR", "Username o password non corretti!");
  auth()->config("USE_SESSION", true);
  auth()->config("GUARD_HOME", $basePath);
  auth()->config("GUARD_LOGIN", $basePath . "auth/login");

  setlocale(LC_TIME, 'it_IT');