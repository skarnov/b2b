<?php

namespace App\Controllers;

class Migrate extends \CodeIgniter\Controller {

    public function index() {
        $migrate = \Config\Services::migrations();

        try {
            $migrate->latest();
            echo 'Migration Success';
            exit();
        } catch (\Throwable $e) {
            echo 'Migration Failed' . $e;
            exit();
        }
    }
}