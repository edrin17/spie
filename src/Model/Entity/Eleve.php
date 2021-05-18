<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
/**
 * User Entity.
 */
class Eleve extends Entity
{
	/**
	 * Conctatène le nom et le prénom de l'élève pour la retourner sous forme d'une propriété
	 * virtuelle: fullName
	 * 
	 * @return string $fullName
	 */
	protected function _getFullName()
	{
		$fullName = strtoupper($this->_properties['nom']). ' '. $this->_properties['prenom'];
		return $fullName;
		debug($fullName);die;
	}	
}

