<?php

use app\core\App;

class m0001_create_blogs_table
{
    public function up()
    {
        $db = App::$app->db;

        $SQL = "CREATE TABLE IF NOT EXISTS blogs (
                    id BIGINT AUTO_INCREMENT PRIMARY KEY,
                    title TEXT NOT NULL,
                    author VARCHAR(255) NOT NULL,
                    context LONGTEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

        $db->pdo->exec($SQL);
    }
}