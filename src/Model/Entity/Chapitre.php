<?php
namespace App\Model\Entity;


use Cake\ORM\Entity;
/**
 * User Entity.
 */
class Chapitre extends Entity
{
	protected function _getNumeNom()
	{
		return 'S.'.$this->_properties['numero'].' - '.
			$this->_properties['nom'];
	}
}
