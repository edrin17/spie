<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

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
    /**
     *Liste les SousChapitres:
     *récupère les capacités & les classe ASC
     *puis les passes en paramètre à l'instance
     * Pagine les competences terminales
     */
    public function index($chapitre_id = null)
    {
        $this->_loadFilters();
		$referential_id = $this->viewVars['referential_id'];
        $savoir_id = $this->viewVars['savoir_id'];
        $chapitre_id = $this->viewVars['chapitre_id'];
        $sousChapitres = $this->SousChapitres->find()
									->contain(['Chapitres.Savoirs.Referentials','NiveauxTaxos'])
                                    ->where(['chapitre_id' => $chapitre_id])
									->order(['Savoirs.numero' => 'ASC',
										'Chapitres.numero' => 'ASC',
										'SousChapitres.numero' => 'ASC']);
        //debug($sousChapitres->toArray());
        $this->set(compact('sousChapitres'));
        
        //build a new entity to send go params pattern to the create helper in the view
        $sousChapitre = $this->SousChapitres->newEntity();
        $this->set(compact('sousChapitre'));
        
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
    private function _add()
    {
        $sousChapitre = $this->SousChapitres->newEntity();
        if ($this->request->is('post')) {                                           //si requête de type post
            $sousChapitre = $this->SousChapitres->patchEntity($sousChapitre, $this->request->getData());
            $referential_id = $this->request->getData('referential_id');
            $savoir_id = $this->request->getData('savoir_id');
            $chapitre_id = $this->request->getData('chapitre_id');
            if ($this->SousChapitres->save($sousChapitre)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('Le sous chapitre a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect([
                    'action' => 'index',
                    'referential_id' => $referential_id,
                    'savoir_id' => $savoir_id,
                    'chapitre_id' => $chapitre_id,
                    
            ]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le sous chapitre n\'a pas pu être sauvegardé ! Réessayer.')); //Affiche une infobulle
            }
        }
    }

    /**
     * Édite un utilisateur
     */
    private function _edit()
    {
        //get entity form 'id' param
        $id = $this->request->getData('entityId');
        $sousChapitre = $this->SousChapitres->get($id,[
            'contain'=>['Chapitres.Savoirs']
        ]);
        $referential_id = $sousChapitre->chapitre->savoir->referential_id;
        $savoir_id = $sousChapitre->chapitre->savoir_id;
        $chapitre_id = $sousChapitre->chapitre_id;
        
        if ($this->request->is(['patch', 'post', 'put'])) {                        // Vérifie le type de requête
            $sousChapitre = $this->SousChapitres->patchEntity($sousChapitre, $this->request->getData());
            if ($this->SousChapitres->save($sousChapitre)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('Le sous chapitre a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect([
                    'action' => 'index',
                    'referential_id' => $referential_id,
                    'savoir_id' => $savoir_id,
                    'chapitre_id' => $chapitre_id,
                ]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le sous chapitre n\' pas pu être sauvegarder ! Réessayer.')); //Sinon affiche une erreur
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
        $sousChapitre = $this->SousChapitres->get($id,[
            'contain'=>['Chapitres.Savoirs']
        ]);
        $referential_id = $sousChapitre->chapitre->savoir->referential_id;
        $savoir_id = $sousChapitre->chapitre->savoir_id;
        $chapitre_id = $sousChapitre->chapitre_id;

        if ($this->SousChapitres->delete($sousChapitre)) {
            $this->Flash->success(__('Le sous chapitre a été supprimé.'));
        } else {
            $this->Flash->error(__('Le sous chapitre n\' pas pu être supprimer ! Réessayer.'));
        }
        return $this->redirect([
            'action' => 'index',
            'referential_id' => $referential_id,
            'savoir_id' => $savoir_id,
            'chapitre_id' => $chapitre_id,
        ]);
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

        //si requête vide selection du premier de la liste
        if ($referential_id =='') {
            $referential_id = $referentialsTbl->find()
            ->order(['name' => 'ASC'])
            ->first()
            ->id;
        }
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
            ->where(['referential_id' => $referential_id])
            ->order(['numero' => 'ASC'])
            ->first()
            ->id;
        }

        $this->set(compact( //passage des variables à la vue
            'savoirs', 'savoir_id'
        ));

        //chargement de la liste des compétences inter selon la compétence Terminale
        $chapitresTbl = TableRegistry::get('Chapitres');
        $chapitres = $chapitresTbl->find('list')
            ->contain(['Savoirs'])
            ->where(['savoir_id' => $savoir_id])
            ->order([
                'Savoirs.numero' => 'ASC',
                'Chapitres.numero' => 'ASC'
            ]);
        
        //get id from request
        $chapitre_id = $this->request->getQuery('chapitre_id');

        //if request empty get first in the list
        if ($chapitre_id =='') {
            $chapitre_id = $chapitresTbl->find()
            ->contain(['Savoirs'])
            ->where(['savoir_id' => $savoir_id])
            ->order([
                'Savoirs.numero' => 'ASC',
                'Chapitres.numero' => 'ASC'
            ])
            ->first()
            ->id;
        }

        $this->set(compact( //passage des variables à la vue
            'chapitres', 'chapitre_id'
        ));

        //chargement de la liste des capacités selon le référentiel
        $niveauxTaxosTbl = TableRegistry::get('NiveauxTaxos');
        $niveauxTaxos = $niveauxTaxosTbl->find('list')
            ->order(['numero' => 'ASC']);
        
        $this->set(compact( //passage des variables à la vue
            'niveauxTaxos'
        ));
        //debug($niveauxTaxos->toArray());die;
    }

}
