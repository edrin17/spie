<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * Users Controller
 */
class PeriodesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

    public function index()
    {
        $this->_loadFilters($this->request);
        $progression_id = $this->viewVars['progression_id'];
        $progressionsTable = TableRegistry::get('Progressions');
        $periodes = $this->Periodes->find()
				->contain(['Progressions'])
                ->where(['Progressions.id' => $progression_id])
				->order(['Periodes.numero' => 'ASC']);

        //debug($periodes->toArray());
    	$this->set(compact('periodes','progression_id'));

        //build a new entity to send go params pattern to the create helper in the view
        $periode = $this->Periodes->newEntity();
        $this->set(compact('periode'));
        
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
        $periode = $this->Periodes->newEntity();
        $periode = $this->Periodes->patchEntity($periode, $this->request->getData());
        $referential_id = $this->request->getData('referential_id');
        $progression_id = $this->request->getData('progression_id');                                   // crée une nouvelle entité dans $periode
                                         //si requête de type post
        $periode = $this->Periodes->patchEntity($periode, $this->request->getData());
        if ($this->Periodes->save($periode)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
            $this->Flash->success(__("La période a été sauvegardée."));      //Affiche une infobulle
            return $this->redirect([
                'action' => 'index',
                'referential_id' => $referential_id,
                'progression_id' => $progression_id,
                
            ]);                      //Déclenche la fonction 'index' du controlleur
        } else {
            $this->Flash->error(__("La période n\'a pas pu être sauvegardée ! Réessayer.")); //Affiche une infobulle
        }

    }

	/**
     * Édite un utilisateur
     */
    public function _edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        //get entity form 'id' param
        $id = $this->request->getData('entityId');
        $periodes = $this->Periodes->get($id,[
            'contain'=>[]
        ]);
        $referential_id = $periodes->referential_id;
        $progression_id = $periodes->progression_id;
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $periodes = $this->Periodes->patchEntity($periodes, $this->request->getData());
            if ($this->Periodes->save($periodes)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__("La période a été sauvegardée."));      //Affiche une infobulle
                return $this->redirect([
                    'action' => 'index',
                    'referential_id' => $referential_id,
                    'progression_id' => $progression_id,
                    
                ]);
            } else {
                $this->Flash->error(__("La période n\'a pas pu être sauvegardée ! Réessayer."));
            }
        }
    }



    /**
     * Efface un utilisateur
     */
    public function _delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $periode = $this->Periodes->get($id);
        if ($this->Periodes->delete($periode)) {
            $this->Flash->success(__("La période a été supprimée."));
        } else {
            $this->Flash->error(__("La période n' pas pu être supprimée ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }

     // Load list and selected filters for each dropdown menus from $_GET
    // params: 'referential_id' ; 'savoir_id' ; 'chapitre_id'
    private function _loadFilters($resquest = null)
    {
        //chargement de la liste des référentiels
        $referentialsTbl = TableRegistry::get('Referentials');
        $referentials = $referentialsTbl->find('list')
            ->order(['name' => 'ASC']);
        
        //récup du filtre existant dans la requête
        $referential_id = $this->request->getQuery('referential_id');

        //si requête vide slection du premier de la liste
        if ($referential_id =='') {
            $referential_id = $referentialsTbl->find()
            ->order(['name' => 'ASC'])
            ->first()
            ->id;
        }

        $this->set(compact( //passage des variables à la vue
            'referentials', 'referential_id'
        ));
        //-------------------Progression-------------------------
        $progressionsTbl = TableRegistry::get('Progressions');
        $progressions = $progressionsTbl->find('list')
            ->where(['referential_id' => $referential_id])
            ->order(['nom' => 'ASC']);
        
        $progression_id = $this->request->getQuery('progression_id');

        if ($progression_id =='') {
            $progression_id = $progressionsTbl->find()
            ->where(['referential_id' => $referential_id])
            ->order(['nom' => 'ASC'])
            ->first()
            ->id;
        }

        //-------------------Periodes-------------------------
        $periodesTbl = TableRegistry::get('Periodes');
        $periodes = $periodesTbl->find('list')
            ->where(['progression_id' => $progression_id])
            ->order(['numero' => 'ASC']);
        

        $periode_id = $this->request->getQuery('periode_id');

        
        if ($periode_id =='') {
            $periode_id = $periodesTbl->find()
            ->where(['progression_id' => $progression_id])
            ->order(['numero' => 'ASC'])
            ->first()->id;
        }
        
        $this->set(compact( //passage des variables à la vue
            'progression_id', 'progressions',
            'periodes', 'periode_id',
        ));
    }
}
