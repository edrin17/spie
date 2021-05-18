<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class CompetencesTerminale extends Entity
{
	/**
	 * Conctatène les numéros des entities parentes pour les retourner sous forme d'une propriétée
	 * virtuelle: fullName
	 * 
	 * @return string $fullName
	 */
		
	protected function _getFullName()
	{ 
		$fullName = 'C.'. $this->capacite->numero. '.'. $this->_properties['numero']. ' - '.
			$this->_properties['nom'];
		return $fullName;
	}
}
