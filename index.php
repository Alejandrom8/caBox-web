<?php
  $config = json_decode(
    file_get_contents("config.json")
  );

  //se especifica la configuracion 
  define("URL", $config->URL);

  define("USER", $config->WEBHOST->USER);
  define("HOST", $config->WEBHOST->HOST);
  define("PASSWORD", $config->WEBHOST->PASSWORD);
  define("DB", $config->WEBHOST->DB);
  define("CHARSET", $config->WEBHOST->CHARSET);

  define("PREFIJO", $config->PREFIJO);
  
  define(
    "PREFIJOS_PERSONALES",
     explode(
       ",",
       $config->PREFIJOS_PERSONALES
      )
  );

  require_once "arq/connection.php";
  require_once "arq/model.php";
  require_once "arq/controller.php";
  require_once "arq/view.php";

  require_once "arq/app.php";

  $app = new App();

