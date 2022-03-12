<?php
namespace App\Model\Table;

use App\Model\Entity\Rotation;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class RotationsTable extends Table
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

        /*$this->belongsTo('Periodes', [
            'foreignKey' => 'periode_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Themes', [
            'foreignKey' => 'theme_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('TravauxPratiques', [
            'foreignKey' => 'rotation_id'
        ]);*/

        $this->addAssociations([
			'belongsTo' => [
                'Themes',
                'Periodes',
			],
			'hasMany' => [
                'TravauxPratiques'
			]
        ]);

        $this->setDisplayField('fullName');
    }


}
