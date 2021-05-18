<?php
namespace App\Model\Entity;


use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
/**
 * User Entity.
 */
class User extends Entity
{
    // Rend les champs assignables en masse sauf pour le champ clé primaire "id".
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    
    protected function _setPassword($password)
	{
        return (new DefaultPasswordHasher)->hash($password);
	}
	
}
