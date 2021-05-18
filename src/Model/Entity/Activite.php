<?php
namespace App\Model\Entity;


use Cake\ORM\Entity;
/**
 * User Entity.
 */
class Activite extends Entity
{
	protected function _getNumeNom()
	{
		return 'A.' .$this->_properties['numero'].' - '.
			$this->_properties['nom'];
	}
}
