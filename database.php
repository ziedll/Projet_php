<?php

class Database
{
    //  Paramètres de connexion 
    private static string $host     = 'localhost';
    private static string $dbName   = 'nexus_hub';
    private static string $charset  = 'utf8mb4';
    private static string $user     = 'root';   
    private static string $password = '';        

    private static ?PDO $instance = null;

    // Constructeur privé une seule connexion PDO
    private function __construct() {}

 
        public static function getInstance(): PDO
        {
            if (self::$instance === null) {
                $dsn = sprintf(
                    'mysql:host=%s;dbname=%s;charset=%s',
                    self::$host,
                    self::$dbName,
                    self::$charset
                );

                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                try {
                    self::$instance = new PDO($dsn, self::$user, self::$password, $options);
                } catch (PDOException $e) {
                    throw new RuntimeException('Connexion à la base de données impossible : ' . $e->getMessage());
                }
            }

            return self::$instance;
        }
    }