<?php
namespace App\Model\Table;

use App\Model\Entity\Chapitre;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class ChapitresTable extends Table
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
        //$this->addBehavior('Timestamp');
        $this->hasMany('SousChapitres', [
            'foreignKey' => 'chapitre_id'
        ]);

        $this->belongsTo('Savoirs');
    }
}
