<?php
namespace App\Controllers;

use App\Models\NoteModel;
use App\Models\EtudiantModel;
use App\Models\MatiereModel;

class NoteController extends BaseController
{
    protected $noteModel;
    protected $etudiantModel;
    protected $matiereModel;

    public function __construct()
    {
        $this->noteModel = new NoteModel();
        $this->etudiantModel = new EtudiantModel();
        $this->matiereModel = new MatiereModel();
    }

    /**
     * Affiche le formulaire d'ajout de note
     */
    public function create()
    {
        $data = [
            'etudiants' => $this->etudiantModel->findAll(),
            'matieres' => $this->matiereModel->getAllWithSemestre(),
        ];

        return view('note/add_note', $data);
    }

    /**
     * Traite l'ajout d'une note
     */
    public function store()
    {
        // Validation
        $rules = [
            'etudiant_id' => 'required|numeric',
            'matiere_id' => 'required|numeric',
            'note' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[20]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Récupère les données du formulaire
        $etudiant_id = $this->request->getPost('etudiant_id');
        $matiere_id = $this->request->getPost('matiere_id');
        $note = $this->request->getPost('note');

        // Ajoute la note
        if ($this->noteModel->addNote($etudiant_id, $matiere_id, $note)) {
            session()->setFlashdata('success', 'Note ajoutée avec succès');
            return redirect()->to('note/create');
        } else {
            session()->setFlashdata('error', 'Erreur lors de l\'ajout de la note');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Affiche les notes d'un étudiant
     */
    public function getByEtudiant($etudiant_id)
    {
        $etudiant = $this->etudiantModel->find($etudiant_id);

        if (!$etudiant) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Étudiant non trouvé');
        }

        $data = [
            'etudiant' => $etudiant,
            'notes' => $this->noteModel->getNotesWithMatieres($etudiant_id),
        ];

        return view('note/student_notes', $data);
    }

    /**
     * Récupère les matières selon le parcours de l'étudiant (via AJAX)
     */
    public function getMatieresByEtudiant()
    {
        $etudiant_id = $this->request->getPost('etudiant_id');

        if (!$etudiant_id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Étudiant non spécifié'
            ]);
        }

        $etudiant = $this->etudiantModel->find($etudiant_id);

        if (!$etudiant) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Étudiant non trouvé'
            ]);
        }

        // Récupère les matières selon le parcours
        $matieres = $this->matiereModel->getByParcoursAndSemestre($etudiant->parcours ?? 'tous', 'S3');
        $matieres = array_merge($matieres, $this->matiereModel->getByParcoursAndSemestre($etudiant->parcours ?? 'tous', 'S4'));

        return $this->response->setJSON([
            'success' => true,
            'matieres' => $matieres
        ]);
    }
}
