<?php
namespace App\Model\Table;

use App\Model\Entity\CompetencesSavoir;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class CompetencesSavoirsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);


        $this->belongsTo('CompetencesTerminales', [
            'foreignKey' => 'competences_terminale_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('SousChapitres', [
            'foreignKey' => 'sous_chapitre_id',
            'joinType' => 'INNER'
        ]);
        
    }

}
