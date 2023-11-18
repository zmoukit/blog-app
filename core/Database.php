<?php

namespace Core;

use PDO;

class Database
{
    /**
     * @var PDO $pdo
     */
    public PDO $pdo;

    /**
     * Database constructor
     * 
     * @param array $config
     */
    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new PDO($dsn, $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * 
     */
    /**
     * Get PDO statement
     * 
     * @param string $sql
     * 
     * @return 
     */
    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
}
