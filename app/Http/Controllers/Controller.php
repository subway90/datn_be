<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected $date_now;

    public function __construct() {
        $this->date_now = Date('Y-m-d H:i:s');
    }
}
