<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));

class Config {
   public static function DB_NAME() {
       return Config::get_env("DB_NAME", "defaultdb");
   }
   public static function DB_PORT() {
       return Config::get_env("DB_PORT", 25060);
   }
   public static function DB_USER() {
       return Config::get_env("DB_USER", 'doadmin');
   }
   public static function DB_PASSWORD() {
       return Config::get_env("DB_PASSWORD", 'AVNS_wjzlLgdcTA7oBWV6CP_ ');
   }
   public static function DB_HOST() {
       return Config::get_env("DB_HOST", 'db-mysql-fra1-35233-do-user-22847389-0.d.db.ondigitalocean.com');
   }
   public static function JWT_SECRET() {
       return Config::get_env("JWT_SECRET", '55955718d39f6041379ee3139e10d9347f6c1cfddb670381a2c49932e1bfb7981ff5cc7a80ab5b7cc3f1d61b0a3453667081b9dbb27383cb9bcc4e4895e04258372398b6273ee1cb7605d042a3740ae5535484124e32cd327a4a7d2d2bdb43fe624ffedbdd54d6f951ea1216db39bb8ea373525f983629d938e3a8dd19451891126c6925a34a60c4b99ee5fed31e0cd0e62e5774749fe5780260cff9a5269f8d52ab3f8916543fccd56eb2129c3c58b3847f779f6cdfd7bcfca4566194334a759f40f50cf9d32ed9e4f0ca2daf022bbf543b7b4a67321fa9c4076de7b52c078997b958f337bcfd52dc564712d46114d1c08c15240821379edaa298fd09eceb4f');
   }
       public static function get_env($name, $default){
       return isset($_ENV[$name]) && trim($_ENV[$name]) != "" ? $_ENV[$name] : $default;
   }
}
