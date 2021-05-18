<?php
namespace App\Model\Table;

use App\Model\Entity\MaterielsTravauxPratique;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class MaterielsTravauxPratiquesTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->belongsTo('TravauxPratiques', [
            'foreignKey' => 'travaux_pratique_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('Materiels', [
            'foreignKey' => 'materiel_id',
            'joinType' => 'INNER'
        ]);

    }

 
}
