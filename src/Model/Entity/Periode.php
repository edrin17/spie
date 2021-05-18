<?php
namespace App\Model\Entity;


use Cake\ORM\Entity;
/**
 * User Entity.
 */
class Periode extends Entity
{
	protected function _getNumeNom()
	{
		return 'Période n°'.$this->_properties['numero'];
	}
}
