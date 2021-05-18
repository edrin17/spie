<?php
namespace App\Model\Table;

use App\Model\Entity\TravauxPratique;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class TravauxPratiquesTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->addAssociations([			
			'belongsTo' => ['TachesPros','Rotations'],
			'hasMany' => ['MaterielsTravauxPratiques','TravauxPratiquesObjectifsPedas','Evaluations'],
			'belongsToMany' => [
				'ObjectifsPedas' => ['joinTable' => 'travaux_pratiques_objectifs_pedas'],
				'Materiels' => ['trough' => 'MaterielTravauxPratiques']
			]
        ]);
    }

 
}
