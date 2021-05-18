<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * ContenusChapitres Controller
 */
class ContenusChapitresController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
    /**
     *Liste les ContenusChapitres:
     *récupère les capacités & les classe ASC
     *puis les passes en paramètre à l'instance
     * Pagine les contenusChapitres terminales
     */
    public function index($sous_sous_chapitre_id = null, $sous_chapitre_id = null )
    {
        //changement de nom de la variable
        $sousSousChapitre_id = $sous_sous_chapitre_id;
		
		// chargement des chapitres dans listeChapitres pour le select du filtre
        //On récupère la liste des Chapitres avec NumeNom
        $listeChapitres = $this->ContenusChapitres->SousSousChapitres->SousChapitres->Chapitres
								->find('list')
								->order(['numero' => 'ASC']);
        
        
        if ( $this->request->is('POST') ) 
		{
			$chapitre_id = $this->request->getData()['chapitre_id'];
			$sousChapitre_id = $this->request->getData()['sous_chapitre_id'];
			$sousSousChapitre_id = $this->request->getData()['sous_sous_chapitre_id'];
			//debug($chapitre_id);debug($sousChapitre_id);debug($sousSousChapitre_id);die;
		}
        
        if ( $sousSousChapitre_id !== null) //si premier affichage 
		{
			/* on charge les "SousChapitre" correspondant au filtre "chapitre_id" */
			$SousChapitres = $this->ContenusChapitres->SousSousChapitres->SousChapitres->find()
									->contain(['Chapitres'])
									->where(['chapitre_id' => $chapitre_id ])
									->order(['SousChapitres.numero' => 'ASC']);
		
			/* on ajoute l'option "tout voir" au tableau et on crée le tableau */
			$listeSousChapitres['tout'] = "Tout voir";
			foreach ($SousChapitres as $SousChapitre) 
			{
				$listeSousChapitres[$SousChapitre->id] = "S." .$SousChapitre->chapitre->numero
														."." .$SousChapitre->numero
														." - " .$SousChapitre->nom;
			}
			/* on charge le contenu correspondant au filtre "chapitre_id" */
			if ($sousChapitre_id == 'tout') 
			{
				$premierSousChapitre = $SousChapitres = $this->ContenusChapitres->SousSousChapitres->SousChapitres->find()
									->contain(['Chapitres'])
									->where(['chapitre_id' => $chapitre_id ])
									->order(['SousChapitres.numero' => 'ASC'])
									->first();
									
				/* on charge les "SousSousChapitre" correspondant au filtre SousChapitre "tout" */
				$SousSousChapitres = $this->ContenusChapitres->SousSousChapitres->find()
									->contain(['SousChapitres.Chapitres'])
									->where(['sous_chapitre_id' => $premierSousChapitre])
									->order(['SousSousChapitres.numero' => 'ASC']);
		
				/* on ajoute l'option "tout voir" au tableau et on crée le tableau */
				$listeSousSousChapitres['tout'] = "Tout voir";
				foreach ($SousSousChapitres as $SousSousChapitre) 
				{
					$listeSousSousChapitres[$SousSousChapitre->id] = 
						"S." .$SousSousChapitre->sous_chapitre->chapitre->numero
						."." .$SousSousChapitre->sous_chapitre->numero
						."." .$SousSousChapitre->numero
						." - " .$SousSousChapitre->nom;
				}
								
				/* on charge le contenu correspondant au filtre "chapitre" 
				* car SousChapitre = 'tout' */
				$contenusChapitres = $this->ContenusChapitres->find()							
								->contain(['SousSousChapitres.SousChapitres.Chapitres','NiveauxTaxos'])
								->where(['SousChapitres.chapitre_id' => $chapitre_id ])
								->order(['Chapitres.numero' => 'ASC',
									'SousChapitres.numero' => 'ASC',
									'SousSousChapitres.numero' => 'ASC',
									'NiveauxTaxos.numero' => 'ASC',
									'ContenusChapitres.nom' => 'ASC']);
			}
			else
			{		
				
				/* on charge les "SousSousChapitre" correspondant au filtre SousChapitre "tout" */
				$SousSousChapitres = $this->ContenusChapitres->SousSousChapitres->find()
									->contain(['SousChapitres.Chapitres'])
									->where(['sous_chapitre_id' => $sousChapitre_id])
									->order(['SousSousChapitres.numero' => 'ASC']);
		
				/* on ajoute l'option "tout voir" au tableau et on crée le tableau */
				$listeSousSousChapitres['tout'] = "Tout voir";
				foreach ($SousSousChapitres as $SousSousChapitre) 
				{
					$listeSousSousChapitres[$SousSousChapitre->id] = 
						"S." .$SousSousChapitre->sous_chapitre->chapitre->numero
						."." .$SousSousChapitre->sous_chapitre->numero
						."." .$SousSousChapitre->numero
						." - " .$SousSousChapitre->nom;
				}
				
				if ($sousSousChapitre_id == 'tout') 
				{
					/* on charge le contenu correspondant au filtre "sous chapitre" 
					* car SousSousChapitre = 'tout' */
					$contenusChapitres = $this->ContenusChapitres->find()							
								->contain(['SousSousChapitres.SousChapitres.Chapitres','NiveauxTaxos'])
								->where(['SousSousChapitres.sous_chapitre_id' => $sousChapitre_id])
								->order(['Chapitres.numero' => 'ASC',
									'SousChapitres.numero' => 'ASC',
									'SousSousChapitres.numero' => 'ASC',
									'NiveauxTaxos.numero' => 'ASC',
									'ContenusChapitres.nom' => 'ASC']);
				}else
				{
					/* on charge le contenu correspondant au filtre "sous sous chapitre"
					 * */
					$contenusChapitres = $this->ContenusChapitres->find()							
								->contain(['SousSousChapitres.SousChapitres.Chapitres','NiveauxTaxos'])
								->where(['sous_sous_chapitre_id' => $sousSousChapitre_id ])
								->order(['Chapitres.numero' => 'ASC',
									'SousChapitres.numero' => 'ASC',
									'SousSousChapitres.numero' => 'ASC',
									'NiveauxTaxos.numero' => 'ASC',
									'ContenusChapitres.nom' => 'ASC']);
				}
				
			}						       
		}else 
		{						
			/* chargement du listeSelect "sous chapitre" par defaut */
			$premierChapitre = $this->ContenusChapitres->SousSousChapitres
				->SousChapitres->Chapitres->find()
				->first()->id;
					 
			$SousChapitres = $this->ContenusChapitres->SousSousChapitres->SousChapitres->find()
								->contain(['Chapitres'])
								->where(['chapitre_id' => $premierChapitre])
								->order(['SousChapitres.numero' => 'ASC']);
		
			$listeSousChapitres['tout'] = "Tout voir";
			foreach ($SousChapitres as $SousChapitre) 
			{
				$listeSousChapitres[$SousChapitre->id] = "S." .$SousChapitre->chapitre->numero
					."." .$SousChapitre->numero
					." - " .$SousChapitre->nom;
			}
								
			/* chargement du listeSelect "sous sous chapitre" par defaut */
			$premierSousChapitre = $SousChapitres->first()->id;
			
			$sousSousChapitres = $this->ContenusChapitres->SousSousChapitres->find()
									->contain(['SousChapitres.Chapitres'])
									->where(['sous_chapitre_id' => $premierSousChapitre])
									->order(['Chapitres.numero' => 'ASC',
										'SousChapitres.numero' => 'ASC',
										'SousSousChapitres.numero' => 'ASC']);
			
			$listeSousSousChapitres['tout'] = "Tout voir";
			foreach ($sousSousChapitres as $sousSousChapitre) 
			{
				$listeSousSousChapitres[$sousSousChapitre->id] = 
					"S." .$sousSousChapitre->sous_chapitre->chapitre->numero
					."." .$sousSousChapitre->sous_chapitre->numero
					."." .$sousSousChapitre->numero
					." - " .$sousSousChapitre->nom;
			}
							
			/* chargement du contenu par defaut */
			$contenusChapitres = $this->ContenusChapitres->find()							
								->contain(['SousSousChapitres.SousChapitres.Chapitres','NiveauxTaxos'])
								->order(['Chapitres.numero' => 'ASC',
									'SousChapitres.numero' => 'ASC',
									'SousSousChapitres.numero' => 'ASC',
									'NiveauxTaxos.numero' => 'ASC',
									'ContenusChapitres.nom' => 'ASC']);
		}
        
        $this->set(compact('contenusChapitres','listeChapitres','listeSousChapitres','listeSousSousChapitres'));
        $this->set('_serialize', ['contenusChapitres']);
		
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        // chargement des chapitres dans listeChapitres pour le select du filtre
        //On récupère la liste des Chapitres avec NumeNom
        $listeChapitres = $this->ContenusChapitres->SousSousChapitres->SousChapitres->Chapitres
								->find('list')
								->order(['numero' => 'ASC']);
        
        /* chargement du listeSelect "sous chapitre" par defaut */
			$premierChapitre = $this->ContenusChapitres->SousSousChapitres
				->SousChapitres->Chapitres->find()
				->first()->id;
					 
			$SousChapitres = $this->ContenusChapitres->SousSousChapitres->SousChapitres->find()
								->contain(['Chapitres'])
								->where(['chapitre_id' => $premierChapitre])
								->order(['SousChapitres.numero' => 'ASC']);
		
			foreach ($SousChapitres as $SousChapitre) 
			{
				$listeSousChapitres[$SousChapitre->id] = "S." .$SousChapitre->chapitre->numero
					."." .$SousChapitre->numero
					." - " .$SousChapitre->nom;
			}
								
			/* chargement du listeSelect "sous sous chapitre" par defaut */
			$premierSousChapitre = $SousChapitres->first()->id;
			
			$sousSousChapitres = $this->ContenusChapitres->SousSousChapitres->find()
									->contain(['SousChapitres.Chapitres'])
									->where(['sous_chapitre_id' => $premierSousChapitre])
									->order(['Chapitres.numero' => 'ASC',
										'SousChapitres.numero' => 'ASC',
										'SousSousChapitres.numero' => 'ASC']);
			
			foreach ($sousSousChapitres as $sousSousChapitre) 
			{
				$listeSousSousChapitres[$sousSousChapitre->id] = 
					"S." .$sousSousChapitre->sous_chapitre->chapitre->numero
					."." .$sousSousChapitre->sous_chapitre->numero
					."." .$sousSousChapitre->numero
					." - " .$sousSousChapitre->nom;
			}
							
			/* chargement du contenu par defaut */
			$contenusChapitres = $this->ContenusChapitres->find()							
								->contain(['SousSousChapitres.SousChapitres.Chapitres','NiveauxTaxos'])
								->order(['Chapitres.numero' => 'ASC',
									'SousChapitres.numero' => 'ASC',
									'SousSousChapitres.numero' => 'ASC',
									'NiveauxTaxos.numero' => 'ASC',
									'ContenusChapitres.nom' => 'ASC']);
		
		$niveauxTaxos = $this->ContenusChapitres->NiveauxTaxos->find()->order(['numero' => 'ASC']); 
        foreach ($niveauxTaxos as $niveauxTaxo) 
		{
			$listeNiveaux[$niveauxTaxo->id] = "N." .$niveauxTaxo->numero .": " .$niveauxTaxo->nom ;
		}
        

        $contenusChapitre = $this->ContenusChapitres->newEntity();                                   // crée une nouvelle entité dans $contenusChapitre
        if ($this->request->is('post')) {                                           //si requête de type post
            $contenusChapitre = $this->ContenusChapitres->patchEntity($contenusChapitre, $this->request->getData());  //??
            if ($this->ContenusChapitres->save($contenusChapitre)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('Le contenu de chapitre a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le contenu de chapitre n\'a pas pu être sauvegardé ! Réessayer.')); //Affiche une infobulle
            }
        }
             
        $this->set(compact('contenusChapitre','listeNiveaux','listeChapitres','listeSousChapitres','listeSousSousChapitres')); 
    }
	
	
    /**
     * Édite un utilisateur
     */
    public function edit($id = null)   //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        /*On récupère la liste des Chapitres avec NumeNom sous la forme (S.1 gfdsgdf)
         * on stocke la requête dans $listeChapitres pour le transmettre à la vue
         * pour que le select de la vue puisse correctement afficher la liste des chapitres
         */
	
        $listeChapitres = $this->ContenusChapitres->SousSousChapitres->SousChapitres->Chapitres
								->find('list')
								->order(['numero' => 'ASC']);
        
        //récupère le contenu de l'entity $id et récupère toute ses infos en remontant dans les tables liées.
        $contenusChapitre = $this->ContenusChapitres->get($id, [
            'contain' => ['SousSousChapitres.SousChapitres','NiveauxTaxos']
        ]);
        
        //récupère la liste des sous chapitres correspondants au chapitre correspondant à l'entity $id
        $listeSousChapitres = $this->ContenusChapitres->SousSousChapitres->SousChapitres
								->find('all')
								->contain(['Chapitres'])
								->where(['chapitre_id' => 	$contenusChapitre->sous_sous_chapitre
																			->sous_chapitre->chapitre_id])								
								->order(['SousChapitres.numero' => 'ASC']);
		//execution de la requête et formatage 
        foreach ($listeSousChapitres as $listeSousChapitre) 
		{
			$selectSousChapitres[$listeSousChapitre->id] = 	"S.". $listeSousChapitre->chapitre->numero
															."." .$listeSousChapitre->numero ." - "
															.$listeSousChapitre->nom;
		}
        //récupère la liste des sous-sous chapitres correspondants au sous chapitre correspondant à l'entity $id
        $listeSousSousChapitres = $this->ContenusChapitres->SousSousChapitres
								->find('all')
								->contain(['SousChapitres.Chapitres'])
								->where(['sous_chapitre_id' => $contenusChapitre->sous_sous_chapitre
																			->sous_chapitre_id])								
								->order(['SousSousChapitres.numero' => 'ASC']);
        //execution de la requête et formatage 
        foreach ($listeSousSousChapitres as $listeSousSousChapitre) 
		{
			$selectSousSousChapitres[$listeSousSousChapitre->id] = 	"S.". $listeSousSousChapitre->sous_chapitre
																								->chapitre->numero
															."." .$listeSousSousChapitre->sous_chapitre->numero
															."." .$listeSousSousChapitre->numero ." - "
															.$listeSousChapitre->nom;
		}
        
        //debug($selectSousSousChapitre);die;
        /*récupère la liste des niveaux taxonomiques, on formatte pour avoir 'N.1 foo'
         * pour l'envoyer à la vue dans $listeNiveaux */
        $niveauxTaxos = $this->ContenusChapitres->NiveauxTaxos->find()->order(['numero' => 'ASC']); 
        foreach ($niveauxTaxos as $niveauxTaxo) 
		{
			$listeNiveaux[$niveauxTaxo->id] = "N." .$niveauxTaxo->numero .": " .$niveauxTaxo->nom ;
		}

        if ($this->request->is(['patch', 'post', 'put'])) {                        // Vérifie le type de requête
            $contenusChapitre = $this->ContenusChapitres->patchEntity($contenusChapitre, $this->request->getData());
            if ($this->ContenusChapitres->save($contenusChapitre)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('Le contenu de chapitre a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le contenu de chapitre n\' pas pu être sauvegardé ! Réessayer.')); //Sinon affiche une erreur
            }
        }
        
        $this->set(compact('contenusChapitre', 'listeChapitres','selectSousChapitres','selectSousSousChapitres','listeNiveaux'));
    }
	
	/**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $contenusChapitre = $this->ContenusChapitres->get($id, ['contain' => [] ]);
        
        $sousSousChapitre = $this->ContenusChapitres->SousSousChapitres->find()
							->select(['nom','numero'])
							->matching('ContenusChapitres')
							->where(['ContenusChapitres.sous_sous_chapitre_id' => $contenusChapitre->sous_sous_chapitre_id])
							->first();
		
		$niveauxTaxo = $this->ContenusChapitres->NiveauxTaxos->find()
							->select(['nom','numero'])
							->matching('ContenusChapitres')
							->where(['ContenusChapitres.niveaux_taxo_id' => $contenusChapitre->niveaux_taxo_id])
							->first();
							
        $this->set(compact('contenusChapitre', 'sousSousChapitre', 'niveauxTaxo'));                                  // Passe le paramètre 'contenusChapitre' à la vue.
        $this->set('_serialize', ['contenusChapitre']);
    }
    
    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $contenusChapitre = $this->ContenusChapitres->get($id);
        if ($this->ContenusChapitres->delete($contenusChapitre)) {
            $this->Flash->success(__('Le contenu de chapitre a été supprimé.'));
        } else {
            $this->Flash->error(__('Le contenu de chapitre n\'a pas pu être supprimé ! Réessayer.'));
        }
        return $this->redirect(['action' => 'index']);
    }
	
	public function listeSousSousChapitres($optionToutVoir = null) 
	{
		$this->viewBuilder()->setLayout('ajax');
		
		$sousChapitre_id = $_GET['sous_chapitre_id'];
		$optionToutVoir = $_GET['optionToutVoir'];
		
		if ($sousChapitre_id !== 'tout') 
		{
			$listeSousSousChaps = $this->ContenusChapitres->SousSousChapitres
								->find('all')
								->contain(['SousChapitres.Chapitres'])
								->where(['sous_chapitre_id' => $sousChapitre_id])
								->order([
									'Chapitres.numero' => 'ASC',
									'SousChapitres.numero' => 'ASC',
									'SousSousChapitres.numero' => 'ASC'
								]);
		}
		
		
		/* création d'un tableau sous la forme 
		 * $listeSousChapJson[SousChapitreSelectioné_id][SousSousChapitre_id][valeur]
		 * */
		if ($optionToutVoir) 
		{
			$listeSousSousChapJson['tout'] = "Tout voir";
		}
		
		foreach ($listeSousSousChaps as $listeSousSousChap) 
		{
			$listeSousSousChapJson[$listeSousSousChap->id] =
				"S.". $listeSousSousChap->sous_chapitre->chapitre->numero
				."." .$listeSousSousChap->sous_chapitre->numero 
				."." .$listeSousSousChap->numero
				." - " .$listeSousSousChap->nom;
		}
											
		$this->set(compact('listeSousSousChapJson'));
	}
}
