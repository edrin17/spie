<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Collection\Collection;
/**
 * MaterielsTravauxPratiques Controller
 */
class MaterielsTravauxPratiquesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
    /**
     *Liste les MaterielsTravauxPratiques:
     *récupère les capacités & les classe ASC
     *puis les passes en paramètre à l'instance
     * Pagine les materielsTravauxPratiques terminales
     */

    public function index($id = null)
    {
        if ($id == null) //If null we go back to previous page.
		{
			return $this->redirect(['controller' => 'TravauxPratiques', 'action' => 'index']);
		}

        $travauxPratiques = TableRegistry::get('TravauxPratiques');
        $materiels = TableRegistry::get('Materiels');
        
        //find list of objectifs pedas matching $id
        $tp = $travauxPratiques->get($id,[   
			'contain' => ['Rotations.Periodes.Classes','Rotations.Themes']
		]);

		
		$listMateriels = $materiels->find()
			->matching('TravauxPratiques', function($q) use ($id) {
				return $q->where(['TravauxPratiques.id' => $id]);
			})
			->contain(['TypesMachines','Marques']);
		//debug($listMateriels->toArray());die;	
        $this->set(compact('tp','listMateriels','id'));
		
    }
	/**
	 * Associe un objectif peda avec un TP
	 * @params $id :c'est l'id du TP
	 * 
	 * 
     **********************************************************/
    public function add($id = null)
    {
		if ($id == null) {
			return $this->redirect(['action' => 'index']);
		}
		
		$materiels = TableRegistry::get('Materiels');
		$listMateriels = $materiels->find('list')
			->contain(['TypesMachines','Marques'])
			->order([
				'TypesMachines.nom' => 'ASC',
				'Marques.nom' => 'ASC',
				'Materiels.nom' => 'ASC'
			]);
		
		$travauxPratiques = TableRegistry::get('TravauxPratiques');
		$tp = $travauxPratiques->get($id,[   
			'contain' => ['Rotations.Periodes.Classes','Rotations.Themes']
		]);
        $tpMateriel = $this->MaterielsTravauxPratiques->newEntity();
        if ($this->request->is('post')) {
			
            $tpMateriel = $this->MaterielsTravauxPratiques
				->patchEntity($tpMateriel, $this->request->getData());
            if ($this->MaterielsTravauxPratiques->save($tpMateriel)) { 
                $this->Flash->success(__(
					"L'association TP - Matériel a été sauvegardée."
				));
                return $this->redirect(['action' => 'index']); 
            } else {
                $this->Flash->error(__(
					"L'association TP - Matériel n'a pas pu être sauvegardée ! Réessayer."
				));
            }
        }
						
        $this->set(compact('tpMateriel','listMateriels','id','tp'));
        
    }

    /**
     * Efface une association
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $tpMateriel = $this->MaterielsTravauxPratiques->get($id);
        if ($this->MaterielsTravauxPratiques->delete($tpMateriel)) {
            $this->Flash->success(__("L'association a été supprimée."));
        } else {
            $this->Flash->error(__("L'association n'a pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    /*
     * on crée un tableau pour monter le taux d'utilisation des supports pédas par TP
     */
    public function view(){
        $tableMateriels = TableRegistry::get('Materiels');
        $nbTotal = 0;
        $color = 'info';
        $clé = null;
        $listMateriels = $tableMateriels->find()
            ->contain([
                'TravauxPratiques.Rotations.Periodes',
                'TypesMachines','Marques'
                
            ]);
        $listMateriels = $listMateriels->toArray();    
        
        //on cherche le matériel non défini pour l'enlever du comptage
        foreach ($listMateriels as  $key => $materiel) {
            $nom = $materiel->nom; 
            if ($nom == 'Non Défini') {
                $clé = $key;
            }
        }
        unset($listMateriels[$clé]);
        
        foreach ($listMateriels as $key => $materiel) {
            $nbTPs = 0;
            $color = 'info';
            $nbTPs = count($materiel->travaux_pratiques);
            $nbTotal += $nbTPs;
            if ($nbTPs === 0) {
                $color = 'warning';
            }
             
            $materiel->set(compact('nbTPs','color'));
        }
        $this->set(compact('listMateriels','nbTotal'));
    }
    

}
