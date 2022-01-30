<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Inflector;
/**
 * User Entity.
 */
class TpEleve extends Entity
{
    /**
	 * Conctatène les numéros des entities parentes pour les retourner sous forme d'une propriétée
	 * virtuelle: fullName.
	 *
	 * @return string $fullName.
	 */

	protected function _getFullName()
	{

	}
}
