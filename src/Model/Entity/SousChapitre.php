<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
/**
 * User Entity.
 */
class SousChapitre extends Entity
{
	/**
	 * Conctatène les numéros des entities parentes pour les retourner sous forme d'une propriétée
	 * virtuelle: fullName
	 * 
	 * @return string $fullName
	 */
		
	protected function _getFullName()
	{ 
		$fullName = 'S.'. $this->chapitre->savoir->numero.
			'.'. $this->chapitre->numero.
			'.'. $this->_properties['numero'].
			' - '. $this->_properties['nom'].
			' - Niv. '.$this->niveaux_taxo->numero;
		return $fullName;
	}
}

