<?php
class MySQLiDatabase{
    protected $localhost;
    protected $username;
    protected $password;
    protected $database; 
    public $MySQLi;

    function __construct($localhost,$username,$password,$database)
    {
        $this->localhost=$localhost;
        $this->username=$username;
        $this->password=$password;
        $this->database=$database;

        $this->connect();
    }
    function connect(){
        $this->MySQLi=new \MySQLi($this->localhost,$this->username,$this->password,$this->database);
    }
    function sendQuery($query){
        return $this->MySQLi->query($query);
    }
    function fetchArray($result){
        return $result->fetch_array(MYSQLI_ASSOC);
    }
   
}
