<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * SousSousChapitres Controller
 */
class SousSousChapitresController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
    /**
     *Liste les SousSousChapitres:
     *récupère les capacités & les classe ASC
     *puis les passes en paramètre à l'instance
     * Pagine les sousSousChapitres terminales
     */
    public function index( $sous_chapitre_id = null )
    {
        //changement de nom de la variable
        $sousChapitre_id = $sous_chapitre_id;
		
		// chargement des chapitres dans listeChapitres pour le select du filtre
        //On récupère la liste des Chapitres avec NumeNom
        $listeChapitres = $this->SousSousChapitres->SousChapitres->Chapitres
								->find('list')
								->order(['numero' => 'ASC']);
        
        
        if ( $this->request->is('POST') ) 
		{
			$chapitre_id = $this->request->getData()['chapitre_id'];
			$sousChapitre_id = $this->request->getData()['sous_chapitre_id'];
		}
        
        if ($sousChapitre_id !== null) 
		{
						
			$SousChapitres = $this->SousSousChapitres->SousChapitres->find()
									->contain(['Chapitres'])
									->where(['chapitre_id' => $chapitre_id ])
									->order(['SousChapitres.numero' => 'ASC']);
		
			$listeSousChapitres['tout'] = "Tout voir";
			
			foreach ($SousChapitres as $SousChapitre) 
			{
				$listeSousChapitres[$SousChapitre->id] = "S." .$SousChapitre->chapitre->numero
														."." .$SousChapitre->numero
														." - " .$SousChapitre->nom;
			}
			
			if ($sousChapitre_id == 'tout') 
			{
				$sousSousChapitres = $this->SousSousChapitres->find()
										->contain(['SousChapitres.Chapitres'])
										->where(['SousChapitres.chapitre_id' => $chapitre_id])
										->order(['Chapitres.numero' => 'ASC',
											'SousChapitres.numero' => 'ASC',
											'SousSousChapitres.numero' => 'ASC']);
			}else 
			{
				$sousSousChapitres = $this->SousSousChapitres->find()
										->contain(['SousChapitres.Chapitres'])
										->where(['sous_chapitre_id' => $sousChapitre_id ])
										->order(['Chapitres.numero' => 'ASC',
											'SousChapitres.numero' => 'ASC',
											'SousSousChapitres.numero' => 'ASC']);
			}						
        
		}else 
		{						
        $SousChapitres = $this->SousSousChapitres->SousChapitres->find()
								->contain(['Chapitres'])
								->where(['chapitre_id' => $this->SousSousChapitres
																->SousChapitres
																->Chapitres->find()
																->first()->id ])
								->order(['SousChapitres.numero' => 'ASC']);
		
		$listeSousChapitres['tout'] = "Tout voir";
		foreach ($SousChapitres as $SousChapitre) 
		{
			$listeSousChapitres[$SousChapitre->id] = "S." .$SousChapitre->chapitre->numero
													."." .$SousChapitre->numero
													." - " .$SousChapitre->nom;
		}
								
        $sousSousChapitres = $this->SousSousChapitres->find()
									->contain(['SousChapitres.Chapitres'])
									->order(['Chapitres.numero' => 'ASC',
										'SousChapitres.numero' => 'ASC',
										'SousSousChapitres.numero' => 'ASC']);
		}
        

        $this->set(compact('sousSousChapitres','listeChapitres','listeSousChapitres','chapitre_id','sousChapitre_id'));
        $this->set('_serialize', ['sousSousChapitres']);
		//debug($sousChapitre); die();
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        //On récupère la liste des Chapitres avec NumeNom sous la forme (S.1 gfdsgdf)
        $listeChapitres = $this->SousSousChapitres->SousChapitres->Chapitres
								->find('list')
								->order(['numero' => 'ASC']);
        
        $sousSousChapitre = $this->SousSousChapitres->newEntity();                                   // crée une nouvelle entité dans $sousSousChapitre
        if ($this->request->is('post')) {                                           //si requête de type post
            $sousSousChapitre = $this->SousSousChapitres->patchEntity($sousSousChapitre, $this->request->getData());  //??
            if ($this->SousSousChapitres->save($sousSousChapitre)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('Le contenu de chapitre a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le contenu de chapitre n\'a pas pu être sauvegardé ! Réessayer.')); //Affiche une infobulle
            }
        }
        $this->set(compact('sousSousChapitre','listeChapitres')); 
    }
	
	/**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $sousSousChapitre = $this->SousSousChapitres->get($id, [
            'contain' => ['SousChapitres.Chapitres']
        ]);
        //debug($sousSousChapitre->toArray());die;					        
        $this->set(compact('sousSousChapitre'));                                  // Passe le paramètre 'competence' à la vue.
        $this->set('_serialize', ['sousSousChapitre']);
        //debug($listeSousChapitres); die();
    }
    
    /**
     * Édite un utilisateur
     */
    public function edit($id = null)   //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        
        //récupère le contenu de la table sous_chapitres en fonction de l'id'
        $sousSousChapitre = $this->SousSousChapitres->get($id, [
            'contain' => []
        ]);
        
        //On récupère la liste des Chapitres avec NumeNom sous la forme (S.1 gfdsgdf)
        $listeChapitres = $this->SousSousChapitres->SousChapitres->Chapitres
								->find('list')
								->order(['numero' => 'ASC']);
								
		//On récupère la liste des compétences Terminales
        $listeSousChapitres = $this->SousSousChapitres->SousChapitres
								->find('all')
								->contain(['Chapitres'])
								->order(['Chapitres.numero' => 'ASC', 'SousChapitres.numero' => 'ASC']);
		
		//debug($listeSousChapitres->toArray());die;
		
		foreach ($listeSousChapitres as $listeSousChapitre) 
		{
			//debug($listeSousChapitre->capacite->numero);die;
			$selectSousChapitres[$listeSousChapitre->id] = 'S' .'.' .$listeSousChapitre->chapitre->numero.'.'.
													$listeSousChapitre->numero. ' - '.$listeSousChapitre->nom;
		}

        //récupère le contenu de la table chapitres en fonction de l'id = a chapitre_id
        //$chapitre = $this->SousSousChapitres->chapitres->get($chapitre->id, ['contain' => [] ]);
        if ($this->request->is(['patch', 'post', 'put'])) {                        // Vérifie le type de requête
            $sousSousChapitre = $this->SousSousChapitres->patchEntity($sousSousChapitre, $this->request->getData());
            if ($this->SousSousChapitres->save($sousSousChapitre)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('La compétence a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La compétence n\' pas pu être sauvegarder ! Réessayer.')); //Sinon affiche une erreur
            }
        }
        
        // Récupère les données de la table chapitres et les classe par ASC
        $this->set(compact('selectSousChapitres','listeChapitres'));
        $this->set(compact('sousSousChapitre'));
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $sousSousChapitre = $this->SousSousChapitres->get($id);
        if ($this->SousSousChapitres->delete($sousSousChapitre)) {
            $this->Flash->success(__('La compétence a été supprimé.'));
        } else {
            $this->Flash->error(__('La compétence n\' pas pu être supprimer ! Réessayer.'));
        }
        return $this->redirect(['action' => 'index']);
    }
	
	
	public function listeSousChapitres($optionToutVoir = null) 
	{
		$this->viewBuilder()->setLayout('ajax');
		
		$chapitre_id = $_GET['chapitre_id'];
		$optionToutVoir = $_GET['optionToutVoir'];
		
		$listeSousChaps = $this->SousSousChapitres->SousChapitres
								->find('all')
								->contain(['Chapitres'])
								->where(['chapitre_id' => $chapitre_id])
								->order(['SousChapitres.numero' => 'ASC']);
		
		/* création d'un tableau sous la forme 
		 * $listeSousChapJson[ChapitreSelectioné_id][SousChapitre_id][valeur]
		 * */
		if ($optionToutVoir) 
		{
			$listeSousChapJson['tout'] = "Tout voir";
		}
		
		foreach ($listeSousChaps as $listeSousChap) 
		{
			$listeSousChapJson[$listeSousChap->id] = "S.". $listeSousChap->chapitre->numero
																	."." .$listeSousChap->numero ." - "
																	.$listeSousChap->nom;
		}
											
		$this->set('listeSousChapJson',$listeSousChapJson);
		
	}
}
