<?php
namespace App\Model\Table;

use App\Model\Entity\SousChapitre;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class SousChapitresTable extends Table
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
        
        $this->belongsTo('Chapitres', [
            'foreignKey' => 'chapitre_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('NiveauxTaxos', [
            'foreignKey' => 'niveaux_taxo_id',
            'joinType' => 'INNER'
        ]);
        
        $this->hasMany('CompetencesSavoirs', [
            'foreignKey' => 'sous_chapitre_id'
        ]);
        
        $this->setDisplayField('fullName');
        
    }

 
}
