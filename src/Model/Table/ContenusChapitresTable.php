<?php
namespace App\Model\Table;

use App\Model\Entity\ContenuChapitre;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class ContenusChapitresTable extends Table
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
        
        $this->belongsTo('SousSousChapitres', [
            'foreignKey' => 'sous_sous_chapitre_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('NiveauxTaxos', [
            'foreignKey' => 'niveaux_taxo_id',
            'joinType' => 'INNER'
        ]);
        
        $this->hasMany('ObjectifsPedas', [
            'foreignKey' => 'contenus_chapitre_id'
        ]);

    }

 
}
