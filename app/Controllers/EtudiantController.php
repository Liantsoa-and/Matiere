<?php
namespace App\Controllers;

use App\Models\EtudiantModel;
use App\Models\NoteModel;
use App\Models\MatiereModel;

class EtudiantController extends BaseController
{
    protected $etudiantModel;
    protected $noteModel;
    protected $matiereModel;

    public function __construct()
    {
        $this->etudiantModel = new EtudiantModel();
        $this->noteModel = new NoteModel();
        $this->matiereModel = new MatiereModel();
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
     * Affiche le détail d'un étudiant avec ses notes
     */
    public function show($id)
    {
        $etudiant = $this->etudiantModel->find($id);
        
        if (!$etudiant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Les 3 options disponibles
        $options = [
            2 => 'Développement',
            3 => 'Bases de Données et Réseaux',
            4 => 'Web et Design'
        ];

        // Option par défaut (Dev)
        $selectedOption = $this->request->getGet('option') ?? 2;

        // Récupérer les notes L2 pour l'option choisie
        $notes = $this->noteModel->getNotesL2ByOption($id, $selectedOption);

        // Calculer les moyennes
        $moyenneS3 = $this->noteModel->calculateWeightedAverage($notes['s3']);
        $moyenneS4 = $this->noteModel->calculateWeightedAverage($notes['s4']);
        $moyenneL2 = $this->noteModel->calculateWeightedAverage(
            array_merge($notes['s3'], $notes['s4'])
        );

        $data = [
            'title' => 'Détail étudiant',
            'etudiant' => $etudiant,
            'options' => $options,
            'selectedOption' => $selectedOption,
            'notes' => $notes,
            'moyenneS3' => $moyenneS3,
            'moyenneS4' => $moyenneS4,
            'moyenneL2' => $moyenneL2
        ];
        
        return view('etudiant/detail', $data);
    }
}