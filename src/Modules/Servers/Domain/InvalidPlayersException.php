<?php

namespace App\Modules\Servers\Domain;

class InvalidPlayersException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Przesłano nieprawidłową liczbę graczy');
    }
}