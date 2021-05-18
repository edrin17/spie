<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * MaterielsTravauxPratiques Controller
 */
class SuivisController extends AppController
{
	public function initialize()
	{
        parent::initialize();
        $this->viewBuilder()->setLayout('default');
	}

    /**
     *On récupère les classes et les prériodes pour le selection de l'évaluation
     */
    public function index()
    {
		//on récupère la liste des classes
		$tableClasses = TableRegistry::get('Classes');
		$classes = $tableClasses->find()
							->order(['nom' => 'ASC']);

		$this->set(compact('classes'));
	}

	public function view($id=null)
	{
		//on récupère la liste des élèves et la classe correpondante
		$tableEleves = TableRegistry::get('Eleves');
		$eleves = $tableEleves->find()
							->where(['classe_id' => $id])
							->order(['Eleves.nom' => 'ASC','Eleves.prenom' => 'ASC']);
		$this->set(compact('eleves'));
	}

	public function suivi()
	{
        //@returns $selectedClasse
        function getClasse() {
            if (isset($_GET['LVL1'])) {
                $selectedClasse = $_GET['LVL1'];
            }else{
                $selectedClasse = null;
            }
            return $selectedClasse;
        }

        //@returns $eleve_id
        function getEleve() {
            if (isset($_GET['LVL2'])) {
                $eleve_id = $_GET['LVL2'];
            }else{
                $eleve_id = null;
            }
            return $eleve_id;
        }

        $selectedClasse = getClasse();
        $eleve_id = getEleve();

        $tableEleves = TableRegistry::get('Eleves');
        $tableClasses = TableRegistry::get('Classes');

        $listClasses = $tableClasses->find()
						->where(['Classes.archived' => 0])
						->order(['Classes.nom' => 'ASC']);

        $listEleves = $tableEleves->find()
            ->order(['Eleves.nom' => 'ASC']);
        //debug($listClasses->toArray());die;

        //si on a sélectionné une classe
        if ($selectedClasse != null) {
            //si on a sélectionné un élève récupère l'entity eleve'
            if ($eleve_id != null) {
                $selectedEleve = $tableEleves->get($eleve_id,['contain' => [] ]);
                $listEleves = $tableEleves->find()
                    ->where(['classe_id' => $selectedClasse])
                    ->order(['Eleves.nom' => 'ASC']);

            } else {//sinon on récupere la première entity élève de classe coresspondante
                $listEleves = $tableEleves->find()
                    ->where(['classe_id' => $selectedClasse])
                    ->order(['Eleves.nom' => 'ASC']);

                $selectedEleve = $tableEleves->find()
                    ->where(['classe_id' => $selectedClasse])
                    ->order(['Eleves.nom' => 'ASC'])
                    ->first();
            }
        } else {
            $classe = $tableClasses->find()
								->where(['Classes.archived' => 0])
								->order(['Classes.nom'])
                ->first();
            $selectedClasse = $classe->id;
            $listEleves = $tableEleves->find()
                ->where(['classe_id' => $selectedClasse])
                ->order(['Eleves.nom' => 'ASC']);

            $selectedEleve = $tableEleves->find()
                ->where(['classe_id' => $classe->id])
                ->order(['Eleves.nom' => 'ASC'])
                ->first();
        }
		//debug($selectedEleve->toArray());die;

        //on récupère les évaluations de l'élève

        $tableEvaluations = TableRegistry::get('Evaluations');
		$evaluations = $tableEvaluations->find()
			->where(['eleve_id' => $selectedEleve->id])
            ->contain([
                 'TravauxPratiquesObjectifsPedas.ObjectifsPedas.CompetencesIntermediaires.CompetencesTerminales.Capacites',
                'ValeursEvals','TypesEvals'
			]);

        //on récupère la liste compétences intermédiaires
		$tableObjsPedas = TableRegistry::get('ObjectifsPedas');
		$objsPedas = $tableObjsPedas->find()
            ->contain([
                'CompetencesIntermediaires.CompetencesTerminales.Capacites',
                'NiveauxCompetences'
			])
            ->order([
                'Capacites.numero' => 'ASC',
                'CompetencesTerminales.numero' => 'ASC',
                'CompetencesIntermediaires.numero' => 'ASC',
                'NiveauxCompetences.numero' => 'ASC'
            ]);


        //on récupère la liste compétences intermédiaires
		$tableCompsInters = TableRegistry::get('CompetencesIntermediaires');
		$compsInters = $tableCompsInters->find()
            ->contain(['CompetencesTerminales.Capacites'])
            ->order(['Capacites.numero' => 'ASC', 'CompetencesTerminales.numero' => 'ASC',
                'CompetencesIntermediaires.numero' => 'ASC']);

        //on récupère la liste compétences Terminales
        $tableCompsTerms = TableRegistry::get('CompetencesTerminales');
        $compsTerms = $tableCompsTerms->find()
            ->contain(['Capacites'])
            ->order([
                    'Capacites.numero' => 'ASC',
                    'CompetencesTerminales.numero' => 'ASC'
                ]);

        //changement de variable pour correspondre à la vue standard
        $nameController = 'Suivis';
        $nameAction = 'suivi';
        $options = '';

        $listLVL1 = $listClasses;
        $listLVL2 = $listEleves;

        $selectedLVL1 = $selectedClasse;
        $selectedLVL2 = $selectedEleve;

        //création du tableau
        $table = $this->tableau($selectedEleve->id);
        $tableau = $table['tableau'];
        $tableHeader = $table['tableHeader'];
        $nbColonnes = $table['nbColonnes'];

        //passage des variables pour le layout
        $this->set('titre', "Suivi de l'élève ".$selectedEleve->nom." ".$selectedEleve->prenom);

        //passage des variables standardisées pour la vue tableauClasseur
        $this->set(compact(
            'selectedLVL2','selectedLVL1','listLVL1','listLVL2','nameController',
            'nameAction','options'
        ));

        //passage des variables à la vue pour le "content""
        $this->set(compact('tableau','tableHeader','nbColonnes'));
	}

