<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
/**
 * User Entity.
 */
class ObjectifsPeda extends Entity
{
	/**
	 * Conctatène les numéros des entities parentes pour les retourner sous forme d'une propriété
	 * virtuelle: fullName.
	 * 
	 * @return string $fullName.
	 */
		
	protected function _getFullName()
	{ 
		$fullName = 'C.'. 
			$this->competences_intermediaire->competences_terminale->capacite->numero. '.'.
			$this->competences_intermediaire->competences_terminale->numero. '.'.
			$this->competences_intermediaire->numero. ' - Niv:'. 
			$this->niveaux_competence->numero. ' - '.
			$this->_properties['nom'];
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
		$fullName = 'C.'. 
			$this->competences_intermediaire->competences_terminale->capacite->numero. '.'.
			$this->competences_intermediaire->competences_terminale->numero. '.'.
			$this->competences_intermediaire->numero. ' - '. 
			$this->niveaux_competence->numero;
		return $fullName;
	}	
}

