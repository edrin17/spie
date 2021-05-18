<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CompetenceIntermediaires Entity.
 */
class CompetencesIntermediaire extends Entity
{
	/**
	 * Conctatène les numéros des entities parentes pour les retourner sous forme d'une propriétée
	 * virtuelle: fullName.
	 * 
	 * @return string $fullName.
	 */
		
	protected function _getFullName()
	{ 
		$fullName = 'C.'. $this->competences_terminale->capacite->numero. '.'
			.$this->competences_terminale->numero. '.'.	$this->_properties['numero']. ' - '.
			$this->_properties['nom'];
		return $fullName;
	}
}
