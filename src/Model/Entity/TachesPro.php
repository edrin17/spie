<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
/**
 * User Entity.
 */
class TachesPro extends Entity
{
  protected function _getFullName()
  {
    $fullName =
      'A'. $this->activite->numero.'-'.$this->activite->nom.
      ' - T'. $this->_properties['numero']. ': '. $this->_properties['nom'];
    return $fullName;
  }
}
