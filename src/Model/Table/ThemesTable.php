<?php
namespace App\Model\Table;

use App\Model\Entity\Theme;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ThemesTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->hasMany('Rotations', [
            'foreignKey' => 'theme_id'
        ]);
        
        $this->setDisplayField('nom');
    }

}
