<?php
namespace App\Model\Table;

use App\Model\Entity\Progression;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class ProgressionsTable extends Table
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

        $this->setDisplayField('nom');

        $this->hasMany('Classes', [
            'foreignKey' => 'progression_id'
        ]);
        $this->hasMany('Periodes', [
            'foreignKey' => 'progression_id'
        ]);

        $this->belongsTo('Referentials');
    }
}
