<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
/**
 * User Entity.
 */
class Rotation extends Entity
{
	/**
	 * Conctatène les numéros des entities parentes pour les retourner sous forme d'une propriété
	 * virtuelle: fullName.
	 * 
	 * @return string $fullName.
	 */
		
	protected function _getFullName()
	{ 
		$fullName = 'P'. $this->periode->numero. '-R'. $this->_properties['numero']. ': '. $this->_properties['nom'];
		return $fullName;
	}
    /**
	 * Conctatène les numéros des entities parentes pour les retourner sous forme d'une propriété
	 * virtuelle: code.
	 * 
	 * @return string $code.
	 */
		
	protected function _getCode()
	{ 
		$code = 'P'. $this->periode->numero. '-R'. $this->_properties['numero'];
		return $code;
	}
}

