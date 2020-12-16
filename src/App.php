<?php
namespace App;

use \PDO;

class App {

    /**
     * PDO;
     */
    private $pdo; 

    private $isDev;

    public function __construct($isDev = false)
    {
        $this->isDev = $isDev;
        if ($isDev) {
            define('DEBUG_TIME', microtime(true));
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
        }
    }

    public function getPDO (): PDO
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO('mysql:dbname=tutoblog;host=localhost', 'root', 'root', [
               PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        }
        return $this->pdo;
    }

}