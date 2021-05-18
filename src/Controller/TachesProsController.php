<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TachesPros Controller
 */
class TachesProsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
    /**
     *Liste les TachesPros:
     *récupère les capacités & les classe ASC
     *puis les passes en paramètre à l'instance
     * Pagine les tachesPros terminales
     */
    public function index($activite_id = null)
    {
        /* mise ne place du filtre
         * */
        //on liste les classes pour le select qui sert de filtre de la vue avec numeNom
		$listeActivites = $this->TachesPros->Activites->find('list')
												->order(['numero' => 'ASC']);
        /* On regarde si un filtre par classe est appliqué sur la page index en POST
		 * (appuie sur le bouton 'filtrer du formulaire') ou si on a passé un paramètre */
		 
		/*******************************************************
		 * Récupération des données à afficher selon le filtre
		 * ***********************************************************/
		
		if ($this->request->is('post')) 
		{
			//on stocke la valeur du formulaire pour utilisation utérieure
			$activite_id = $this->request->getData()['activite_id'];
		}
		if ($activite_id !== null)	
		{
			$tachesPros = $this->TachesPros->find()
							->contain(['Autonomies','Activites'])
							->where(['activite_id' => $activite_id])
							->order(['Activites.numero' => 'ASC', 'TachesPros.numero' => 'ASC']);
							//debug($tachesPros);die;
		}else 
		{
			$tachesPros = $this->TachesPros->find()
							->contain('Autonomies')
							->contain('Activites')
							->order(['Activites.numero' => 'ASC', 'TachesPros.numero' => 'ASC']);
		}
		 
        
							
        $this->set(compact('tachesPros','activite_id','listeActivites'));
        $this->set('_serialize', ['tachesPros']);
		
    }
	/***************** Ajoute une tâche principale
     **********************************************************/
    public function add($activite_id = null)
    {
        /* ***************************************************
         * Création des tableaux pour les listes déroulantes 
         * Activites et Autonomies
         * ***************************************************
         */
        $activites = $this->TachesPros->Activites->find()->order(['numero' => 'ASC']);
        foreach ($activites as $activite) 
		{
			$listeActivites[$activite->id] = $activite->NumeNom ;
		}
        
        $autonomies = $this->TachesPros->Autonomies->find()->order(['numero' => 'ASC']);
        
        $activites = $this->TachesPros->Activites->find()->order(['numero' => 'ASC']);
        foreach ($autonomies as $autonomie) 
		{
			$listeAutonomies[$autonomie->id] = $autonomie->NumeNom ;
		}
        
        
        
        /* *********************************************
         * Création de l'entity pour stockage dans DB 
         * *********************************************/ 
        $tachesPro = $this->TachesPros->newEntity();                                   // crée une nouvelle entité dans $tachesPro
        if ($this->request->is('post')) {
			$activite_id = $this->request->getData()['activite_id'];
            $tachesPro = $this->TachesPros->patchEntity($tachesPro, $this->request->getData());  //??
            if ($this->TachesPros->save($tachesPro)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('La tâche professionnelle a été sauvegardée.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index', $activite_id]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La tâche professionnelle n\'a pas pu être sauvegardée ! Réessayer.')); //Affiche une infobulle
            }
        }
             
        $this->set(compact('tachesPro','listeActivites','listeAutonomies','activite_id')); 
        $this->set('_serialize', ['tachesPro']);
    }
    
    
    /**
     * Édite un utilisateur
     */
    public function edit($id = null)   //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        /* ***************************************************
         * Création des tableaux pour les listes déroulantes 
         * Activites et Autonomies
         * ***************************************************
         */
        $activites = $this->TachesPros->Activites->find()->order(['numero' => 'ASC']);
        foreach ($activites as $activite) 
		{
			$listeActivites[$activite->id] = $activite->NumeNom ;
		}
        
        $autonomies = $this->TachesPros->Autonomies->find()->order(['numero' => 'ASC']);
        
        $activites = $this->TachesPros->Activites->find()->order(['numero' => 'ASC']);
        foreach ($autonomies as $autonomie) 
		{
			$listeAutonomies[$autonomie->id] = $autonomie->NumeNom ;
		}
        
        
        
        /* *********************************************
         * Modification de l'entity pour stockage dans DB 
         * *********************************************/
        
        
        //récupère le contenu de la table tachesPros_terminales en fonction de l'id'
        $tachesPro = $this->TachesPros->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {                        // Vérifie le type de requête
            $tachesPro = $this->TachesPros->patchEntity($tachesPro, $this->request->getData());
            if ($this->TachesPros->save($tachesPro)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('La tâche professionnelle a été sauvegardée.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La tâche professionnelle n\' pas pu être sauvegardée ! Réessayer.')); //Sinon affiche une erreur
            }
        }
        
        $this->set(compact('tachesPro','listeActivites','listeAutonomies','activite_id'));
        $this->set('_serialize', ['tachesPro']);
    }
    
    /************* Affiche toutes les données d'un utilisateur************************
     ********************************************************************************/
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $tachesPro = $this->TachesPros->get($id, ['contain' => ['Activites','Autonomies'] ]);
							
        $this->set(compact('tachesPro'));                                  // Passe le paramètre 'tachesPro' à la vue.
        $this->set('_serialize', ['tachesPro']);
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $tachesPro = $this->TachesPros->get($id);
        if ($this->TachesPros->delete($tachesPro)) {
            $this->Flash->success(__("La tâche professionnelle a été supprimée."));
        } else {
            $this->Flash->error(__("La tâche professionnelle n'a pas pu être supprimée ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }

}
