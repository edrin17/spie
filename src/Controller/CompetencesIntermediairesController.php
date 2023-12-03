<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * CompetencesIntermediaires Controller
 */
class CompetencesIntermediairesController extends AppController
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
        //$tableau = ['ref'=> $referential_id, 'capa' => $capacite_id, 'Term' => $competences_terminale_id ];
        //debug($tableau);
        $competencesIntermediaires = $this->CompetencesIntermediaires->find()
									->contain(['CompetencesTerminales.Capacites.Referentials'])
                                    ->where(['competences_terminale_id' => $competences_terminale_id])
									->order(['Capacites.numero' => 'ASC',
										'CompetencesTerminales.numero' => 'ASC',
										'CompetencesIntermediaires.numero' => 'ASC']);

        $this->set(compact('competencesIntermediaires'));
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $competencesIntermediaire = $this->CompetencesIntermediaires->get($id, [
            'contain' => ['CompetencesIntermediaires','Capacites']
        ]);

        $this->set(compact('competencesIntermediaire'));                                  // Passe le paramètre 'competence' à la vue.
        $this->set('_serialize', ['competencesIntermediaire']);
        //debug($listeCompetencesTerminales); die();
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        //On récupère la liste des Capacité avec NumeNom sous la forme (C.1 gfdsgdf)
        $listeCapacites = $this->CompetencesIntermediaires->CompetencesTerminales->Capacites
								->find('list')
								->order(['numero' => 'ASC']);
									
        //debug($listeCompetences);die;
        $competenceInter = $this->CompetencesIntermediaires->newEntity();                                   // crée une nouvelle entité dans $competence
        if ($this->request->is('post')) {                                           //si requête de type post
            $competenceInter = $this->CompetencesIntermediaires->patchEntity($competenceInter, $this->request->getData());  //??
            if ($this->CompetencesIntermediaires->save($competenceInter)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('La compétence a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La compétence n\'a pas pu être sauvegardé ! Réessayer.')); //Affiche une infobulle
            }
        }
        $this->set(compact('listeCapacites'));     
        $this->set(compact('competenceInter')); 
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)   //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        
        //récupère le contenu de la table competences_terminales en fonction de l'id'
        $competencesIntermediaire = $this->CompetencesIntermediaires->get($id, [
            'contain' => []
        ]);
        
        //On récupère la liste des Capacité avec NumeNom sous la forme (C.1 gfdsgdf)
        $listeCapacites = $this->CompetencesIntermediaires->CompetencesTerminales->Capacites
								->find('list')
								->order(['numero' => 'ASC']);
								
		//On récupère la liste des compétences Terminales
        $listeCompTerms = $this->CompetencesIntermediaires->CompetencesTerminales
								->find('all')
								->contain(['Capacites'])
								->order(['Capacites.numero' => 'ASC', 'CompetencesTerminales.numero' => 'ASC']);
		
		//debug($listeCompTerm->id);die;
		
		foreach ($listeCompTerms as $listeCompTerm) 
		{
			//debug($listeCompTerm->capacite->numero);die;
			$selectCompTerms[$listeCompTerm->id] = 'C' .'.' .$listeCompTerm->capacite->numero.'.'.
													$listeCompTerm->numero. ' - '.$listeCompTerm->nom;
		}

        //récupère le contenu de la table capacites en fonction de l'id = a capacite_id
        //$capacite = $this->CompetencesIntermediaires->Capacites->get($capacite->id, ['contain' => [] ]);
        if ($this->request->is(['patch', 'post', 'put'])) {                        // Vérifie le type de requête
            $competencesIntermediaire = $this->CompetencesIntermediaires->patchEntity($competencesIntermediaire, $this->request->getData());
            if ($this->CompetencesIntermediaires->save($competencesIntermediaire)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('La compétence a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La compétence n\' pas pu être sauvegarder ! Réessayer.')); //Sinon affiche une erreur
            }
        }
        
        // Récupère les données de la table capacites et les classe par ASC
        $this->set(compact('listeCapacites','selectCompTerms'));
        $this->set(compact('competencesIntermediaire'));
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $competence = $this->CompetencesIntermediaires->get($id);
        if ($this->CompetencesIntermediaires->delete($competence)) {
            $this->Flash->success(__('La compétence a été supprimé.'));
        } else {
            $this->Flash->error(__('La compétence n\' pas pu être supprimer ! Réessayer.'));
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

        //chargement de la liste des compétences inter selon la compétence Terminale
        $compTermTbl = TableRegistry::get('CompetencesTerminales');
        $competencesTerminales = $compTermTbl->find('list')
            ->contain(['Capacites'])
            ->where(['capacite_id' => $capacite_id])
            ->order([
                'Capacites.numero' => 'ASC',
                'CompetencesTerminales.numero' => ''
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
                'CompetencesTerminales.numero' => ''
            ])
            ->first()
            ->id;
        }

        $this->set(compact( //passage des variables à la vue
            'competencesTerminales', 'competences_terminale_id'
        ));
    }

}
