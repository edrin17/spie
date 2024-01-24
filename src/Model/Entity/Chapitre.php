<?php
namespace App\Model\Entity;


use Cake\ORM\Entity;
/**
 * User Entity.
 */
class Chapitre extends Entity
{
/**
	 * Conctatène le numéro de l'entity la retourner sous forme d'une propriétée
	 * virtuelle: fullName
	 * 
	 * @return string $fullName
	 */
	protected function _getFullName()
	{ 
		$fullName = 'S.'. $this->savoir->numero. '.'. $this->_properties['numero'];
		return $fullName;
	}
}
