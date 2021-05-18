<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TravauxPratiquesObjectifsPedasController
 */
class CompetencesSavoirsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

    public function index($competence_id = null)
    {
		$listeCompsTerms = $this->CompetencesSavoirs->CompetencesTerminales->find()
			->contain(['Capacites'])
			->order(['Capacites.numero' => 'ASC', 'CompetencesTerminales.numero' => 'ASC']);
		
		$listeSousChapitres = $this->CompetencesSavoirs->SousChapitres->find()
			->contain(['Chapitres'])
			->order(['Chapitres.numero' => 'ASC', 'SousChapitres.numero' => 'ASC']);
		
		$listeCompsSavoirs = $this->CompetencesSavoirs->find();
		
		foreach ($listeCompsTerms as $listeCompsTerm) 
		{
			foreach ($listeSousChapitres as $listeSousChapitre) 
			{
				$tableau[$listeCompsTerm->id][$listeSousChapitre->id] = false;
			}
		}					
		 
		foreach ($listeCompsSavoirs as $listeCompsSavoir) 
		{
			$tableau[$listeCompsSavoir->competences_terminale_id][$listeCompsSavoir->sous_chapitre_id] = $listeCompsSavoir->id;
		}
		
		//debug($tableau);die;
		
		

		
		$this->set(compact(['listeCompsTerms','listeSousChapitres','competence_id','tableau']));
		//$listeCompsTerms
		
    }
	/***************** Ajoute une tâche principale
     **********************************************************/
    public function add($ids = null)
    {
        $competencesSavoir = $this->CompetencesSavoirs->newEntity();                              
        if ($ids !== null) {
			$ids = explode("|",$ids);
			$data = [
				'competences_terminale_id' => $ids[0],
				'sous_chapitre_id' => $ids[1]				
			];  
            $competencesSavoir = $this->CompetencesSavoirs->patchEntity($competencesSavoir, $data);  
            if ($this->CompetencesSavoirs->save($competencesSavoir)) {      
                $this->Flash->success(__("Le lien compétence - savoir a été sauvegardé !"));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("Le lien compétence - savoir n'a pas pu être sauvegardée ! Réessayer."));
                return $this->redirect(['action' => 'index']);
            }
        }
    }

    /**
     * Efface une association
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        //debug($id);die;
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $competencesSavoir = $this->CompetencesSavoirs->get($id);
        if ($this->CompetencesSavoirs->delete($competencesSavoir)) {
            $this->Flash->success(__("L'association a été supprimée."));
        } else {
            $this->Flash->error(__("L'association n'a pas pu être supprimée ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }

}
