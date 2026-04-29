<?php
namespace App\Models;

use CodeIgniter\Model;

class EtudiantModel extends Model
{
    protected $table = 'etudiant';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'prenom', 'annee'];
    protected $returnType = 'object';
    protected $useTimestamps = false;

    /**
     * Recherche d'étudiants par nom ou prénom
     */
    public function search($keyword)
    {
        if ($keyword) {
            return $this->groupStart()
                ->like('nom', $keyword)
                ->orLike('prenom', $keyword)
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
        return $this->where('id', $id)
            ->first();
    }
}