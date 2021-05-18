<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SousChapitres Controller
 */
class SousChapitresController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
    
    public function index($chapitre_id = null)
    { 
        //on liste les classes pour le select qui sert de filtre de la vue avec numeNom
		$listeChapitres = $this->SousChapitres->Chapitres->find('list')
												->order(['numero' => 'ASC']);
        /* On regarde si un filtre par classe est appliqué sur la page index en POST
		 * (appuie sur le bouton 'filtrer du formulaire') ou si on a passé un paramètre */
		 
		/*******************************************************
		 * Récupération des données à afficher selon le filtre
		 * ***********************************************************/
		
		if ($this->request->is('post')) 
		{
			//on stocke la valeur du formulaire pour utilisation utérieure
			$chapitre_id = $this->request->getData()['chapitre_id'];
		}
		if ($chapitre_id !== null)	
		{
			$sousChapitres = $this->SousChapitres->find()
							->contain(['Chapitres'])
							->where(['chapitre_id' => $chapitre_id])
							->order(['Chapitres.numero' => 'ASC', 'SousChapitres.numero' => 'ASC']);
		}else 
		{
			$sousChapitres = $this->SousChapitres->find()
							->contain(['Chapitres'])
							->order(['Chapitres.numero' => 'ASC', 'SousChapitres.numero' => 'ASC']);
		}
		
		$this->set(compact('sousChapitres','listeChapitres','chapitre_id'));
        $this->set('_serialize', ['sousChapitres']);
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $sousChapitre = $this->SousChapitres->get($id, ['contain' => ['Chapitres'] ]);							
        $this->set(compact('sousChapitre'));                                  // Passe le paramètre 'sousChapitre' à la vue.
        $this->set('_serialize', ['sousChapitre']);
    }

    /**
     * Ajoute un utilisateur
     */
    public function add($chapitre_id = null)
    {
        $sousChapitre = $this->SousChapitres->newEntity();                                   // crée une nouvelle entité dans $sousChapitre
        if ($this->request->is('post')) {
			$activite_id = $this->request->getData()['chapitre_id'];                                           //si requête de type post
            $sousChapitre = $this->SousChapitres->patchEntity($sousChapitre, $this->request->getData());  //??
            if ($this->SousChapitres->save($sousChapitre)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('Le sous-chapitre a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index', $chapitre_id]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le sous-chapitre n\'a pas pu être sauvegardé ! Réessayer.')); //Affiche une infobulle
            }
        }
        $listeChapitres = $this->SousChapitres->Chapitres->find('list')->order(['numero' => 'ASC']);     
        $this->set(compact('sousChapitre','listeChapitres','chapitre_id')); 
        $this->set('_serialize', ['sousChapitre']);
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)   //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        
        //récupère le contenu de la table sousChapitres_terminales en fonction de l'id'
        $sousChapitre = $this->SousChapitres->get($id, [
            'contain' => []
        ]);

        //récupère le contenu de la table SousChapitres en fonction de l'id = a capacite_id
        //$capacite = $this->SousChapitres->SousChapitres->get($capacite->id, ['contain' => [] ]);
        if ($this->request->is(['patch', 'post', 'put'])) {                        // Vérifie le type de requête
            $sousChapitre = $this->SousChapitres->patchEntity($sousChapitre, $this->request->getData());
            if ($this->SousChapitres->save($sousChapitre)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('Le sous-chapitre a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le sous-chapitre n\' pas pu être sauvegardé ! Réessayer.')); //Sinon affiche une erreur
            }
        }
		$listeChapitres = $this->SousChapitres->Chapitres->find('list')->order(['numero' => 'ASC']);
        $this->set(compact('sousChapitre', 'chapitres','listeChapitres'));
        $this->set('_serialize', ['sousChapitre']);
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $sousChapitre = $this->SousChapitres->get($id);
        if ($this->SousChapitres->delete($sousChapitre)) {
            $this->Flash->success(__('Le sous-chapitre a été supprimé.'));
        } else {
            $this->Flash->error(__('Le sous-chapitre n\'a pas pu être supprimé ! Réessayer.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
