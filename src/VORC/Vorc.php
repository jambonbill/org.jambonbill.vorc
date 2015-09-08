<?php

namespace VORC;

class Vorc
{
	private $db;
	public function __construct ()
    {
        // Create PDO object
        $pdo=new \PDO\Pdo;
        $this->db=$pdo->db();
    }

    /**
     * [db description]
     * @return [type] [description]
     */
    public function db()
    {
        return $this->db;
    }
}
