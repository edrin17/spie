<?php
namespace App\Model\Table;

use App\Model\Entity\SousSousChapitre;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class SousSousChapitresTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('SousChapitres', [
            'foreignKey' => 'sous_chapitre_id',
            'joinType' => 'INNER'
        ]);
        
        $this->hasMany('ContenusChapitres', [
            'foreignKey' => 'sous_sous_chapitre_id'
        ]);
        
        $this->hasMany('ObjectifsPedas', [
            'foreignKey' => 'sous_sous_chapitre_id'
        ]);
    }
}
