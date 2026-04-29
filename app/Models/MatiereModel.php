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
        'semestre',
        'coefficient',
        'parcours',
        'est_optionnelle',
        'groupe'
    ];

    /**
     * Récupère les matières par semestre
     * @param string $semestre ('S3' ou 'S4')
     * @return array
     */
    public function getBySemestre($semestre)
    {
        return $this->where('semestre', $semestre)->findAll();
    }

    /**
     * Récupère les matières obligatoires d'un semestre
     * @param string $semestre
     * @return array
     */
    public function getObligatoires($semestre)
    {
        return $this->where('semestre', $semestre)
                    ->where('est_optionnelle', false)
                    ->findAll();
    }

    /**
     * Récupère les matières optionnelles d'un semestre
     * @param string $semestre
     * @return array
     */
    public function getOptionnelles($semestre)
    {
        return $this->where('semestre', $semestre)
                    ->where('est_optionnelle', true)
                    ->findAll();
    }

    /**
     * Récupère les matières par parcours et semestre
     * @param string $parcours ('developpement', 'reseau', 'web')
     * @param string $semestre ('S3' ou 'S4')
     * @return array
     */
    public function getByParcoursAndSemestre($parcours, $semestre)
    {
        return $this->where('semestre', $semestre)
                    ->where(function($builder) use ($parcours) {
                        $builder->where('parcours', 'tous')
                                ->orWhere('parcours', $parcours);
                    })
                    ->findAll();
    }

    /**
     * Récupère un groupe d'options (matières du même groupe optionnel)
     * @param string $groupe
     * @return array
     */
    public function getOptionGroup($groupe)
    {
        return $this->where('groupe', $groupe)
                    ->where('est_optionnelle', true)
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
     * Récupère toutes les matières d'un étudiant (S3 + S4)
     * @param string $parcours
     * @return array
     */
    public function getMatieresByParcours($parcours)
    {
        $s3 = $this->getByParcoursAndSemestre($parcours, 'S3');
        $s4 = $this->getByParcoursAndSemestre($parcours, 'S4');
        
        return array_merge($s3, $s4);
    }
}