    // crée le tableau de suivi avec l'état pour chaque micro compétences
    //@params $eleveId (CHAR36)
    //@returns $tableau (array): contient le nom de la microComp et le contenu sous forme de tableau

    private function tableau($eleveId = null)
    {
        //chargement des données
        $tableCompsInters = TableRegistry::get('CompetencesIntermediaires');
        $listCompsInters = $tableCompsInters->find()
			->contain([
				'CompetencesTerminales.Capacites',
                'ObjectifsPedas.NiveauxCompetences',
                'ObjectifsPedas.TravauxPratiques.Rotations.Periodes',
			])
			->order(['Capacites.numero' => 'ASC',
				'CompetencesTerminales.numero' => 'ASC',
				'CompetencesIntermediaires.numero' => 'ASC',
            ]);

        $tableNiveauxCompetences = TableRegistry::get('NiveauxCompetences');
        $listNiveauxCompetences = $tableNiveauxCompetences -> find()
            ->order(['numero' => 'ASC']);

        //debug($tableEvals);die;
        //verifie si 'l'élève à acquis la compétence
        //@params $eleveId (CHAR36)
        //@return array $etat[integer 'type' => (
        //  0'= 'non évalué' ou '1' = formée ou 2 = 'évaluée'),
        //  char 'color'
        function evaluateMicroComp($eleveId, $microCompId) {

            //on récupere les évaluations correpondantes aux microComp et à l'élève
            //on les classes par dates
            $tableEvals = TableRegistry::get('Evaluations');
            $listEvals = $tableEvals->find()
                ->contain([
                    'Eleves', 'ValeursEvals',
                    'TypesEvals', 'ObjectifsPedas',
                    'TravauxPratiques.Rotations.Periodes',
                ])
                ->where([
                    'eleve_id' => $eleveId,
                    'objectifs_peda_id' => $microCompId
                ])
                ->order([
                        'Periodes.numero' => 'ASC',
                        'Rotations.numero' => 'ASC',
                        'date_eval' => 'ASC'
                    ])
                ;
            //debug($listEvals->toArray());die;
            //mise des variables aux valeurs par défaut
            $valeur = 0;
            $color = 'transparent';
            //$nbEvals = $listEvals->count();
            //s'il y a des évals
            if (!$listEvals == []) {
                $nbEvalsFormatives = 0;
                foreach ($listEvals as $eval) {


                    //si PAS DEJA évaluée 4fois OU sommatif on recupère le type et la valeur de l'éval
                    if ($valeur !== 3) {
                        $typeEval = $eval->types_eval->numero;
                        $note = $eval->valeurs_eval->numero;
                        $nbEvalsFormatives ++;
                        //si sommatif
                        if ($typeEval == 2) { // si sommatif
                            $valeur = 3;//évalué en sommatif
                            //si acquis on met en vert sinon rouge
                            if ($note > 1) {
                                $color = '#00B70B';//vert
                            } else {
                                $color = '#FF5E5E';//rouge
                            }
                        } elseif ($typeEval == 1) { //si eval formative
                            if ($nbEvalsFormatives > 3) { //si + de 3 éval c'est du sommatif'

                                $valeur = 2;//on met à évalué

                                //si acquis on met en vert sinon rouge
                                if ($note > 1) {
                                    $color = '#00B70B';//vert
                                } else {
                                    $color = '#FF5E5E';//rouge
                                }

                        } else {
                            $valeur = 1;//formée
                            $color = '#CCCCCC';//gris

                        }
                    }


                    }

                }
            }
            //debug($microCompId);debug('nbEvals_'.$nbEvals);
            //debug($nbEvalsFormatives);die;
            return $etat = ['type' => $valeur, 'color' => $color, $listEvals];
        }




        //On crée l'en-tête du tableau dynamiquement en fonction des niveaux de compétence
        //le nb de colonnes servira dimensionnement de référence pour la suite du tableau

        //création des colonnes

        $nbColonnes = $listNiveauxCompetences->count();

        //création des headers
        $n = 0 ;
        $tableHeader[$n] = '';
        foreach ($listNiveauxCompetences as $value) {
            $n++;
            $tableHeader[$n] = $value->nom;
        }

        //création des lignes
        /*
         * Création du tableau:
         * Pour chaque compétences Inter ET pour chaque colonne (nbColonnes)
         * on itère les Obj Pedas contenus dans la compétence
         * si le "numero" (son niveau d'acquisition) de la compétence correspond au n° de colonne
         * on stocke la valeur sinon on stocke ""
         * @return: tableau[$ligne][$numColonne]["nom" => $nom, $contenu[]]
         */
        foreach ($listCompsInters as $comp) {
            $listMicroComps = $comp->objectifs_pedas;
            $nomComp = $comp->fullName;
            $row = $comp->fullName;
            for ($col = 0; $col <= $nbColonnes ; $col++) {

                $written = false;
                if ($col == 0) {
                    $tableau[$row][$col] = [
                            'nom' => $nomComp,
                            'contenu' => [
                                'type' => 0,
                                'bgcolor'=> 'transparent',
                            ]
                    ];
                    $written = true;
                }



                foreach ($listMicroComps as $microComp) {
                    $numero = $microComp->niveaux_competence->numero;
                    $nomMicroComp = $microComp->nom;
                    $contenu = [];

                    if ($numero === $col) {
                        //on regarde si l'état des évals sur la compétence
                        $etat = evaluateMicroComp($eleveId, $microComp->id);
                        $color = $etat['color'];

                        //on fait le tableau avec son contenu
                        $tableau[$row][$col] = [
                            'nom' => $nomMicroComp,
                            'contenu' => [
                                'type' => 0,
                                'bgcolor'=> $color,
                            ]
                        ];
                        $written = true;
                    }

                }
                if (!$written) {
                    $tableau[$row][$col] = [
                            'nom' => '',
                            'contenu' => [
                                'type' => 0,
                                'bgcolor'=> 'transparent',
                            ]
                    ];
                }


            }

        }


        //debug($tableau);die;
        $tableau = ['tableau' => $tableau,
            'tableHeader' =>$tableHeader,
            'nbColonnes' =>$nbColonnes,
            ];

        return $tableau;

    }

}
