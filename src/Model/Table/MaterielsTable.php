<?php
namespace App\Model\Table;

use App\Model\Entity\Materiel;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class MaterielsTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addAssociations([
			'belongsTo' => [
				'TypesMachines','Marques','Owners'
			],
			'belongsToMany' => [
				'TravauxPratiques' => [
					'joinTable' => 'materiels_travaux_pratiques'
					//'trough' => 'MaterielsTravauxPratiques'
				]
			]
        ]);

        $this->setDisplayField('fullName');
    }


}
