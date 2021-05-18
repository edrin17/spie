<?php
namespace App\Model\Table;

use App\Model\Entity\CompetencesIntermediaire;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class CompetencesIntermediairesTable extends Table
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

        $this->belongsTo('CompetencesTerminales', [
            'foreignKey' => 'competences_terminale_id',
            'joinType' => 'INNER'
        ]);
        
        $this->hasMany('ObjectifsPedas', [
            'foreignKey' => 'competences_intermediaire_id'
        ]);
    }

}
