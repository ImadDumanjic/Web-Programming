<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));

class Config {
   public static function DB_NAME() {
       return Config::get_env("DB_NAME", "carrentalsystem");
   }
   public static function DB_PORT() {
       return Config::get_env("DB_PORT", 3306);
   }
   public static function DB_USER() {
       return Config::get_env("DB_USER", 'root');
   }
   public static function DB_PASSWORD() {
       return Config::get_env("DB_PASSWORD", 'imadex2004');
   }
   public static function DB_HOST() {
       return Config::get_env("DB_HOST", '127.0.0.1');
   }
   public static function JWT_SECRET() {
       return Config::get_env("JWT_SECRET", '46a9a994179e0090dad7f717250e457abf5bfa5bc40ca4c76dacae7b93767ea25090798d80d6833217aa70e770c9912dbf3a99abf20cefa1e803507a61c2eea9b02e0eb4c5f51d2c82ae75f9337cf5dfa2ba89ff3eea8382cbea7b923f520901fcc62a2fe4484042ab043c981f351e5a67a57581ffb1faa93b44194cb76911458201c0f7f142d4e4eec4bd9adf626d9f5c76c173bcbdefc086f5e314f6285b94ff1a1df295f4f1f7ed527d512f61467860bcc2e1f15492fd2003621cd7cd16e834471d1c4041ae8406084a234e0a0a666c89f5e10bb7f6ad8e66d2f0bf9b5bd454f80b5b4deb594d18022ccf3a4181e958848ee1577eedfd9bf314053d9e4abb');
   }
   public static function get_env($name, $default){
       return isset($_ENV[$name]) && trim($_ENV[$name]) != "" ? $_ENV[$name] : $default;
   }
}
