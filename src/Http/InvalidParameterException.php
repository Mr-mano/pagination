<?php
namespace App\Http;

class InvalidParameterException extends \Exception {

    public function __construct(string $name, int $type)
    {
        if ($type === Request::INT) {
            $type = 'entier';
        } else if ($type === Request::STRING) {
            $type = 'chaine de caractère';
        }
        parent::__construct("Le paramètre '$name' n'est pas du bon type, $type attendu");
    }

}