<?php
class Database{
 
   
    private $host = 'localhost';
    private $dbName = 'xevrrerf_crudapp';
    private $username = 'xevrrerf_op0';
    private $password = 'b2C1#.3CFb@23%^';
    public  $connection = null;
 
    public function Connect(){
 
     $this->connection =  new mysqli($this->host, $this->username, $this->password, $this->dbName);
	 //$this->connection->set_charset("utf8");
	 
	 
 
     return $this->connection;
    }
}
?>