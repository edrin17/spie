<?php
namespace App\Model\Table;

use App\Model\Entity\CompetencesTerminale;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class CompetencesTerminalesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setDisplayField('fullName');

        $this->belongsTo('Capacites', [
            'foreignKey' => 'capacite_id',
            'joinType' => 'INNER'
        ]);
        
        $this->hasMany('CompetencesIntermediaires', [
            'foreignKey' => 'competences_terminale_id'
        ]);
        
        $this->hasMany('CompetencesSavoirs', [
            'foreignKey' => 'competences_terminale_id'
        ]);
    }
    
    /**
     * Récupère les numéros des parents et concatène la chaîne de nom sous la forme C.1.1.1 Fooo
     * 
     * @param \Cake\ORM\Table $table La Table à utiliser.
     * @param string $findMethod Le type de find qu'on veut 'all' ou 'first'.
     * @return array($id, $nom, $numero, $parent).
     */
    
    
    public function getCompTerms()
	{
		$query = $this -> find()
						-> contain(['Capacites'])
						-> order([
							'Capacites.numero' => 'ASC',
							'CompetencesTerminales.numero' => 'ASC'
						]);
						
		foreach ($query as $compTerm) 
		{
			$result[$compTerm->id] = "C." .$compTerm->capacite->numero
													."." .$compTerm->numero
													." - " .$compTerm->nom;
		}
		
		return $result;
	}
	

}
