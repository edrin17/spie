<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity.
 */
class Taxo extends Entity
{
    /**
     * Conctatène les numéros des entities parentes pour les retourner sous forme d'une propriétée
     * virtuelle: fullName
     *
     * @return string $fullName
     */

    protected function _getFullName()
    {
        $fullName = 'N' . $this->_properties['num'] . ' - ' .
            $this->_properties['name'];
        return $fullName;
    }
}
