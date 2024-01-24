<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
/**
 * User Entity.
 */
class NiveauxCompetence extends Entity
{
	protected function _getFullName()
	{
		return $this->_properties['numero'].' - '.
			$this->_properties['nom'];
	}
}
