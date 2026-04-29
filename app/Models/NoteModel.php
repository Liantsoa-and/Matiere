<?php
namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model
{
    protected $table = 'note';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'etudiant_id',
        'matiere_id',
        'note',
        'date_saisie'
    ];
    protected $useTimestamps = false;

    /**
     * Ajoute une note pour un étudiant et une matière
     * @param int $etudiant_id
     * @param int $matiere_id
     * @param float $note
     * @return int ID de la note créée
     */
    public function addNote($etudiant_id, $matiere_id, $note)
    {
        $data = [
            'etudiant_id' => $etudiant_id,
            'matiere_id' => $matiere_id,
            'note' => $note,
            'date_saisie' => date('Y-m-d H:i:s')
        ];
        
        return $this->insert($data);
    }

    /**
     * Récupère toutes les notes d'un étudiant
     * @param int $etudiant_id
     * @return array
     */
    public function getByEtudiant($etudiant_id)
    {
        return $this->where('etudiant_id', $etudiant_id)
                    ->orderBy('date_saisie', 'DESC')
                    ->findAll();
    }

    /**
     * Récupère la note maximale par matière pour un étudiant
     * @param int $etudiant_id
     * @return array
     */
    public function getMaxNotesByEtudiant($etudiant_id)
    {
        return $this->selectMax('note', 'note_max')
                    ->select('matiere_id')
                    ->where('etudiant_id', $etudiant_id)
                    ->groupBy('matiere_id')
                    ->findAll();
    }

    /**
     * Récupère les notes d'un étudiant pour une matière
     * @param int $etudiant_id
     * @param int $matiere_id
     * @return array
     */
    public function getNotesByEtudiantAndMatiere($etudiant_id, $matiere_id)
    {
        return $this->where('etudiant_id', $etudiant_id)
                    ->where('matiere_id', $matiere_id)
                    ->orderBy('date_saisie', 'DESC')
                    ->findAll();
    }

    /**
     * Récupère la meilleure note pour un étudiant dans une matière
     * @param int $etudiant_id
     * @param int $matiere_id
     * @return object|null
     */
    public function getMaxNoteForMatiereAndEtudiant($etudiant_id, $matiere_id)
    {
        return $this->where('etudiant_id', $etudiant_id)
                    ->where('matiere_id', $matiere_id)
                    ->selectMax('note')
                    ->first();
    }

    /**
     * Récupère les notes d'un étudiant avec les détails des matières
     * @param int $etudiant_id
     * @return array
     */
    public function getNotesWithMatieres($etudiant_id)
    {
        return $this->select('note.*, matiere.code, matiere.nom, matiere.semestre, matiere.groupe')
                    ->join('matiere', 'matiere.id = note.matiere_id')
                    ->where('note.etudiant_id', $etudiant_id)
                    ->orderBy('note.date_saisie', 'DESC')
                    ->findAll();
    }

    /**
     * Récupère les notes maximales d'un étudiant avec détails des matières
     * @param int $etudiant_id
     * @return array
     */
    public function getMaxNotesWithMatieres($etudiant_id)
    {
        return $this->select('MAX(note.note) as note_max, note.matiere_id, matiere.code, matiere.nom, matiere.semestre')
                    ->join('matiere', 'matiere.id = note.matiere_id')
                    ->where('note.etudiant_id', $etudiant_id)
                    ->groupBy('note.matiere_id')
                    ->orderBy('matiere.semestre')
                    ->findAll();
    }

    /**
     * Récupère les notes d'un étudiant par semestre
     * @param int $etudiant_id
     * @param string $semestre ('S3' ou 'S4')
     * @return array
     */
    public function getNotesBySemestre($etudiant_id, $semestre)
    {
        return $this->select('MAX(note.note) as note_max, note.matiere_id, matiere.code, matiere.nom, matiere.coefficient')
                    ->join('matiere', 'matiere.id = note.matiere_id')
                    ->where('note.etudiant_id', $etudiant_id)
                    ->where('matiere.semestre', $semestre)
                    ->groupBy('note.matiere_id')
                    ->findAll();
    }

    /**
     * Supprime une note
     * @param int $id
     * @return bool
     */
    public function deleteNote($id)
    {
        return $this->delete($id);
    }
}
