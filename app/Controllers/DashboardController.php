<?php
namespace App\Controllers;

use \App\Models\EtudiantModel;

class DashboardController extends BaseController
{
    public function index()
    {
        // Statistiques rapides
        $etudiantModel = new EtudiantModel();
        // $noteModel = new \App\Models\NoteModel();
        
        $data = [
            'userEmail' => session()->get('userEmail'),
            'totalEtudiants' => $etudiantModel->countAll()
            // 'totalNotes' => $noteModel->countAll()
        ];
        
        return view('dashboard', $data);
    }
}