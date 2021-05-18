<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TravauxPratiquesObjectifsPedasController
 */
class CompetencesIntermediairesTachesProsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

    public function index($id = null)
    {
        //on vérifie qu'une id a été passée en paramètre
        if ($id == null) 
		{
			$this->redirect(['controller' => 'TravauxPratiques', 'action' => 'index']);
		}

        
        //On récupere la liste des occurences qui matchent avec l'id du TP transmis en paramètre
        $listeTravauxPratiques = $this->TravauxPratiquesObjectifsPedas->find()
										->where(['travaux_pratique_id' => $id]);

		
		}
        $this->set(compact('nomTP','listeObjectifs','listeTravauxPratiques','id'));
		
    }
	/***************** Ajoute une tâche principale
     **********************************************************/
    public function add($id = null)
    {
		
		$nomTP = $this->TravauxPratiquesObjectifsPedas->TravauxPratiques->find()
							->select(['nom'])
							->where(['id' => $id])
							->first();
        
        $travauxPratiquesObjectifsPeda = $this->TravauxPratiquesObjectifsPedas->newEntity();                                   // crée une nouvelle entité dans $materielsObjectifsPeda
        if ($this->request->is('post')) {                                           //si requête de type post
            $travauxPratiquesObjectifsPeda = $this->TravauxPratiquesObjectifsPedas->patchEntity($travauxPratiquesObjectifsPeda, $this->request->getData());  //??
            if ($this->TravauxPratiquesObjectifsPedas->save($travauxPratiquesObjectifsPeda)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('L\'associtation matériel pour un objectif péda a été sauvegardée.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('L\'associtation matériel pour un objectif péda n\'a pas pu être sauvegardée ! Réessayer.')); //Affiche une infobulle
            }
        }
        
        //on récupère la liste des occurences de la table ObjectifsPedas
        $objectifs = $this->TravauxPratiquesObjectifsPedas->ObjectifsPedas->find()
							->select(['nom','id'])
							->notMatching('TravauxPratiquesObjectifsPedas', function($q) use ($id) {
								return $q->where(['TravauxPratiquesObjectifsPedas.travaux_pratique_id =' => $id]);
							});
						
        foreach ($objectifs as $objectif) 
		{				
			/*$marque = $this->TravauxPratiquesObjectifsPedas->Materiels->Marques->find()
							->select(['nom'])
							->matching('Materiels')
							->where(['Materiels.marque_id' => $materiel->marque_id])
							->first();
		
			$typesMachine = $this->MaterielsObjectifsPedas->Materiels->TypesMachines->find()
							->select(['nom'])
							->matching('Materiels')
							->where(['Materiels.types_machine_id' => $materiel->types_machine_id])
							->first();*/
			//debug($objectif->nom);
			$listeObjectifs[$objectif->id] = $objectif->nom;   
		}
		//die;
        //$listeTypesTaches = $this->MaterielsObjectifsPedas->TypesTaches->find('list')->order(['nom' => 'ASC'])->toArray();
        $this->set(compact('nomTP', 'travauxPratiquesObjectifsPeda','listeObjectifs','id')); 
        $this->set('_serialize', ['travauxPratiquesObjectifsPeda']);
        
    }

    /**
     * Efface une association
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $travauxPratiquesObjectifsPedas = $this->TravauxPratiquesObjectifsPedas->get($id);
        if ($this->TravauxPratiquesObjectifsPedas->delete($travauxPratiquesObjectifsPedas)) {
            $this->Flash->success(__("L'association a été supprimée."));
        } else {
            $this->Flash->error(__("L'association n'a pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }

}
