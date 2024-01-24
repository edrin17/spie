<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 */
class ChapitresController extends AppController
{
    public function initialize()
	{
		parent::initialize();
		
		$this->viewBuilder()->setLayout('default');
	}
    /**
     *Liste les Chapitres:
     *récupère les capacités & les classe ASC
     *puis les passes en paramètre à l'instance
     * Pagine les competences terminales
     */
    public function index()
    {
		$this->_loadFilters();
		
		$chapitreTbl = $this->Chapitres;
        $referential_id = $this->viewVars['referential_id'];
        $savoir_id = $this->viewVars['savoir_id'];
		$listeChapitres = $chapitreTbl->find()
			->contain(['Savoirs'])
            ->where([
                'referential_id' => $referential_id,
                'savoir_id' => $savoir_id,
                ])
			->order([
				'Savoirs.numero' => 'ASC',
				'Chapitres.numero' => 'ASC'
			]);
	    $this->set(compact('listeChapitres'));
        
        //build a new entity to send go params pattern to the create helper in the view
        $chapitre = $this->Chapitres->newEntity();
        $this->set(compact('chapitre'));
        
        //choose action if POST
        $requestType = $this->request->is(['patch', 'post', 'put', 'delete']);
        $action = $this->request->getData('action');
        if ($requestType) {
           if ($action === 'add') {
            $this->_add($this->request);
           }
           if ($action === 'edit') {
            $this->_edit($this->request);
           }
           if ($action === 'delete') {
            $this->_delete($this->request);
           }
        }
		
    }

    /**
     * Ajoute un utilisateur
     */
    public function _add()
    {				
        $chapitre = $this->Chapitres->newEntity();
        if ($this->request->is('post')) {  //si on a cliqué sur "Ajouter".
            $chapitre = $this->Chapitres->patchEntity($chapitre, $this->request->getData());
            $referential_id = $this->request->getData('referential_id');
            $savoir_id = $this->request->getData('savoir_id');
            if ($this->Chapitres->save($chapitre)) { // si pas d'erreur remontée.
                $this->Flash->success(__(
					"Le chapitre terminale a été sauvegardéé."
                ));
                return $this->redirect([
                    'action' => 'index',
                    'referential_id' => $referential_id,
                    'savoir_id' => $savoir_id,
                ]);
            } else {
                $this->Flash->error(__(
					"Le chapitre terminale n'a pas pu être sauvegardée ! Réessayer."
				));
            }
        }
    }

    /**
     * Édite un utilisateur
     */
    public function _edit($id = null)   //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        
        //get entity form 'id' param
        $id = $this->request->getData('entityId');
        $chapitreTbl = $this->Chapitres;
        $chapitre = $chapitreTbl->get($id,['contain'=>['Savoirs']]);
        $referential_id = $chapitre->savoir->referential_id;
        $savoir_id = $chapitre->savoir_id;
        //récupère le contenu de la table savoirs en fonction de l'id = a savoirId
        //$savoirs = $chapitreTbl->Savoirs->get($savoirs->id, ['contain' => [] ]);
        if ($this->request->is(['patch', 'post', 'put'])) {                        // Vérifie le type de requête
            $chapitre = $chapitreTbl->patchEntity($chapitre, $this->request->getData());
            if ($chapitreTbl->save($chapitre)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('Le chapitre a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect([
                    'action' => 'index',
                    'referential_id' => $referential_id,
                    'savoir_id' => $savoir_id,
                ]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le chapitre n\' pas pu être sauvegarder ! Réessayer.')); //Sinon affiche une erreur
            }
        }
    }

    /**
     * Efface un utilisateur
     */
    public function _delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        //get entity form 'id' param
        $id = $this->request->getData('entityId');
        $chapitreTbl = $this->Chapitres;
        $chapitre = $chapitreTbl->get($id,['contain'=>['Savoirs']]);
        $referential_id = $chapitre->savoir->referential_id;
        $savoir_id = $chapitre->savoir_id;

        if ($chapitreTbl->delete($chapitre)) {
            $this->Flash->success(__('Le chapitre a été supprimé.'));
        } else {
            $this->Flash->error(__('Le chapitre n\' pas pu être supprimée ! Réessayer.'));
        }
        return $this->redirect([
            'action' => 'index',
            'referential_id' => $referential_id,
            'savoir_id' => $savoir_id
        ]);
    }

    private function _loadFilters($resquest = null)
    {
        //chargement de la liste des référentiels
        $referentialsTbl = TableRegistry::get('Referentials');
        $referentials = $referentialsTbl->find('list')
            ->order(['name' => 'ASC']);
        
        //récup du filtre existant dans la requête
        $referential_id = $this->request->getQuery('referential_id');

        //si requête vide selection du premier de la liste
        if ($referential_id =='') {
            $referential_id = $referentialsTbl->find()
            ->order(['name' => 'ASC'])
            ->first()
            ->id;
        }

        //send  referential + id 
        $this->set(compact( 
            'referentials', 'referential_id'
        ));

        //chargement de la liste des capacités selon le référentiel
        $savoirsTbl = TableRegistry::get('Savoirs');
        $savoirs = $savoirsTbl->find('list')
            ->where(['referential_id' => $referential_id])
            ->order(['numero' => 'ASC']);
        
        //get id from request
        $savoir_id = $this->request->getQuery('savoir_id');

        //if request empty get first in the list
        if ($savoir_id =='') {
            $savoir_id = $savoirsTbl->find()
            ->order(['numero' => 'ASC'])
            ->first()
            ->id;
        }

        $this->set(compact( //passage des variables à la vue
            'savoirs', 'savoir_id'
        ));
    }
}
