<?php
namespace App\Model\Table;

use App\Model\Entity\TachesPro;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class TachesProsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setDisplayField('nom');

        $this->belongsTo('Autonomies', [
            'foreignKey' => 'autonomy_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Activites', [
            'foreignKey' => 'activite_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('TravauxPratiques', [
            'foreignKey' => 'taches_principale_id'
        ]);

        $this->setDisplayField('fullName');
    }


}
