<?php
class Database {
    private const string HOST = 'localhost';
    private const string DBNAME = 't-management';
    private const string USER = 'root';
    private const string PASS = 'root';
    private static ?PDO $pdo = null;

    public static function getInstance(): PDO {
        if (self::$pdo === null) {
            try {
                $options = [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ];
                self::$pdo = new PDO("mysql:host=".self::HOST.";dbname=".self::DBNAME,self::USER,self::PASS, $options);
                return self::$pdo;
            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}