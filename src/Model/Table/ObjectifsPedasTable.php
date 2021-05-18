<?php
namespace App\Model\Table;

use App\Model\Entity\ObjectifsPeda;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class ObjectifsPedasTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->setDisplayField('fullName');
        
        $this->addAssociations([			
			'belongsTo' => [
				'CompetencesIntermediaires',
				'ContenusChapitres',
				'NiveauxCompetences',
				'Autonomies',
			],
			'hasMany' => ['Evaluations','TravauxPratiquesObjectifsPedas'],
			'belongsToMany' => [
				'TravauxPratiques' => [
					'joinTable' => 'travaux_pratiques_objectifs_pedas',
					//'trough' => 'TravauxPratiquesObjectifsPedas'
				]
			]
        ]);
        
        //$this->hasMany('TravauxPratiquesObjectifsPedas', ['foreignKey' => 'objectifs_peda_id']);

    }

 
}
