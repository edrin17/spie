<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
/**
 * User Entity.
 */
class Materiel extends Entity
{
	/**
	 * Conctatène les marques et le type des entities avec le nom de machine
	 * pour les retourner sous forme d'une propriétée virtuelle: fullName.
	 * 
	 * @return string $fullName.
	 */
		
	protected function _getFullName()
	{ 
		$fullName = $this->types_machine->nom. ': '.
		$this->marque->nom. ' - '.
		$this->_properties['nom'];
		return $fullName;
	}	
}

