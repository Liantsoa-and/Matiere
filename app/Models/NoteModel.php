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

    /**
     * Récupère les notes MAX par matière pour un étudiant et un semestre
     * Applique la RÈGLE 1 : note maximale par matière
     * @param int $etudiant_id
     * @param int $semestre_id
     * @param int|null $option_id (optionnel, pour filtrer par option)
     * @return array
     */
    public function getNotesMaxBySemestre($etudiant_id, $semestre_id, $option_id = null)
    {
        $query = $this->select('
            MAX(n.note) as note,
            n.matiere_id,
            m.code,
            m.nom,
            m.credit,
            pm.groupe_id,
            s.nom as semestre_nom
        ')
        ->from('note n')
        ->join('matiere m', 'm.id = n.matiere_id')
        ->join('programme_matiere pm', 'pm.matiere_id = m.id', 'left')
        ->join('semestre s', 's.id = pm.semestre_id', 'left')
        ->where('n.etudiant_id', $etudiant_id)
        ->where('s.id', $semestre_id);

        if ($option_id) {
            $query->where('pm.option_id', $option_id);
        }

        return $query->groupBy('n.matiere_id')
                     ->orderBy('m.code')
                     ->findAll();
    }

    /**
     * Récupère TOUTES les matières d'une option/semestre avec leurs notes (0 si pas de note)
     * Applique la RÈGLE 1 : note maximale par matière
     * @param int $etudiant_id
     * @param int $semestre_id
     * @param int $option_id
     * @return array
     */
    public function getNotesWithAllMatieresAndSemestre($etudiant_id, $semestre_id, $option_id)
    {
        $db = \Config\Database::connect();
        
        $query = $db->table('programme_matiere pm')
            ->select('
                COALESCE(MAX(n.note), 0) as note,
                m.id as matiere_id,
                m.code,
                m.nom,
                m.credit,
                pm.groupe_id,
                s.nom as semestre_nom
            ')
            ->join('matiere m', 'm.id = pm.matiere_id')
            ->join('semestre s', 's.id = pm.semestre_id')
            ->join('note n', 'n.matiere_id = m.id AND n.etudiant_id = ' . (int)$etudiant_id, 'left')
            ->where('pm.option_id', $option_id)
            ->where('pm.semestre_id', $semestre_id)
            ->groupBy('pm.matiere_id')
            ->orderBy('m.code')
            ->get()
            ->getResultObject();

        return $query;
    }

    /**
     * Récupère les notes pour L2 (S3 + S4) d'un étudiant et une option
     * Retourne TOUTES les matières avec 0 si pas de note
     * Applique la RÈGLE 1 : note max par matière
     * Applique la RÈGLE 2 : pour optionnels, garde meilleure note du groupe
     * @param int $etudiant_id
     * @param int $option_id
     * @return array Associatif avec 's3' et 's4' comme clés
     */
    public function getNotesL2ByOption($etudiant_id, $option_id)
    {
        // S3 (toujours le tronc commun, option_id = 1)
        $s3_notes = $this->getNotesWithAllMatieresAndSemestre($etudiant_id, 3, 1);

        // S4 pour l'option choisie
        $s4_notes = $this->getNotesWithAllMatieresAndSemestre($etudiant_id, 4, $option_id);

        // Appliquer RÈGLE 2 : pour les optionnels, garder meilleure note du groupe
        $s4_notes = $this->applyGroupRule($s4_notes);

        return [
            's3' => $s3_notes,
            's4' => $s4_notes
        ];
    }

    /**
     * RÈGLE 2 : Pour les matières optionnelles (groupe_id != NULL),
     * ne garde que la matière avec la meilleure note du groupe
     * @param array $notes
     * @return array
     */
    private function applyGroupRule($notes)
    {
        $result = [];
        $groupMap = []; // groupe_id => meilleure note

        foreach ($notes as $note) {
            if ($note->groupe_id === null) {
                // Matière obligatoire, on la garde
                $result[] = $note;
            } else {
                // Matière optionnelle
                if (!isset($groupMap[$note->groupe_id])) {
                    $groupMap[$note->groupe_id] = $note;
                } else {
                    // Si cette note est meilleure que l'existante, remplacer
                    if ($note->note > $groupMap[$note->groupe_id]->note) {
                        $groupMap[$note->groupe_id] = $note;
                    }
                }
            }
        }

        // Ajouter les meilleurs du groupe
        foreach ($groupMap as $note) {
            $result[] = $note;
        }

        return $result;
    }

    /**
     * Calcule la moyenne pondérée des notes
     * Moyenne = (note1 * coef1 + note2 * coef2 + ...) / (coef1 + coef2 + ...)
     * @param array $notes
     * @return float
     */
    public function calculateWeightedAverage($notes)
    {
        if (empty($notes)) {
            return 0;
        }

        $totalPoints = 0;
        $totalCoefficients = 0;

        foreach ($notes as $note) {
            $credit = $note->credit ?? 1;
            $totalPoints += $note->note * $credit;
            $totalCoefficients += $credit;
        }

        return $totalCoefficients > 0 ? round($totalPoints / $totalCoefficients, 2) : 0;
    }
}
