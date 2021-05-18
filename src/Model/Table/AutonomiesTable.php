<?php
namespace App\Model\Table;

use App\Model\Entity\Autonomy;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class AutonomiesTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
	        
	        
	    $this->hasMany('TachesPros', [
            'foreignKey' => 'autonomy_id'
        ]);
        
        $this->hasMany('ObjectifsPedas', [
            'foreignKey' => 'autonomy_id'
        ]);
        
        $this->setDisplayField('NumeNom');
    }

}
