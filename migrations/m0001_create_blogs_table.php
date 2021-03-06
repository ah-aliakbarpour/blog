<?php


use app\core\App;

class m0001_create_blogs_table
{
    public function up()
    {
        $db = App::$app->db;

        $SQL = "CREATE TABLE IF NOT EXISTS blogs (
                    id BIGINT AUTO_INCREMENT PRIMARY KEY,
                    user_id BIGINT NOT NULL,
                    title TEXT NOT NULL,
                    context LONGTEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";

        $db->pdo->exec($SQL);
    }
}