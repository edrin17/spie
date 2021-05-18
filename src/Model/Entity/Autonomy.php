<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
/**
 * User Entity.
 */
class Autonomy extends Entity
{
	protected function _getNumeNom()
	{
		return 'N.' .$this->_properties['numero'].' - '.
			$this->_properties['nom'];
	}
}
