<?php
namespace App\Model\Table;

use App\Model\Entity\TpEleve;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class TpElevesTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->belongsTo('Eleves');
        $this->belongsTo('TravauxPratiques');
    }


}
