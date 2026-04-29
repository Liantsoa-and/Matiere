<?php
namespace App\Controllers;

use App\Models\EtudiantModel;

class EtudiantController extends BaseController
{
    protected $etudiantModel;

    public function __construct()
    {
        $this->etudiantModel = new EtudiantModel();
    }

    /**
     * Affiche la liste des étudiants
     */
    public function index()
    {
        // Récupérer le terme de recherche
        $keyword = $this->request->getGet('search');
        
        // Récupérer les étudiants
        $etudiants = $this->etudiantModel->search($keyword);
        
        // Pagination (optionnel)
        $perPage = 10;
        $currentPage = $this->request->getGet('page') ?? 1;
        $offset = ($currentPage - 1) * $perPage;
        
        $data = [
            'title' => 'Liste des étudiants',
            'etudiants' => array_slice($etudiants, $offset, $perPage),
            'total' => count($etudiants),
            'currentPage' => $currentPage,
            'perPage' => $perPage,
            'keyword' => $keyword
        ];
        
        return view('etudiant/liste', $data);
    }

    /**
     * Affiche le détail d'un étudiant
     */
    public function show($id)
    {
        $etudiant = $this->etudiantModel->find($id);
        
        if (!$etudiant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $data = [
            'title' => 'Détail étudiant',
            'etudiant' => $etudiant
        ];
        
        return view('etudiant/detail', $data);
    }
}