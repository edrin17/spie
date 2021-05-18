<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
/**
 * User Entity.
 */
class NiveauxTaxo extends Entity
{
	protected function _getNumeNom()
	{
		return $this->_properties['numero'].' - '.
			$this->_properties['nom'];
	}
}
