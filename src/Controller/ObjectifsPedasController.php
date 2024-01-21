<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * ObjectifsPedas Controller
 */
class ObjectifsPedasController extends AppController
{
    public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
    /**
     *Liste les CompetencesIntermediaires:
     *récupère les capacités & les classe ASC
     *puis les passes en paramètre à l'instance
     * Pagine les competences terminales
     */
    public function index($competences_terminale_id = null)
    {
        $this->_loadFilters();
		$referential_id = $this->viewVars['referential_id'];
        $capacite_id = $this->viewVars['capacite_id'];
        $competences_terminale_id = $this->viewVars['competences_terminale_id'];
        $competences_intermediaire_id = $this->viewVars['competences_intermediaire_id'];
        //$tableau = ['ref'=> $referential_id, 'capa' => $capacite_id, 'Term' => $competences_terminale_id ];
        //debug($tableau);
        $objectifsPedas = $this->ObjectifsPedas->find()
									->contain(['CompetencesIntermediaires.CompetencesTerminales.Capacites.Referentials'])
                                    ->contain(['NiveauxCompetences'])
                                    ->where(['competences_intermediaire_id' => $competences_intermediaire_id])
									->order(['Capacites.numero' => 'ASC',
										'CompetencesTerminales.numero' => 'ASC',
										'CompetencesIntermediaires.numero' => 'ASC',
                                        'NiveauxCompetences.numero' => 'ASC'
                                    ]);

        $this->set('objectifs',$objectifsPedas);
        
        //build a new entity to send go params pattern to the create helper in the view
        $objectif = $this->ObjectifsPedas->newEntity();
        $this->set(compact('objectif'));
        
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
        $objectifsPeda = $this->ObjectifsPedas->newEntity();
        if ($this->request->is('post')) {                                           //si requête de type post
            $objectifsPeda = $this->ObjectifsPedas->patchEntity($objectifsPeda, $this->request->getData());
            $referential_id = $this->request->getData('referential_id');
            $capacite_id = $this->request->getData('capacite_id');
            $competences_terminale_id = $this->request->getData('competences_terminale_id');
            $competences_intermediaire_id = $this->request->getData('competences_intermediaire_id');
            if ($this->ObjectifsPedas->save($objectifsPeda)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('La compétence a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect([
                    'action' => 'index',
                    'referential_id' => $referential_id,
                    'capacite_id' => $capacite_id,
                    'competences_terminale_id' => $competences_terminale_id,
                    'competences_intermediaire_id' => $competences_intermediaire_id,
                    
                ]);
            } else {
                $this->Flash->error(__('La compétence n\'a pas pu être sauvegardé ! Réessayer.')); //Affiche une infobulle
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
        $objectifsPeda = $this->ObjectifsPedas->get($id,[
            'contain'=>['CompetencesIntermediaires.CompetencesTerminales.Capacites']
        ]);
        $referential_id = $objectifsPeda->competences_intermediaire->competences_terminale->capacite->referential_id;
        $capacite_id = $objectifsPeda->competences_intermediaire->competences_terminale->capacite_id;
        $competences_terminale_id = $objectifsPeda->competences_intermediaire->competences_terminale_id;
        $competences_intermediaire_id = $objectifsPeda->competences_intermediaire_id;
        
        if ($this->request->is(['patch', 'post', 'put'])) {                        // Vérifie le type de requête
            $objectifsPeda = $this->ObjectifsPedas->patchEntity($objectifsPeda, $this->request->getData());
            if ($this->ObjectifsPedas->save($objectifsPeda)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('La compétence a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect([
                    'action' => 'index',
                    'referential_id' => $referential_id,
                    'capacite_id' => $capacite_id,
                    'competences_terminale_id' => $competences_terminale_id,
                    'competences_intermediaire_id' => $competences_intermediaire_id,
                ]);
            } else {
                $this->Flash->error(__('La compétence n\' pas pu être sauvegarder ! Réessayer.')); //Sinon affiche une erreur
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
        $objectifsPeda = $this->ObjectifsPedas->get($id,[
            'contain'=>['CompetencesIntermediaires.CompetencesTerminales.Capacites']
        ]);
        $referential_id = $objectifsPeda->competences_intermediaire->competences_terminale->capacite->referential_id;
        $capacite_id = $objectifsPeda->competences_intermediaire->competences_terminale->capacite_id;
        $competences_terminale_id = $objectifsPeda->competences_intermediaire->competences_terminale_id;
        $competences_intermediaire_id = $objectifsPeda->competences_intermediaire_id;

        if ($this->ObjectifsPedas->delete($objectifsPeda)) {
            $this->Flash->success(__('La compétence a été supprimé.'));
        } else {
            $this->Flash->error(__('La compétence n\' pas pu être supprimer ! Réessayer.'));
        }
        return $this->redirect([
            'action' => 'index',
            'referential_id' => $referential_id,
            'capacite_id' => $capacite_id,
            'competences_terminale_id' => $competences_terminale_id,
            'competences_intermediaire_id' => $competences_intermediaire_id,
        ]);
    }

    // Load list and selected filters for each dropdown menus from $_GET
    // params: 'referential_id' ; 'capacite_id' ; 'competences_terminale_id'
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
        $capacitesTbl = TableRegistry::get('Capacites');
        $capacites = $capacitesTbl->find('list')
            ->where(['referential_id' => $referential_id])
            ->order(['numero' => 'ASC']);
        
        //get id from request
        $capacite_id = $this->request->getQuery('capacite_id');

        //if request empty get first in the list
        if ($capacite_id =='') {
            $capacite_id = $capacitesTbl->find()
            ->where(['referential_id' => $referential_id])
            ->order(['numero' => 'ASC'])
            ->first()
            ->id;
        }

        $this->set(compact( //passage des variables à la vue
            'capacites', 'capacite_id'
        ));

        //chargement de la liste des compétences Term selon la Capacité
        $compTermTbl = TableRegistry::get('CompetencesTerminales');
        $competencesTerminales = $compTermTbl->find('list')
            ->contain(['Capacites'])
            ->where(['capacite_id' => $capacite_id])
            ->order([
                'Capacites.numero' => 'ASC',
                'CompetencesTerminales.numero' => 'ASC'
            ]);
        
        //get id from request
        $competences_terminale_id = $this->request->getQuery('competences_terminale_id');

        //if request empty get first in the list
        if ($competences_terminale_id =='') {
            $competences_terminale_id = $compTermTbl->find()
            ->contain(['Capacites'])
            ->where(['capacite_id' => $capacite_id])
            ->order([
                'Capacites.numero' => 'ASC',
                'CompetencesTerminales.numero' => 'ASC'
            ])
            ->first()
            ->id;
        }

        $this->set(compact( //passage des variables à la vue
            'competencesTerminales', 'competences_terminale_id'
        ));
        
        //chargement de la liste des compétences inter selon la compétence Terminale
        $compInterTbl = TableRegistry::get('CompetencesIntermediaires');
        $competencesIntermediaires = $compInterTbl->find('list')
            ->contain(['CompetencesTerminales.Capacites'])
            ->where(['competences_terminale_id' => $competences_terminale_id])
            ->order([
                'CompetencesTerminales.numero' => 'ASC',
                'CompetencesIntermediaires.numero' => 'ASC'
            ]);

        //get id from request
        $competences_intermediaire_id = $this->request->getQuery('competences_intermediaire_id');

        //if request empty get first in the list
        if ($competences_intermediaire_id =='') {
            $competences_intermediaire_id = $compInterTbl->find()
            ->contain(['CompetencesTerminales'])
            ->where(['competences_terminale_id' => $competences_terminale_id])
            ->order([
                'CompetencesTerminales.numero' => 'ASC',
                'CompetencesIntermediaires.numero' => 'ASC'
            ])
            ->first()
            ->id;
        }

        $this->set(compact( //passage des variables à la vue
            'competencesIntermediaires', 'competences_intermediaire_id'
        ));

        //chargement de la liste des niveaux
        $niveauxTbl = TableRegistry::get('NiveauxCompetences');
        $niveaux = $niveauxTbl->find('list')
            ->order([
                'numero' => 'ASC'
            ]);
        $this->set(compact('niveaux'));
    }

}