<?php
/**
 * XMLConfigHandler
 *
 * Date:    05.08.13
 * Time:    19:54
 * Project: XMLConfigurator
 *
 * @package XMLConfig\lib
 * @version 1.0
 * @author Dario De Lucia <dario@de-lucia.ch>
 *
 * With this class it's possible to use a configuration file as an object.
 * The only usable method from outside is XMLConfigHandler::value($valuename)
 * If the XML value exists it will be returned. Otherwise an Exception is raised.
 *
 */
namespace XMLConfig\lib;

class XMLConfigHandler extends \SimpleXMLElement
{

    /**
     * Configuration File
     * @access private
     * @var file
    */
    private static  $file       = null;

    /**
     * Instance of this class
     * @access private
     * @var XMLConfig\lib\XMLConfigHandler
    */
    private static  $_instance  = null;

    /**
     * Create an instance of this class for the use of the XML Config
     * file. The config file must be either in the same folder as this
     * class, or in the main folder of the project. If no config file
     * was found, an Exception is raised.
     *
     * @static
     * @access private
     * @return XMLConfigHandler Instance of this class
     * @throws \Exception
    */
    private static function Instance()
    {
        if (static::$file == null)
            static::$file = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'config.xml';

        if (!file_exists(static::$file)) {
            //Config file was not found, let's try with the main root of the project
            static::$file = realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config.xml';

            //If the config file is still not found, it's time to throw an Exception and exit
            if (!file_exists(static::$file)) {
                throw new \Exception("No configuration file (config.xml) found");
            }
        }

        //Configuration file was found, let's build an instance of this class
        if (null == static::$_instance)
            static::$_instance = new self(static::$file, null, true);

        return static::$_instance;
    }


    /**
     * Main method for this class. With an existing parameter the value in the config
     * file is returned. In case the XML config value is a String with true/false,
     * the method delivers back a boolean of true or false. If the method is called
     * with a non existing XML Attribut, an Exception is thrown.
     *
     * @static
     * @param string $i_xmlname XML Attribut name
     * @return var Value of the XML Attribut
     * @throws \Exception
    */
    public static function value($i_xmlname){

        //Check if the static instance is already there
        if (static::$_instance == null) {
            static::$_instance = static::Instance();
        }

        //Security check, only a string without special signs is allowed as input
        if(!is_string($i_xmlname) OR !preg_match("/^[a-zA-Z0-9]+$/s",$i_xmlname)) {
            throw new \Exception ("Invalid Value name: Only letters and digits allowed");
        }

        //Check if the wanted XML value exists in the config file
        if (!isset(static::$_instance->$i_xmlname)) {
            throw new \Exception ("XML Attribut ($i_xmlname) existiert nicht");
        }else{
            //Return the requestet config file value
            return static::checkBoolean(static::$_instance->$i_xmlname);
        }
    }

    /**
     * Check if the XML Config value is true or false (doesn't matter if lower-/uppercase),
     * the method delivers back a boolean value of true or false. If the XML Config value
     * is not true or false, the String value is returned.
     *
     * @static
     * @access private
     * @param $i_xmlValue string XML Attribut name
     * @return var Value of the XML Attribut
    */
    private static function checkBoolean($i_xmlValue) {
        switch (strtoupper($i_xmlValue)) {
            case 'TRUE':
                $o_value = true;
                break;
            case 'FALSE':
                $o_value = false;
                break;
            default:
                $o_value = $i_xmlValue;
        }

        return $o_value;
    }
}

?>