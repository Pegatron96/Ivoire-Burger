<?php

class Database
{
   private static $dbHost = "localhost";

   private static $dbName = "ivoire_burger";

   private static $dbUsername = "root";

   private static $dbUserpassword = "";

   private static $connection = null;

   private $db;

   public static function connect()
   {
       if(self::$connection == null)
       {
           try
           {
               self::$connection = new PDO("mysql:host=". self::$dbHost . ";dbname=". self::$dbName, self::$dbUsername, self::$dbUserpassword);

           }

           catch (PDOException $e)
           {
               die("Erreur" . $e->getMessage());
           }

           return self::$connection;
        }

   }



   public static function disconnect()
   {
       self::$connection = null;

   }

}
