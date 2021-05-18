<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class NiveauxCompetencesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
	
     public function index()
    {
        // Utilise le helper paginate
        $this->set('niveauxCompetences', $this->paginate($this->NiveauxCompetences)); //'niveauxCompetences' est l'alias de la variable globale pour la vue'index.ctp'
        $this->set('_serialize', ['niveauxCompetences']);
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $niveauxCompetence = $this->NiveauxCompetences->get($id, ['contain' => [] ]);
        $this->set('niveauxCompetence', $niveauxCompetence);                                  // Passe le paramètre 'niveauxCompetence' à la vue.
        $this->set('_serialize', ['niveauxCompetence']);                         // Sérialize 'niveauxCompetence'
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        $niveauxCompetence = $this->NiveauxCompetences->newEntity();                                   // crée une nouvelle entité dans $niveauxCompetence
        if ($this->request->is('post')) {                                           //si requête de type post
            $niveauxCompetence = $this->NiveauxCompetences->patchEntity($niveauxCompetence, $this->request->getData());  //??
            if ($this->NiveauxCompetences->save($niveauxCompetence)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('Le niveaux de compétence a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le niveaux de compétence n\'a pas pu être sauvegardé ! Réessayer.')); //Affiche une infobulle
            }
        }
        $this->set(compact('niveauxCompetence')); 
        $this->set('_serialize', ['niveauxCompetence']);
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $niveauxCompetence = $this->NiveauxCompetences->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $niveauxCompetence = $this->NiveauxCompetences->patchEntity($niveauxCompetence, $this->request->getData());
            if ($this->NiveauxCompetences->save($niveauxCompetence)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__('Le niveaux de compétence a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le niveaux de compétence n\' pas pu être sauvegarder ! Réessayer.'));
            }
        }
        $this->set(compact('niveauxCompetence'));
        $this->set('_serialize', ['niveauxCompetence']);
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $niveauxCompetence = $this->NiveauxCompetences->get($id);
        if ($this->NiveauxCompetences->delete($niveauxCompetence)) {
            $this->Flash->success(__('Le niveaux de compétence a été supprimé.'));
        } else {
            $this->Flash->error(__('Le niveaux de compétence n\' pas pu être supprimer ! Réessayer.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
