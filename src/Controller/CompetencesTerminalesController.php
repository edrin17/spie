<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
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
    public function index($filtrCapa = null)
    {
		$this->_loadFilters();
		
		$compsTerms = $this->CompetencesTerminales;
        $referential_id = $this->viewVars['referential_id'];
        $capacite_id = $this->viewVars['capacite_id'];
		$listeCompsTerms = $compsTerms->find()
			->contain(['Capacites'])
            ->where([
                'referential_id' => $referential_id,
                'capacite_id' => $capacite_id,
                ])
			->order([
				'Capacites.numero' => 'ASC',
				'CompetencesTerminales.numero' => 'ASC'
			]);
	    $this->set(compact('listeCompsTerms'));      
		
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)
    {  
        $compTerm = $this->CompetencesTerminales->get($id, ['contain' => ['Capacites']] );					
        $this->set(compact('compTerm'));// Passe le paramètre 'competence' à la vue.
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        $this->_loadFilters(); // load filter list with "Référentiels"						
        $compsTerms = $this->CompetencesTerminales;
        $competenceTerminale = $this->CompetencesTerminales->newEntity();
        
        if ($this->request->is('post')) {  //si on a cliqué sur "Ajouter".
            $competenceTerminale = $compsTerms->patchEntity($competenceTerminale, $this->request->getData());
            $referential_id = $this->request->getData('referential_id');
            $capacite_id = $this->request->getData('capacite_id');
            if ($compsTerms->save($competenceTerminale)) { // si pas d'erreur remontée.
                $this->Flash->success(__(
					"La compétence terminale a été sauvegardéé."
                ));
                return $this->redirect([
                    'action' => 'index',
                    'referential_id' => $referential_id,
                    'capacite_id' => $capacite_id,
                ]);
            } else {
                $this->Flash->error(__(
					"La compétence terminale n'a pas pu être sauvegardée ! Réessayer."
				));
            }
        }
        
        
        $this->set(compact('competenceTerminale')); 
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)   //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        
        $this->_loadFilters(); // load filter list with "Référentiels"
        $compsTerms = $this->CompetencesTerminales;
        $competenceTerminale = $compsTerms->get($id);

        //récupère le contenu de la table capacites en fonction de l'id = a capaciteId
        //$capacites = $compsTerms->Capacites->get($capacites->id, ['contain' => [] ]);
        if ($this->request->is(['patch', 'post', 'put'])) {                        // Vérifie le type de requête
            $competenceTerminale = $compsTerms->patchEntity($competenceTerminale, $this->request->getData());
            $referential_id = $this->request->getData('referential_id');
            $capacite_id = $this->request->getData('capacite_id');
            if ($compsTerms->save($$competenceTerminale)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('La compétence a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect([
                    'action' => 'index',
                    'referential_id' => $referential_id,
                    'capacite_id' => $capacite_id,
                ]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La compétence n\' pas pu être sauvegarder ! Réessayer.')); //Sinon affiche une erreur
            }
        }
        

        $this->set(compact('competenceTerminale'));
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->_loadFilters(); // load filter list with "Référentiels"
        $compsTerms = $this->CompetencesTerminales;
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $referential_id = $this->viewVars['referential_id'];
        $capacite_id = $this->viewVars['capacite_id'];
        $compTerm = $compsTerms->get($id);
        //debug($capacite_id);
        //die;
        if ($compsTerms->delete($compTerm)) {
            $this->Flash->success(__('La compétence a été supprimé.'));
        } else {
            $this->Flash->error(__('La compétence n\' pas pu être supprimée ! Réessayer.'));
        }
        return $this->redirect([
            'action' => 'index',
            'referential_id' => $referential_id,
            'capacite_id' => $capacite_id
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
        $capacitesTbl = TableRegistry::get('Capacites');
        $capacites = $capacitesTbl->find('list')
            ->where(['referential_id' => $referential_id])
            ->order(['numero' => 'ASC']);
        
        //get id from request
        $capacite_id = $this->request->getQuery('capacite_id');

        //if request empty get first in the list
        if ($capacite_id =='') {
            $capacite_id = $capacitesTbl->find()
            ->order(['numero' => 'ASC'])
            ->first()
            ->id;
        }

        $this->set(compact( //passage des variables à la vue
            'capacites', 'capacite_id'
        ));
    }
}
