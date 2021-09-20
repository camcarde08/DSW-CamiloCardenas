<?php

require 'utils/catfan/Medoo/medoo.php';

class MedooDbModelClass {

    private $dbName;
    private $host;
    private $dbPort;
    private $user;
    private $password;

    public function __construct() {
        $xml = simplexml_load_file('config/systemParameters.xml');
        
        $this->dbName = (string) $xml->dbParameters->dbName;
        $this->host = (string) $xml->dbParameters->dbHost;
        $this->dbPort = (string) $xml->dbParameters->dbPort;
        $this->user = (string) $xml->dbParameters->userDb;
        $this->password = (string) $xml->dbParameters->passwordDb;
    }

    public function conection() {
        $database = new medoo([
            'database_type' => 'mysql',
            'database_name' => $this->dbName,
            'server' => $this->host,
            'username' => $this->user,
            'password' => $this->password,
            'charset' => 'utf8',
            'port' => $this->dbPort,
            'prefix' => 'sgm_'
        ]);
        return $database;
    }
    
   

}
