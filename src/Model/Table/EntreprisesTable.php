<?php
namespace App\Model\Table;

use App\Model\Entity\CompetencesTerminale;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class CompetencesTerminalesTable extends Table
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

        /*$this->table('utilisateurs');
        $this->setDisplayField('nom');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp'); */

        $this->belongsTo('Capacites', [
            'foreignKey' => 'capacite_id',
            'joinType' => 'INNER'
        ]);
        
        $this->hasMany('CompetencesIntermediaires', [
            'foreignKey' => 'competences_terminale_id'
        ]);
    }

}
