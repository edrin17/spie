<?php
namespace App\Controller;

use App\Controller\AppController;

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
        //changement de nom de la variable
        $competencesTerminale_id = $competences_terminale_id;
		
		// chargement des capacites dans listeCapacites pour le select du filtre
        //On récupère la liste des Capacités avec NumeNom
        $listeCapacites = $this->CompetencesIntermediaires->CompetencesTerminales->Capacites
								->find('list')
								->order(['numero' => 'ASC']);
        
        
        if ( $this->request->is('POST') ) 
		{
			$capacite_id = $this->request->getData()['capacite_id'];
			$competencesTerminale_id = $this->request->getData()['competences_terminale_id'];
		}
        
        if ($competencesTerminale_id !== null) 
		{
						
			$CompetencesTerminales = $this->CompetencesIntermediaires->CompetencesTerminales->find()
									->contain(['Capacites'])
									->where(['capacite_id' => $capacite_id ])
									->order(['CompetencesTerminales.numero' => 'ASC']);
		
			$listeCompetencesTerminales['tout'] = "Tout voir";
			
			foreach ($CompetencesTerminales as $CompetencesTerminale) 
			{
				$listeCompetencesTerminales[$CompetencesTerminale->id] = "C." .$CompetencesTerminale->capacite->numero
														."." .$CompetencesTerminale->numero
														." - " .$CompetencesTerminale->nom;
			}
			
			if ($competencesTerminale_id == 'tout') 
			{
				$competencesIntermediaires = $this->CompetencesIntermediaires->find()
										->contain(['CompetencesTerminales.Capacites'])
										->where(['CompetencesTerminales.capacite_id' => $capacite_id])
										->order(['Capacites.numero' => 'ASC',
											'CompetencesTerminales.numero' => 'ASC',
											'CompetencesIntermediaires.numero' => 'ASC']);
			}else 
			{
				$competencesIntermediaires = $this->CompetencesIntermediaires->find()
										->contain(['CompetencesTerminales.Capacites'])
										->where(['competences_terminale_id' => $competencesTerminale_id ])
										->order(['Capacites.numero' => 'ASC',
											'CompetencesTerminales.numero' => 'ASC',
											'CompetencesIntermediaires.numero' => 'ASC']);
			}						
        
		}else 
		{						
        $CompetencesTerminales = $this->CompetencesIntermediaires->CompetencesTerminales->find()
								->contain(['Capacites'])
								->where(['capacite_id' => $this->CompetencesIntermediaires
																->CompetencesTerminales
																->Capacites->find()
																->order(['numero' => 'ASC'])
																->first()->id ])
								->order(['CompetencesTerminales.numero' => 'ASC']);
		
		$listeCompetencesTerminales['tout'] = "Tout voir";
		foreach ($CompetencesTerminales as $CompetencesTerminale) 
		{
			$listeCompetencesTerminales[$CompetencesTerminale->id] = "C." .$CompetencesTerminale->capacite->numero
													."." .$CompetencesTerminale->numero
													." - " .$CompetencesTerminale->nom;
		}
								
        $competencesIntermediaires = $this->CompetencesIntermediaires->find()
									->contain(['CompetencesTerminales.Capacites'])
									->order(['Capacites.numero' => 'ASC',
										'CompetencesTerminales.numero' => 'ASC',
										'CompetencesIntermediaires.numero' => 'ASC']);
		}

        $this->set(compact(
			'competencesIntermediaires','listeCompetencesTerminales',
			'listeCapacites','capacite_id','competencesTerminale_id'
		));
        $this->set('_serialize', ['competencesIntermediaires']);
		//debug($competencesTerminale); die();
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

}
