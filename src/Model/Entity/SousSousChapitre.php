<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
/**
 * User Entity.
 */
class SousSousChapitre extends Entity
{
	/**
	 * Conctatène les numéros des entities parentes pour les retourner sous forme d'une propriétée
	 * virtuelle: fullName.
	 * 
	 * @return string $fullName.
	 */
		
	protected function _getFullName()
	{ 
		$fullName = 'S.'. $this->sous_chapitres->chapitre->numero. '.'
			.$this->sous_chapitres->numero. '.'.	$this->_properties['numero']. ' - '.
			$this->_properties['nom'];
		return $fullName;
	}
}
