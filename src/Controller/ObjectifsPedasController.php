<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * ObjectifsPedas Controller
 */
class ObjectifsPedasController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

    public function index()
    {
		$objectifsPedas = $this->ObjectifsPedas;
		$listObjsPedas = $objectifsPedas->find()							
			->contain([
				'CompetencesIntermediaires.CompetencesTerminales.Capacites',
				'NiveauxCompetences'
			])
			->order(['Capacites.numero' => 'ASC',
				'CompetencesTerminales.numero' => 'ASC',
				'CompetencesIntermediaires.numero' => 'ASC',
				'NiveauxCompetences.numero' => 'ASC'
			]);
		//debug($listObjsPedas->toArray());die;
        $this->set(compact('listObjsPedas'));
		
    }

    /**
     * Ajoute un contenu pédagogique (micro compétence)
     * 
     * L'utilisateur choisi: 
     * 
     * -le niveau de compétence
     * -Capacité->Compétence Terminales->Compétence Intermédiaire en listes 
     * chaînées en ajax.
     * 
     *
     * @param void
     * @return void
     */
    
    public function add()
    {
		$nivComp = TableRegistry::get('NiveauxCompetences');
		$capacites = TableRegistry::get('Capacites');
		$compsTerms = TableRegistry::get('CompetencesTerminales');
		$compsInters = TableRegistry::get('CompetencesIntermediaires');
		
		$listLvls = $nivComp->find('list')
			->order(['numero' => 'ASC']);
		
        $listCapas = $capacites->find('list')
			->order(['numero' => 'ASC']);
		
        $listCompsTerms = $compsTerms->find()
			->contain(['Capacites'])							
			->order([
                'Capacites.numero' => 'ASC',
                'CompetencesTerminales.numero' => 'ASC'
            ])
            ->first();
        $listCompsTerms = [$listCompsTerms->id => $listCompsTerms->fullName];
        
        $listCompsInters = $compsInters->find()
			->contain(['CompetencesTerminales.Capacites'])								
			->order([
                'Capacites.numero' => 'ASC',
                'CompetencesTerminales.numero' => 'ASC',
                'CompetencesIntermediaires.numero' => 'ASC'
            ])
            ->first();
		$listCompsInters = [$listCompsInters->id => $listCompsInters->fullName];
        
        $objectifsPeda = $this->ObjectifsPedas->newEntity();
        if ($this->request->is('post')) {
			$objectifsPeda = $this->ObjectifsPedas->patchEntity(
				$objectifsPeda, $this->request->getData()
			);
            if ($this->ObjectifsPedas->save($objectifsPeda)) {  //on essaye de sauvergarder l'entity
                $this->Flash->success(__("L'objectif pédagogique a été sauvegardé."));    
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__(
					"L'objectif pédagogique n'a pas pu être sauvegardé ! Réessayer."
				));
            }
        }
        
        $this->set(compact('listLvls','listCapas','listCompsTerms','listCompsInters','objectifsPeda')); 
    }
	
	
    /**
     * Édite un contenu pédagogique (sous compétence intermédiaire)
     * 
     * L'utilisateur choisi: Capacité->Compétence Terminales->Compétence Intermédiaire en listes 
     * chaînées en ajax.
     * et le niveau de compétence
     *
     * @param void
     * @return void
     */
    public function edit($id = null) 
    {
        
        $objectifsPeda = $this->ObjectifsPedas->get($id, [
			'contain' => [
				'CompetencesIntermediaires.CompetencesTerminales.Capacites',
				'NiveauxCompetences'
			] 
		]);
	
		$nivComp = TableRegistry::get('NiveauxCompetences');
		$capacites = TableRegistry::get('Capacites');
		$compsTerms = TableRegistry::get('CompetencesTerminales');
		$compsInters = TableRegistry::get('CompetencesIntermediaires');
		
		$listLvls = $nivComp->find('list')
			->order(['numero' => 'ASC']);
		//debug($listLvls->toArray());die;
		
		$listObjsPedas = $this->ObjectifsPedas->find()
			->contain(['CompetencesIntermediaires.CompetencesTerminales.Capacites',
				'NiveauxCompetences']);
		

        $listCapas = $capacites->find('list')
			->order(['numero' => 'ASC']);
		
        $listCompsTerms = $compsTerms->find('list')
			->contain(['Capacites'])
			->where(['Capacites.numero' => 
				$objectifsPeda->competences_intermediaire->competences_terminale
				->capacite->numero
			])								
			->order(['CompetencesTerminales.numero' => 'ASC']);

        $listCompsInters = $compsInters->find('list')
			->contain(['CompetencesTerminales.Capacites'])
			->where([
				'Capacites.numero' => $objectifsPeda->competences_intermediaire
				->competences_terminale->capacite->numero,
				'CompetencesTerminales.numero' => $objectifsPeda->competences_intermediaire
				->competences_terminale->numero		
			])								
			->order(['CompetencesIntermediaires.numero' => 'ASC']);
			
        //debug($this->request);die;
        if ($this->request->is(['patch', 'post', 'put'])) {          
            $objectifsPeda = $this->ObjectifsPedas->patchEntity($objectifsPeda, $this->request->getData());
            if ($this->ObjectifsPedas->save($objectifsPeda)) {
                $this->Flash->success(__("L'objectif pédagogique a été sauvegardé."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("Le contenu de chapitre n'a pas pu être sauvegardé ! Réessayer."));
            }
        }
        
        $this->set(compact('listLvls','listCapas','listCompsTerms','listCompsInters','objectifsPeda'));
    }
	
   
    public function view($id = null)
    {
        $objectifsPeda = $this->ObjectifsPedas->get($id, [
			'contain' => [
				'CompetencesIntermediaires.CompetencesTerminales.Capacites',
				'NiveauxCompetences'
			] 
		]);
        						
        $this->set(compact('objectifsPeda'));                                 // Passe le paramètre 'objectifsPeda' à la vue.
    }
    
    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $objectifsPeda = $this->ObjectifsPedas->get($id);
        if ($this->ObjectifsPedas->delete($objectifsPeda)) {
            $this->Flash->success(__("L'objectif pédagogique a été supprimé."));
        } else {
            $this->Flash->error(__("L'objectif pédagogique n'a pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
	
}
