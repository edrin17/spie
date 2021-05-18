<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity.
 */
class Capacite extends Entity
{
	/**
	 * Conctatène le numéro de l'entity la retourner sous forme d'une propriétée
	 * virtuelle: fullName
	 * 
	 * @return string $fullName
	 */
	protected function _getFullName()
	{
		$fullName = 'C.'. $this->_properties['numero']. ' - '. $this->_properties['nom'];
		return $fullName;
	}
}
