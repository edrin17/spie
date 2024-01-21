<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

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
     * Pagine les competences terminales
     */
    public function index()
    {
		$this->_loadFilters();
		
		$tache = $this->TachesPros;
        $referential_id = $this->viewVars['referential_id'];
        $activite_id = $this->viewVars['activite_id'];
        //debug($referential_id);debug($activite_id);die;
		$listeTachesPros = $tache->find()
			->contain(['Activites','Autonomies'])
            ->where([
                'activite_id' => $activite_id,
                ])
			->order([
				'Activites.numero' => 'ASC',
				'TachesPros.numero' => 'ASC'
			]);
	    $this->set(compact('listeTachesPros'));
        
        //build a new entity to send go params pattern to the create helper in the view
        $tache = $this->TachesPros->newEntity();
        $this->set(compact('tache'));
        
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
        $tacheinale = $this->TachesPros->newEntity();
        if ($this->request->is('post')) {  //si on a cliqué sur "Ajouter".
            $tacheinale = $this->TachesPros->patchEntity($tacheinale, $this->request->getData());
            $referential_id = $this->request->getData('referential_id');
            $activite_id = $this->request->getData('activite_id');
            if ($this->TachesPros->save($tacheinale)) { // si pas d'erreur remontée.
                $this->Flash->success(__(
					"La tâche a été sauvegardéé."
                ));
                return $this->redirect([
                    'action' => 'index',
                    'referential_id' => $referential_id,
                    'activite_id' => $activite_id,
                ]);
            } else {
                $this->Flash->error(__(
					"La tâche n'a pas pu être sauvegardée ! Réessayer."
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
        $tache = $this->TachesPros;
        $tacheinale = $tache->get($id,['contain'=>['Activites']]);
        $referential_id = $tacheinale->activite->referential_id;
        $activite_id = $tacheinale->activite_id;
        //récupère le contenu de la table activites en fonction de l'id = a activiteId
        //$activites = $tache->Activites->get($activites->id, ['contain' => [] ]);
        if ($this->request->is(['patch', 'post', 'put'])) {                        // Vérifie le type de requête
            $tacheinale = $tache->patchEntity($tacheinale, $this->request->getData());
            if ($tache->save($tacheinale)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('La tâche a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect([
                    'action' => 'index',
                    'referential_id' => $referential_id,
                    'activite_id' => $activite_id,
                ]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La tâche n\' pas pu être sauvegarder ! Réessayer.')); //Sinon affiche une erreur
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
        $tache = $this->TachesPros;
        $tacheinale = $tache->get($id,['contain'=>['Activites']]);
        $referential_id = $tacheinale->activite->referential_id;
        $activite_id = $tacheinale->activite_id;

        if ($tache->delete($tacheinale)) {
            $this->Flash->success(__('La tâche a été supprimé.'));
        } else {
            $this->Flash->error(__('La tâche n\' pas pu être supprimée ! Réessayer.'));
        }
        return $this->redirect([
            'action' => 'index',
            'referential_id' => $referential_id,
            'activite_id' => $activite_id
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
        $activitesTbl = TableRegistry::get('Activites');
        $activites = $activitesTbl->find('list')
            ->where(['referential_id' => $referential_id])
            ->order(['numero' => 'ASC']);
        
        //get id from request
        $activite_id = $this->request->getQuery('activite_id');

        //if request empty get first in the list
        if ($activite_id =='') {
            $activite_id = $activitesTbl->find()
            ->where(['referential_id' => $referential_id])
            ->order(['numero' => 'ASC'])
            ->first()
            ->id;
        }

        $this->set(compact( //passage des variables à la vue
            'activites', 'activite_id'
        ));

        //chargement de la liste des capacités selon le référentiel
        $autonomyTbl = TableRegistry::get('Autonomies');
        $autonomies = $autonomyTbl->find('list')
            ->order(['numero' => 'ASC']);
        
        $this->set(compact( //passage des variables à la vue
            'autonomies'
        ));
    }
}
