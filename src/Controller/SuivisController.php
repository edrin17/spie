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

                $tableau[$row][$col] = [ //on mets une valeur de base dans toutes les cases
                        'nom' => '',
                        'contenu' => [
                            'type' => 0,
                            'maxLvl' => -1,
                            'bgcolor'=> 'transparent',
                        ]
                ];
                foreach ($listMicroComps as $microComp) {
                    $numero = $microComp->niveaux_competence->numero;
                    $nomMicroComp = $microComp->nom;
                    $contenu = [];

                    if ($numero === $col) { //si le n° de la µcomp correspond à la bon colonne(débutant, intégration, approfondissement, maîtrise)
                        $etat = $this->_evaluateMicroComp($eleveId, $microComp->id);//on évalue les µcomp

                        $tableau[$row][$col] = [ //on fait le tableau avec son contenu
                            'nom' => $nomMicroComp,
                            'contenu' => [
                                'type' => $etat['type'],
                                'maxLvl' => $etat['maxLvl'],
                                'bgcolor'=> $etat['color']
                            ]
                        ];
                    }
                }
            }
            //debug($tableau[$row]);die;
            $tableau[$row][0] = [ //on evalue le couleut de la comp inter
                    'nom' => $nomComp,
                    'contenu' => [
                        'type' => 0,
                        'bgcolor'=> $this->_evalComp($tableau[$row]),
                    ]
            ];
            //debug($tableau[$row]);die;
        }

        $tableau = ['tableau' => $tableau,
            'tableHeader' =>$tableHeader,
            'nbColonnes' =>$nbColonnes,
            ];

        return $tableau;

    }
    private function _evalComp($tableau){
        $maxlvl = -1; //pas evalué
        foreach ($tableau as $key => $col) {
            $lvl = $col['contenu']['maxLvl'];

            if ($lvl > $maxlvl ) { //si meilleure eval
                $maxlvl = $lvl;
            }
        }
        switch ($maxlvl) {
            case -1:
                $bgcolor = '#ffffff';
                break;
            case 0:
                $bgcolor = '#CCCCCC';
                break;
            case 1:
                $bgcolor = '#ff3333';
                break;
            case 2:
                $bgcolor = '#ff6600';
                break;
            case 3:
                $bgcolor = '#00B70B';
                break;
            case 4:
                $bgcolor = '#0066cc';
                break;
        }
        return $bgcolor;
    }
    //verifie si 'l'élève à acquis la compétence
    //@params $eleveId (CHAR36)
    //@return array $etat[integer 'type' => (
    //  0'= 'non évalué' ou '1' = formée ou 2 = 'évaluée'),
    //  char 'color'
    private function _evaluateMicroComp($eleveId, $microCompId) {

        //on récupere les évaluations correpondantes aux microComp et à l'élève
        //on les classes par dates
        $tableEvals = TableRegistry::get('Evaluations');
        $listEvals = $tableEvals->find()
            ->contain([
                'Eleves', 'ValeursEvals',
                'TypesEvals', 'ObjectifsPedas.NiveauxCompetences',
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
        $maxlvl = -1;
        //$nbEvals = $listEvals->count();
        //s'il y a des évals
        if (!$listEvals == []) {
            $nbEvalsFormatives = 0;

            foreach ($listEvals as $eval) {
                //debug($listEvals->toArray());die;
                //si PAS DEJA évaluée 4fois OU sommatif on recupère le type et la valeur de l'éval
                if ($valeur !== 3) {
                    $typeEval = $eval->types_eval->numero;//on stocke le type d'eval (formatif ou sommatif)
                    $note = $eval->valeurs_eval->numero;
                    $nbEvalsFormatives ++;

                    if ($typeEval == 2) { // si sommatif
                        $valeur = 3;//évalué en sommatif
                        //si acquis on met en vert sinon rouge
                        if ($note > 1) {
                            $maxlvl = $eval->objectifs_peda->niveaux_competence->numero; //on note le niveau d'aquisition pour plus tard
                            $color = '#00B70B';//vert
                        }else{
                            $color = '#FF5E5E';//rouge
                        }
                    }else{ //si eval formative
                        if ($nbEvalsFormatives > 3) { //si + de 3 éval c'est du sommatif'
                            $valeur = 2;//on met à évalué
                            //si acquis on met en vert sinon rouge
                            if ($note > 1) {
                                $maxlvl = $eval->objectifs_peda->niveaux_competence->numero;
                                $color = '#00B70B';//vert
                            }
                        }else{
                            //il y a des eval au moins formatives donc valeurs de base
                            $maxlvl = 0;
                            $valeur = 1;//formée
                            $color = '#CCCCCC';//gris
                        }
                    }
                }
            }
        }
        $etat = ['type' => $valeur, 'color' => $color, 'maxLvl' => $maxlvl, $listEvals];
        //debug($etat);die;
        return $etat;

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

    private function tabPeriodesRotations($nameController, $nameAction, $options, $request, $spe)
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
                    ->order([
                        'Periodes.numero' => 'ASC',
                        'Rotations.numero' =>'ASC'
                    ]);

            } else {//sinon on récupere la première entity élève de classe coresspondante
                $rotationsList = $tableRotations->find()
                    ->contain(['Periodes'])
                    ->where(['periode_id' => $selectedPeriode])
                    ->order([
                        'Periodes.numero' => 'ASC',
                        'Rotations.numero' =>'ASC'
                    ]);

                $selectedRotation = $tableRotations->find()
                    ->contain(['Periodes'])
                    ->where(['periode_id' => $selectedPeriode])
                    ->order([
                        'Periodes.numero' => 'ASC',
                        'Rotations.numero' =>'ASC'
                    ])
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
                ->order(['Rotations.numero' => 'ASC']);

            $selectedRotation = $tableRotations->find()
				->contain(['Periodes'])
                ->where(['periode_id' => $selectedPeriode])
                ->order(['Rotations.numero' => 'ASC'])
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
            'nameAction','options', 'spe',
        ));
        return $selectedRotation;
    }

	public function tp()
	{
		//tableauClasseur double
        $nameController = 'Suivis';
        $nameAction = 'tp';
        $options = '';
        $spe = 0 ;
        $request = $this->request;
        if ($request->getQuery('spe') !== null) {
            $spe = $request->getQuery('spe');
        }
		$selectedClasse = $this->tabClassesEleves($nameController, $nameAction, $options, $request);
        $selectedRotation = $this->tabPeriodesRotations($nameController, $nameAction, $options, $request, $spe);

		// ***************************************************************************
        //on récupère les info du tableauClasseur id de l'élève et id de la rotation
        $selectedClasseId = $request->getQuery('classe');
        $selectedRotationId = $request->getQuery('rotation');

		if ($this->request->is('post')) {
			$this->save($request);
        }
        //debug($spe);die;

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
            ->where(['TravauxPratiques.rotation_id'=> $selectedRotationId,
                'specifique' => $spe])
            ->order(['TravauxPratiques.nom' => 'ASC']);

        $tableau = array();

        foreach ($listEleves as $eleve) {
            $listTpEleves = $tableTpEleves->find()
                ->contain(['TravauxPratiques'])
                ->where(['eleve_id' => $eleve->id])
                ->where(['TravauxPratiques.rotation_id'=> $selectedRotationId,
                        'specifique' => $spe])
				->order(['TravauxPratiques.nom' => 'ASC']);
            foreach ($listTpEleves as $tp) {
                $tableau[$eleve->nom][$tp->id]['eleve_id'] = $eleve->id;
                $tableau[$eleve->nom][$tp->id]['tp_id'] = $tp->id;
                $tableau[$eleve->nom][$tp->id]['eleve_nom'] = $eleve->fullName;
                $tableau[$eleve->nom][$tp->id]['tp_nom'] = $tp->travaux_pratique->nom;
                $tableau[$eleve->nom][$tp->id]['debut'] = $tp->debut;
                $tableau[$eleve->nom][$tp->id]['fin'] = $tp->fin;
                $tableau[$eleve->nom][$tp->id]['pronote'] = $tp->pronote;
                $tableau[$eleve->nom][$tp->id]['base'] = $this->_evaluated($tp->travaux_pratique->id, $eleve->id);
                $tableau[$eleve->nom][$tp->id]['note'] = $tp->note;
				$tableau[$eleve->nom][$tp->id]['memo'] = $tp->memo;

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
        /*
        $tpElevesTable = TableRegistry::get('TpEleves');
        $listTpEleves = $tpElevesTable->find();
        foreach ($listTpEleves as $tp) {
                $tp->pronote = false;
                $tp->base = false;
                $tp->note = null;
                $tp->debut = null;
                $tp->fin = null;
                $tp->memo = '';
                $tpElevesTable->save($tp);
        }
        return $this->redirect(['action' => 'tp']); */
    }

	public function save()
    {
        $eleve_id = $this->request->getData('eleve_id');
        $tp_id = $this->request->getData('tp_id');
        $selectedPeriodeId = $this->request->getData('selectedPeriodeId');
        $selectedClasseId = $this->request->getData('selectedClasseId');
        $selectedRotationId = $this->request->getData('selectedRotationId');
        $spe = $this->request->getData('spe');

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
		if ($this->request->getData('memo') !== null) {
			$tp->memo = $this->request->getData('memo');
		}
        $tpElevesTable->save($tp);

        return $this->redirect([
            'action' => 'tp',1,
            '?' => [
                'classe' => $selectedClasseId,
                'rotation' => $selectedRotationId,
                'periode' => $selectedPeriodeId,
                'spe' => $spe
                ]]
        );
    }

    public function delete()
    {
        $eleve_id = $this->request->getQuery('eleve_id');
        $tp_id = $this->request->getQuery('tp_id');
        $selectedPeriodeId = $this->request->getQuery('periode');
        $selectedClasseId = $this->request->getQuery('classe');
        $selectedRotationId = $this->request->getQuery('rotation');
        $spe = $this->request->getQuery('spe');

        $tpElevesTable = TableRegistry::get('TpEleves');
        $tp = $tpElevesTable->get($tp_id);

		$tp->debut = null;
        $tp->fin = null;
		$tp->note = null;
        $tp->pronote = false;
		$tp->memo = '';
        //debug($tp);die;
        $tpElevesTable->save($tp);
        return $this->redirect([
            'action' => 'tp',1,
            '?' => [
                'classe' => $selectedClasseId,
                'rotation' => $selectedRotationId,
                'periode' => $selectedPeriodeId,
                'spe' => $spe,
                ]]
        );
    }

    /*public function start()
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
    }*
    /*public function end()
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
    }*/
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

    protected function _evaluated($tp_id, $eleve_id)
    {
        //on récupère la liste des entities lien tp<->objspedas
        $tableTps = TableRegistry::get('TravauxPratiques');
        $tp = $tableTps->get($tp_id,['contain'=> 'TravauxPratiquesObjectifsPedas']);

        //debug($tp_id);debug($eleve_id);die;

        //on compte combien il y a d'ObjectifsPedas dans le TP
        $objsPedasDuTp = $tp->travaux_pratiques_objectifs_pedas;
        $nbObjsPedas = count($objsPedasDuTp);

        //on compte le nombre d'évals qui matchent le TP et l'élève à travers TP_ObjPeda
        $tableEvaluations = TableRegistry::get('Evaluations');
        $compteur = 0;
        foreach ($objsPedasDuTp as $objPeda) {
            $nbEvals = $tableEvaluations->find()
                ->where([
                    'travaux_pratiques_objectifs_peda_id' => $objPeda->id,
                    'eleve_id' => $eleve_id
                ])
                ->count();
            $compteur = $compteur + $nbEvals;
        }
        //debug($compteur.'vs'.$nbObjsPedas);//debug($nbEvals);
        //on renvoie l'état
        if ($compteur === 0) {
            $etat = ['value' => 'Non évalué', 'label_color' => 'label-default'];
        }
        elseif (($compteur > 0) and ($compteur < $nbObjsPedas)) {
            $etat = ['value' => 'Incomplet', 'label_color' => 'label-warning'];
        }
        elseif ($compteur === $nbObjsPedas){
            $etat = ['value' => 'Évalué', 'label_color' => 'label-success'];
        }else {
            $etat = ['value' => 'Erreur!', 'label_color' => 'label-danger'];
        }
        return $etat;
    }
}
