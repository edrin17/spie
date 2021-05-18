<?php
namespace App\Model\Table;

use App\Model\Entity\Evaluation;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class EvaluationsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->addAssociations([			
			'belongsTo' => [
				'Eleves',
				'ValeursEvals',
				'TypesEvals',
                'TravauxPratiquesObjectifsPedas',
                'ObjectifsPedas',
                'TravauxPratiques',
			],
			'hasMany' => [ 
			],
        ]);

    }

 
}
