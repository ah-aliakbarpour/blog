<?php


use app\core\App;

class m0002_create_users_table
{
    public function up()
    {
        $db = App::$app->db;

        $SQL = "CREATE TABLE IF NOT EXISTS users (
                    id BIGINT AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    access INT DEFAULT 0 NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                );";

        $db->pdo->exec($SQL);
    }
}