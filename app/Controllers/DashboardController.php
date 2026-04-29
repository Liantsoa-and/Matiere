<?php
namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        // Le filtre auth garantit qu'on est connecté
        $data = [
            'userEmail' => session()->get('userEmail')
        ];
        return view('dashboard', $data);
    }
}