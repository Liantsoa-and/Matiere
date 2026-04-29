<?php
namespace App\Models;

use CodeIgniter\Model;

class EtudiantModel extends Model
{
    protected $table = 'etudiant';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'num_etudiant', 'nom', 'prenom', 'annee'
    ];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Recherche d'étudiants par nom ou prénom
     */
    public function search($keyword)
    {
        if ($keyword) {
            return $this->groupStart()
                        ->like('nom', $keyword)
                        ->orLike('prenom', $keyword)
                        ->orLike('num_etudiant', $keyword)
                    ->groupEnd()
                    ->orderBy('nom', 'ASC')
                    ->findAll();
        }
        return $this->orderBy('nom', 'ASC')->findAll();
    }

    /**
     * Récupérer un étudiant avec ses notes
     */
    public function getEtudiantWithNotes($id)
    {
        return $this->select('etudiants.*')
                    ->where('etudiants.id', $id)
                    ->first();
    }
}