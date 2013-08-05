<?php
    namespace XMLConfig;
    use \XMLConfig\lib\XMLConfigHandler as Config;

    require_once('lib/XMLConfigHandler.php');

    try{
        //Get a regular attribut from the config file
        echo Config::value('Email');

        //Get a value with boolean result
        if (Config::value('Notification')){
            echo "<br>Notification is on<br>";
        }else {
           echo "<br>Notification is off<br>";
        }

        //Nicht vorhandenes Attribut holen
        Config::value('HelloWorld');

        //Doesn't work, no special chars allowed
        //echo Config::value('_Email');

    }catch (\Exception $e){
        echo $e->getMessage();
    }

?>
