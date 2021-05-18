<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CompetencesTerminales Controller
 */
class CompetencesTerminalesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
    /**
     *Liste les CompetencesTerminales:
     *récupère les capacités & les classe ASC
     *puis les passes en paramètre à l'instance
     * Pagine les competences terminales
     */
    public function index()
    {
        $competences = $this->CompetencesTerminales->find()
							->contain('Capacites')
							->select(['id','nom','numero','Capacites.numero','Capacites.nom'])
							->order(['Capacites.numero' => 'ASC', 'CompetencesTerminales.numero' => 'ASC']);

        

        $this->set(compact('competences'));
        $this->set('_serialize', ['competences']);
        //debug($lis); die();
		
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $competence = $this->CompetencesTerminales->get($id, ['contain' => [] ]);
        
        $capacites = $this->CompetencesTerminales->Capacites->find()
							->select(['numero','nom'])
							->matching('CompetencesTerminales')
							->where(['CompetencesTerminales.capacite_id' => $competence->capacite_id]);
							
        $this->set(compact('competence', 'capacites'));                                  // Passe le paramètre 'competence' à la vue.
        $this->set('_serialize', ['competence']);
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        $competence = $this->CompetencesTerminales->newEntity();                                   // crée une nouvelle entité dans $competence
        if ($this->request->is('post')) {                                           //si requête de type post
            $competence = $this->CompetencesTerminales->patchEntity($competence, $this->request->getData());  //??
            if ($this->CompetencesTerminales->save($competence)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('La compétence a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La compétence n\'a pas pu être sauvegardé ! Réessayer.')); //Affiche une infobulle
            }
        }
        $capacites = $this->CompetencesTerminales->Capacites->find()->order(['numero' => 'ASC']);     
        $this->set(compact('competence','capacites')); 
        $this->set('_serialize', ['competence']);
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)   //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        
        //récupère le contenu de la table competences_terminales en fonction de l'id'
        $competence = $this->CompetencesTerminales->get($id, [
            'contain' => []
        ]);

        //récupère le contenu de la table capacites en fonction de l'id = a capacite_id
        //$capacite = $this->CompetencesTerminales->Capacites->get($capacite->id, ['contain' => [] ]);
        if ($this->request->is(['patch', 'post', 'put'])) {                        // Vérifie le type de requête
            $competence = $this->CompetencesTerminales->patchEntity($competence, $this->request->getData());
            if ($this->CompetencesTerminales->save($competence)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('La compétence a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La compétence n\' pas pu être sauvegarder ! Réessayer.')); //Sinon affiche une erreur
            }
        }
        
        // Récupère les données de la table capacites et les classe par ASC
        $capacites = $this->CompetencesTerminales->Capacites->find()->order(['numero' => 'ASC']);
        $this->set(compact('competence', 'capacites'));
        $this->set('_serialize', ['competence']);
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $competence = $this->CompetencesTerminales->get($id);
        if ($this->CompetencesTerminales->delete($competence)) {
            $this->Flash->success(__('La compétence a été supprimé.'));
        } else {
            $this->Flash->error(__('La compétence n\' pas pu être supprimée ! Réessayer.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
