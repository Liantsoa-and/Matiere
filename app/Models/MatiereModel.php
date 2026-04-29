<?php
namespace App\Models;

use CodeIgniter\Model;

class MatiereModel extends Model
{
    protected $table = 'matiere';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'code',
        'nom',
        'credit',
        'coefficient'
    ];

    /**
     * Récupère toutes les matières avec info semestre via programme_matiere
     * @return array
     */
    public function getAllWithSemestre()
    {
        return $this->select('m.id, m.code, m.nom, m.credit, s.id as semestre_id, s.nom as semestre')
                    ->from('matiere m')
                    ->join('programme_matiere pm', 'pm.matiere_id = m.id', 'left')
                    ->join('semestre s', 's.id = pm.semestre_id', 'left')
                    ->groupBy('m.id')
                    ->orderBy('s.id, m.code')
                    ->findAll();
    }

    /**
     * Récupère matières par semestre
     * @param int $semestre_id (3 ou 4)
     * @return array
     */
    public function getBySemestre($semestre_id)
    {
        return $this->select('m.id, m.code, m.nom, m.credit, s.id as semestre_id, s.nom as semestre')
                    ->from('matiere m')
                    ->join('programme_matiere pm', 'pm.matiere_id = m.id')
                    ->join('semestre s', 's.id = pm.semestre_id')
                    ->where('s.id', $semestre_id)
                    ->groupBy('m.id')
                    ->orderBy('m.code')
                    ->findAll();
    }

    /**
     * Récupère matières d'une option et semestre
     * @param int $option_id
     * @param int $semestre_id
     * @return array
     */
    public function getByOptionAndSemestre($option_id, $semestre_id)
    {
        return $this->select('m.id, m.code, m.nom, m.credit, s.id as semestre_id, s.nom as semestre, pm.groupe_id')
                    ->from('matiere m')
                    ->join('programme_matiere pm', 'pm.matiere_id = m.id')
                    ->join('semestre s', 's.id = pm.semestre_id')
                    ->where('pm.option_id', $option_id)
                    ->where('pm.semestre_id', $semestre_id)
                    ->orderBy('m.code')
                    ->findAll();
    }

    /**
     * Récupère une matière par son code
     * @param string $code
     * @return object|null
     */
    public function getByCode($code)
    {
        return $this->where('code', $code)->first();
    }

    /**
     * Récupère matières obligatoires (groupe_id = NULL)
     * @param int $option_id
     * @param int $semestre_id
     * @return array
     */
    public function getObligatoires($option_id, $semestre_id)
    {
        return $this->select('m.id, m.code, m.nom, m.credit')
                    ->from('matiere m')
                    ->join('programme_matiere pm', 'pm.matiere_id = m.id')
                    ->where('pm.option_id', $option_id)
                    ->where('pm.semestre_id', $semestre_id)
                    ->where('pm.groupe_id IS NULL')
                    ->orderBy('m.code')
                    ->findAll();
    }

    /**
     * Récupère matières optionnelles par groupe
     * @param int $groupe_id
     * @return array
     */
    public function getByGroupe($groupe_id)
    {
        return $this->select('m.id, m.code, m.nom, m.credit')
                    ->from('matiere m')
                    ->join('programme_matiere pm', 'pm.matiere_id = m.id')
                    ->where('pm.groupe_id', $groupe_id)
                    ->orderBy('m.code')
                    ->findAll();
    }
}