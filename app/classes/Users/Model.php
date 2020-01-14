<?php


namespace App\Users;


use Core\Database\FileDB;

class Model
{
    private $db;
    private $table_name = 'users';

    public function __construct()
    {
        $this->db = new \Core\Database\FileDB(DB_FILE);
        $this->db->createTable($this->table_name);
        var_dump($this->db);
    }

    public function insert(Users $user) {
        $this->db->insertRow($this->table_name, $user->getData());
    }
}

