<?php
namespace App\Model\Table;

use App\Model\Entity\Eleve;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ElevesTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        //overrides Inflector
        //$this->setEntityClass('App\Model\Entity\Eleve');
        $this->belongsTo('Classes', [
            'foreignKey' => 'classe_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Evaluations', [
            'foreignKey' => 'eleve_id'
        ]);
    }


}
