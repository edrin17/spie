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
		$query = $compsTerms->find()
			->contain(['Capacites'])
			->order([
				'Capacites.numero' => 'ASC',
				'CompetencesTerminales.numero' => 'ASC'
			]);
		
	
		$filtrPost = $this->request->is('POST');
		
		if ($filtrPost) { //Si un filtr à été appliqué request de type POST
			$filtrCapa = $this->request->getData()['filtrCapa'];
		}
		
		if ($filtrCapa !== null) { //Si affichage avec filtr on applique une requete avec le filtr
			$listeCompsTerms = $query->where(['capacite_id' => $filtrCapa]);					
		} else { //Si pas de filtr on applique une récupère toutes les données
			$listeCompsTerms = $query;
		}     
	    $this->set(compact('listeCompsTerms','listCapa','filtrCapa'));      
		
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
        $capacites = TableRegistry::get('Capacites');
		$listCapa = $capacites->find('list')
			->order(['numero' => 'ASC']);
								
        $compsTerms = $this->CompetencesTerminales;
        $compTerm = $compsTerms->newEntity();
        
        if ($this->request->is('post')) {  //si on a cliqué sur "Ajouter".
            $compTerm = $compsTerms->patchEntity($compTerm, $this->request->getData());
            if ($compsTerms->save($compTerm)) { // si pas d'erreur remontée.
                $this->Flash->success(__(
					"La compétence terminale a été sauvegardéé."
                ));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__(
					"La compétence terminale n'a pas pu être sauvegardée ! Réessayer."
				));
            }
        }
        
        
        $this->set(compact('compTerm','listCapa','filtrCapa')); 
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)   //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        
        $this->_loadFilters(); // load filter list with "Référentiels"
        //récupère le contenu de la table competences_terminales en fonction de l'id'
        $compsTerm = $compsTerms->get($id, [
            'contain' => []
        ]);

        //récupère le contenu de la table capacites en fonction de l'id = a capaciteId
        //$capacites = $compsTerms->Capacites->get($capacites->id, ['contain' => [] ]);
        if ($this->request->is(['patch', 'post', 'put'])) {                        // Vérifie le type de requête
            $$compsTerm = $compsTerms->patchEntity($$compsTerm, $this->request->getData());
            if ($compsTerms->save($$compsTerm)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('La compétence a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La compétence n\' pas pu être sauvegarder ! Réessayer.')); //Sinon affiche une erreur
            }
        }
        
        // Récupère les données de la table capacites et les classe par ASC
        $listeSelect = $compsTerms->Capacites->find('list')->order(['numero' => 'ASC']);
        $this->set(compact('$compsTerm', 'listeSelect'));
        $this->set('_serialize', ['$compsTerm']);
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->_loadFilters(); // load filter list with "Référentiels"
        $compsTerms = $this->CompetencesTerminales;
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $compTerm = $compsTerms->get($id);
        if ($compsTerms->delete($compTerm)) {
            $this->Flash->success(__('La compétence a été supprimé.'));
        } else {
            $this->Flash->error(__('La compétence n\' pas pu être supprimée ! Réessayer.'));
        }
        return $this->redirect(['action' => 'index']);
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
        $capaTbl = TableRegistry::get('Capacites');
        $capacites = $capaTbl->find('list')
            ->where(['referential_id' => $referential_id])
            ->order(['numero' => 'ASC']);
        
        //get id from request
        $capa_id = $this->request->getQuery('capa_id');

        //if request empty get first in the list
        if ($capa_id =='') {
            $capa_id = $capaTbl->find()
            ->order(['numero' => 'ASC'])
            ->first()
            ->id;
        }

        $this->set(compact( //passage des variables à la vue
            'capacites', 'capa_id'
        ));
    }
}
