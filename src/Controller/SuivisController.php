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
        //changement de variable pour correspondre à la vue standard
        $nameController = 'Suivis';
        $nameAction = 'suivi';
        $options = '';
        $request = $this->request;
		$this->tabClassesEleves($nameController, $nameAction, $options, $request);
        //$this->tabPeriodesRotations($nameController, $nameAction, $options, $request);
        $eleve = $this->request->getQuery('eleve');

        //on récupère les évaluations de l'élève

        $tableEvaluations = TableRegistry::get('Evaluations');
		$evaluations = $tableEvaluations->find()
			->where(['eleve_id' => $eleve])
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


        /*
        $classesList = $classesList;
        $elevesList = $elevesList;

        $selectedLVL1 = $selectedClasse;
        $selectedLVL2 = $selectedEleve;
        */

        //création du tableau
        $table = $this->tableau($eleve);
        $tableau = $table['tableau'];
        $tableHeader = $table['tableHeader'];
        $nbColonnes = $table['nbColonnes'];


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

    private function tabClassesEleves($nameController, $nameAction, $options, $request)
    {

        $selectedClasse = $this->request->getQuery('classe');
        $eleve_id = $this->request->getQuery('eleve');
        $tableEleves = TableRegistry::get('Eleves');
        $tableClasses = TableRegistry::get('Classes');

        $classesList = $tableClasses->find()
						->where(['Classes.archived' => 0])
						->order(['Classes.nom' => 'ASC']);

        $elevesList = $tableEleves->find()
            ->order(['Eleves.nom' => 'ASC']);
        //debug($classesList->toArray());die;

        //si on a sélectionné une classe
        if ($selectedClasse != null) {
            //si on a sélectionné un élève récupère l'entity eleve'
            if ($eleve_id != null) {
                $selectedEleve = $tableEleves->get($eleve_id,['contain' => [] ]);
                $elevesList = $tableEleves->find()
                    ->where(['classe_id' => $selectedClasse])
                    ->order(['Eleves.nom' => 'ASC']);

            } else {//sinon on récupere la première entity élève de classe coresspondante
                $elevesList = $tableEleves->find()
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
            $elevesList = $tableEleves->find()
                ->where(['classe_id' => $selectedClasse])
                ->order(['Eleves.nom' => 'ASC']);

            $selectedEleve = $tableEleves->find()
                ->where(['classe_id' => $classe->id])
                ->order(['Eleves.nom' => 'ASC'])
                ->first();
        }
        //passage des variables pour le layout
        $this->set('titre', "Suivi de l'élève ".$selectedEleve->nom." ".$selectedEleve->prenom);

        //passage des variables standardisées pour la vue tableauClasseur
        $this->set(compact(
            'classesList','elevesList','selectedClasse','selectedEleve','nameController',
            'nameAction','options'
        ));
        return $selectedClasse;
    }

    private function tabPeriodesRotations($nameController, $nameAction, $options, $request)
    {

        $selectedPeriode = $this->request->getQuery('periode');
        $rotation_id = $this->request->getQuery('rotation');
        $tablePeriodes = TableRegistry::get('Periodes');
        $tableRotations = TableRegistry::get('Rotations');

        $periodesList = $tablePeriodes->find()
						->order(['Periodes.numero' => 'ASC']);

        $rotationsList = $tableRotations->find()
            ->contain(['Periodes'])
            ->order(['Rotations.nom' => 'ASC']);
        //debug($classesList->toArray());die;

        //si on a sélectionné une classe
        if ($selectedPeriode != null) {
            //si on a sélectionné un élève récupère l'entity eleve'
            if ($rotation_id != null) {
                $selectedRotation = $tableRotations->get($rotation_id,['contain' => [] ]);
                $rotationsList = $tableRotations->find()
                    ->contain(['Periodes'])
                    ->where(['periode_id' => $selectedPeriode])
                    ->order(['Rotations.nom' => 'ASC']);

            } else {//sinon on récupere la première entity élève de classe coresspondante
                $rotationsList = $tableRotations->find()
                    ->contain(['Periodes'])
                    ->where(['periode_id' => $selectedPeriode])
                    ->order(['Rotations.nom' => 'ASC']);

                $selectedRotation = $tableRotations->find()
                    ->contain(['Periodes'])
                    ->where(['periode_id' => $selectedPeriode])
                    ->order(['Rotations.nom' => 'ASC'])
                    ->first();
            }
        } else {
            $periode = $tablePeriodes->find()
				->order(['Periodes.numero'])
                ->first();
            $selectedPeriode = $periode->id;
            $rotationsList = $tableRotations->find()
				->contain(['Periodes'])
                ->where(['periode_id' => $selectedPeriode])
                ->order(['Rotations.nom' => 'ASC']);

            $selectedRotation = $tableRotations->find()
				->contain(['Periodes'])
                ->where(['periode_id' => $selectedPeriode])
                ->order(['Rotations.nom' => 'ASC'])
                ->first();
        }

        //modification d'un contenu des variables'
        foreach ($periodesList as $periode) {
            $periode->nom = 'P'.$periode->numero;
        }

        //modification d'un contenu des variables'
        foreach ($rotationsList as $rotation) {
            $rotation->nom = $rotation->fullName;
        }

        //passage des variables standardisées pour la vue tableauClasseur
        $this->set(compact(
            'rotationsList','periodesList','selectedPeriode','selectedRotation','nameController',
            'nameAction','options'
        ));
        return $selectedRotation;
    }

	public function tp()
	{
		//tableauClasseur double
        $nameController = 'Suivis';
        $nameAction = 'tp';
        $options = '';
        $request = $this->request;
		$selectedClasse = $this->tabClassesEleves($nameController, $nameAction, $options, $request);
        $selectedRotation = $this->tabPeriodesRotations($nameController, $nameAction, $options, $request);

		// ***************************************************************************
        //on récupère les info du tableauClasseur id de l'élève et id de la rotation
        $selectedClasseId = $request->getQuery('classe');
        $selectedRotationId = $request->getQuery('rotation');


		if ($this->request->is('post')) {
			$this->save($request);
        }


        if ($selectedClasseId == '') {
            $selectedClasseId = $selectedClasse;
        }
        if ($selectedRotationId == '') {
            $selectedRotationId = $selectedRotation->id;
        }

        $tableEleves = TableRegistry::get('Eleves');
        $listEleves = $tableEleves->find()
            ->where(['classe_id' => $selectedClasseId])
            ->order(['Eleves.nom' => 'ASC']);

        $tableTpEleves = TableRegistry::get('TpEleves');

        $listTpHead = $tableTpEleves->find()
            ->select(['TravauxPratiques.nom'])
            ->distinct()
            ->contain(['Eleves','TravauxPratiques'])
            ->where(['classe_id' => $selectedClasseId])
            ->where(['TravauxPratiques.rotation_id'=> $selectedRotationId])
            ->order(['TravauxPratiques.nom' => 'ASC']);

        $tableau = array();

        foreach ($listEleves as $eleve) {
            $listTpEleves = $tableTpEleves->find()
                ->contain(['TravauxPratiques'])
                ->where(['eleve_id' => $eleve->id])
                ->where(['TravauxPratiques.rotation_id'=> $selectedRotationId])
				->order(['TravauxPratiques.nom' => 'ASC']);
            foreach ($listTpEleves as $tp) {
                $tableau[$eleve->nom][$tp->id]['eleve_id'] = $eleve->id;
                $tableau[$eleve->nom][$tp->id]['tp_id'] = $tp->id;
                $tableau[$eleve->nom][$tp->id]['eleve_nom'] = $eleve->fullName;
                $tableau[$eleve->nom][$tp->id]['tp_nom'] = $tp->travaux_pratique->nom;
                $tableau[$eleve->nom][$tp->id]['debut'] = $tp->debut;
                $tableau[$eleve->nom][$tp->id]['fin'] = $tp->fin;
                $tableau[$eleve->nom][$tp->id]['pronote'] = $tp->pronote;
                $tableau[$eleve->nom][$tp->id]['base'] = $tp->base;
                $tableau[$eleve->nom][$tp->id]['note'] = $tp->note;

            }
        }


        $this->set(compact('tableau','listTpHead'));

	}

    public function add()
    {
		$tpTable = TableRegistry::get('TravauxPratiques');
		$tpList = $tpTable->find();

        $elevesTable = TableRegistry::get('Eleves');
		$elevesList = $elevesTable->find();

        $tpElevesTable = TableRegistry::get('TpEleves');

        foreach ($elevesList as $eleve) {
            foreach ($tpList as $tp) {
                $tpEleve = $tpElevesTable->newEntity([
                    'eleve_id' => $eleve->id,
                    'travaux_pratique_id' => $tp->id
                ]);
                $tpElevesTable->save($tpEleve);
            }
        }
        return $this->redirect(['action' => 'suivi']);
    }

    public function reset()
    {
		$tpElevesTable = TableRegistry::get('TpEleves');
        $listTpEleves = $tpElevesTable->find();
        foreach ($listTpEleves as $tp) {
                $tp->pronote = 0;
                $tp->base = 0;
                $tp->note = 0;
                $tp->debut = null;
                $tp->fin = null;
                $tpElevesTable->save($tp);
        }
        return $this->redirect(['action' => 'tp']);
    }

	public function save()
    {
        $eleve_id = $this->request->getData('eleve_id');
        $tp_id = $this->request->getData('tp_id');
        $selectedPeriodeId = $this->request->getData('selectedRotationPeriodeId');
        $selectedClasseId = $this->request->getData('selectedClasseId');
        $selectedRotationId = $this->request->getQuery('selectedRotationId');

        $tpElevesTable = TableRegistry::get('TpEleves');
        $tp = $tpElevesTable->get($tp_id);
		if ($this->request->getData('date_debut') !== '') {
			$tp->debut = $this->request->getData('date_debut');
		}
		if ($this->request->getData('note') !== '') {
        	$tp->note = $this->request->getData('note');
		}else {
			$tp->note = null;
		}
		if ($this->request->getData('date_fin') !== null) {
			if ($this->request->getData('date_fin') != '') {
				$tp->fin = $this->request->getData('date_fin');
			}else {
				$tp->fin = null;
			}
		}
        if ($this->request->getData('pronote') !== null) {
        	$tp->pronote = filter_var($this->request->getData('pronote'), FILTER_VALIDATE_BOOLEAN);
		}else {
			$tp->pronote = false;
		}
        if ($this->request->getData('base') !== null) {
        	$tp->base = filter_var($this->request->getData('base'), FILTER_VALIDATE_BOOLEAN);
		}else {
			$tp->base = false;
		}
        $tpElevesTable->save($tp);
        return $this->redirect([
            'action' => 'tp',1,
            '?' => [
                'classe' => $selectedClasseId,
                'rotation' => $selectedRotationId,
                'periode' => $selectedPeriodeId,
                ]]
        );
    }

    public function start()
    {
        $eleve_id = $this->request->getQuery('eleve');
        $tp_id = $this->request->getQuery('tp');
        $selectedPeriode = $this->request->getQuery('periode');
        $selectedClasse = $this->request->getQuery('classe');
        $selectedRotation = $this->request->getQuery('rotation');

        $tpElevesTable = TableRegistry::get('TpEleves');
        $tp = $tpElevesTable->get($tp_id);
        $tp->debut = date('Y-m-d');
        $tpElevesTable->save($tp);
        return $this->redirect([
            'action' => 'tp',1,
            '?' => [
                'classe' => $selectedClasse,
                'rotation' => $selectedRotation,
                'periode' => $selectedPeriode,
                ]]
        );
    }
    public function end()
    {
        $eleve_id = $this->request->getQuery('eleve');
        $tp_id = $this->request->getQuery('tp');
        $tpElevesTable = TableRegistry::get('TpEleves');
        $selectedPeriode = $this->request->getQuery('periode');
        $selectedClasse = $this->request->getQuery('classe');
        $selectedRotation = $this->request->getQuery('rotation');
        $tp = $tpElevesTable->get($tp_id);
        $tp->fin = date('Y-m-d');
        $tpElevesTable->save($tp);
        return $this->redirect([
            'action' => 'tp',1,
            '?' => [
                'classe' => $selectedClasse,
                'rotation' => $selectedRotation,
                'periode' => $selectedPeriode,
                ]]
        );
    }
    public function validate()
    {
        $eleve_id = $this->request->getQuery('eleve');
        $tp_id = $this->request->getQuery('tp');
        $options = $this->request->getQuery('options');
        $tpElevesTable = TableRegistry::get('TpEleves');

        $selectedPeriode = $this->request->getQuery('periode');
        $selectedClasse = $this->request->getQuery('classe');
        $selectedRotation = $this->request->getQuery('rotation');

        $tp = $tpElevesTable->get($tp_id);
        switch ($options) {
            case 'pronote':
                $tp->pronote = true;
                break;

            case 'note':
                $tp->note = true;
                break;

            case 'base':
                $tp->base = true;
                break;
        }

        $tpElevesTable->save($tp);

        return $this->redirect([
            'action' => 'tp',1,
            '?' => [
                'classe' => $selectedClasse,
                'rotation' => $selectedRotation,
                'periode' => $selectedPeriode,
                ]]
        );
    }
}
