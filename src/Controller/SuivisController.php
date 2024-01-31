<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use PhpParser\Node\Expr\Cast\Array_;

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

    public function view($id = null)
    {
        //on récupère la liste des élèves et la classe correpondante
        $tableEleves = TableRegistry::get('Eleves');
        $eleves = $tableEleves->find()
            ->where(['classe_id' => $id])
            ->order(['Eleves.nom' => 'ASC', 'Eleves.prenom' => 'ASC']);
        $this->set(compact('eleves'));
    }

    public function suivi()
    {
        $request = $this->request;
        $this->_loadFilters($request);
        $eleve_id = $this->viewVars['eleve_id'];

        //création du tableau
        $table = $this->genTabloDeSuivi($eleve_id);
        $tableau = $table['tableau'];
        $tableHeader = $table['tableHeader'];
        $nbColonnes = $table['nbColonnes'];

        $this->set(compact('tableau', 'tableHeader', 'nbColonnes'));
    }

    // crée le tableau de suivi avec l'état pour chaque micro compétences
    //@params $eleveId (CHAR36)
    //@returns $tableau (array): contient le nom de la microComp et le contenu sous forme de tableau

    private function genTabloDeSuivi($eleveId = null)
    {
        //chargement des données
        $tableCompsInters = TableRegistry::get('CompetencesIntermediaires');
        $listCompsInters = $tableCompsInters->find()
            ->contain([
                'CompetencesTerminales.Capacites',
                'ObjectifsPedas.NiveauxCompetences',
                'ObjectifsPedas.TravauxPratiques.Rotations.Periodes',
            ])
            ->order([
                'Capacites.numero' => 'ASC',
                'CompetencesTerminales.numero' => 'ASC',
                'CompetencesIntermediaires.numero' => 'ASC',
            ]);
        //tri par progression
        $listCompsInters->matching('ObjectifsPedas.TravauxPratiques.Rotations.Periodes', function ($q) {
            return $q->where(['progression_id' => $this->viewVars['progression_id']]);
        });

        $tableNiveauxCompetences = TableRegistry::get('NiveauxCompetences');
        $listNiveauxCompetences = $tableNiveauxCompetences->find()
            ->order(['numero' => 'ASC']);

        //debug($tableEvals);die;
        //On crée l'en-tête du tableau dynamiquement en fonction des niveaux de compétence
        //le nb de colonnes servira dimensionnement de référence pour la suite du tableau

        //création des colonnes

        $nbColonnes = $listNiveauxCompetences->count();

        //création des headers
        $n = 0;
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

            for ($col = 0; $col <= $nbColonnes; $col++) {

                $tableau[$row][$col] = [ //on mets une valeur de base dans toutes les cases
                    'nom' => '',
                    'contenu' => [
                        'type' => 0,
                        'maxLvl' => -1,
                        'bgcolor' => 'transparent',
                    ]
                ];
                foreach ($listMicroComps as $microComp) {
                    $numero = $microComp->niveaux_competence->numero;
                    $nomMicroComp = $microComp->nom;
                    $contenu = [];

                    if ($numero === $col) { //si le n° de la µcomp correspond à la bon colonne(débutant, intégration, approfondissement, maîtrise)
                        $etat = $this->_evaluateMicroComp($eleveId, $microComp->id); //on évalue les µcomp

                        $tableau[$row][$col] = [ //on fait le tableau avec son contenu
                            'nom' => $nomMicroComp,
                            'contenu' => [
                                'type' => $etat['type'],
                                'maxLvl' => $etat['maxLvl'],
                                'bgcolor' => $etat['color']
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
                    'bgcolor' => $this->_evalComp($tableau[$row]),
                ]
            ];
            //debug($tableau[$row]);die;
        }

        $tableau = [
            'tableau' => $tableau,
            'tableHeader' => $tableHeader,
            'nbColonnes' => $nbColonnes,
        ];

        return $tableau;
    }
    private function _evalComp($tableau)
    {
        $maxlvl = -1; //pas evalué
        foreach ($tableau as $key => $col) {
            $lvl = $col['contenu']['maxLvl'];

            if ($lvl > $maxlvl) { //si meilleure eval
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
    }        //$this->tabPeriodesRotations($nameController, $nameAction, $options, $request);
    //verifie si 'l'élève à acquis la compétence
    //@params $eleveId (CHAR36)
    //@return array $etat[integer 'type' => (
    //  0'= 'non évalué' ou '1' = formée ou 2 = 'évaluée'),
    //  char 'color'
    private function _evaluateMicroComp($eleveId, $microCompId)
    {

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
            ]);
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
                    $typeEval = $eval->types_eval->numero; //on stocke le type d'eval (formatif ou sommatif)
                    $note = $eval->valeurs_eval->numero;
                    $nbEvalsFormatives++;

                    if ($typeEval == 2) { // si sommatif
                        $valeur = 3; //évalué en sommatif
                        //si acquis on met en vert sinon rouge
                        if ($note > 1) {
                            $maxlvl = $eval->objectifs_peda->niveaux_competence->numero; //on note le niveau d'aquisition pour plus tard
                            $color = '#00B70B'; //vert
                        } else {
                            $color = '#FF5E5E'; //rouge
                        }
                    } else { //si eval formative
                        if ($nbEvalsFormatives > 3) { //si + de 3 éval c'est du sommatif'
                            $valeur = 2; //on met à évalué
                            //si acquis on met en vert sinon rouge
                            if ($note > 1) {
                                $maxlvl = $eval->objectifs_peda->niveaux_competence->numero;
                                $color = '#00B70B'; //vert
                            }
                        } else {
                            //il y a des eval au moins formatives donc valeurs de base
                            $maxlvl = 0;
                            $valeur = 1; //formée
                            $color = '#CCCCCC'; //gris
                        }
                    }
                }
            }
        }
        $etat = ['type' => $valeur, 'color' => $color, 'maxLvl' => $maxlvl, $listEvals];
        //debug($etat);die;
        return $etat;
    }

    public function tp()
    {
        $request = $this->request;// TODO #2 Is it usefull since it's not used in the function ?
        $this->_loadFilters($request);
        $progression_id = $this->viewVars['progression_id'];
        $classe_id = $this->viewVars['classe_id'];
        $periode_id = $this->viewVars['periode_id'];
        $rotation_id = $this->viewVars['rotation_id'];
        $eleves = $this->viewVars['elevesObjs']; // dans la vue POST eleves sous forme d'objets

        $spe = 0;

        if ($this->request->is('post')) {
            $this->save($request);
        }
        $tableTpEleves = TableRegistry::get('TpEleves');
        $tableTp = TableRegistry::get('TravauxPratiques');

        $listTpHead = $tableTp->find() //On récupère la liste de TP pour faire l'en-tête
            ->select(['TravauxPratiques.nom'])
            ->where([
                'TravauxPratiques.rotation_id' => $rotation_id,
                'specifique' => $spe
            ])
            ->order(['TravauxPratiques.nom' => 'ASC']);

        $tableau = array();

        foreach ($eleves as $eleve) {
            $listTpEleves = $tableTpEleves->find()
                ->contain(['TravauxPratiques'])
                ->where(['eleve_id' => $eleve->id])
                ->where([
                    'TravauxPratiques.rotation_id' => $rotation_id,
                    'specifique' => $spe
                ])
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
        //debug($tableau);
        $this->set(compact('tableau', 'listTpHead', 'classe_id', 'progression_id', 'rotation_id', 'periode_id', 'spe'));
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
    
    private function _loadFilters($request = null)
    {
        $progressionsTbl = TableRegistry::get('Progressions');
        $progressions = $progressionsTbl->find('list')
            ->order(['id' => 'ASC']);

        $progression_id = $this->request->getQuery('progression_id');

        if ($progression_id == '') {
            $progression_id = $progressionsTbl->find()
                ->order(['id' => 'ASC'])
                ->first()
                ->id;
        }

        $classesTbl = TableRegistry::get('Classes');
        $classes = $classesTbl->find('list')
            ->where([
                'archived' => 0,
                'progression_id' => $progression_id
            ])
            ->order(['nom' => 'ASC']);
        $classe_id = $this->request->getQuery('classe_id');
        if ($classe_id == '') {
            $classe_id = $classesTbl->find()
                ->where([
                    'archived' => 0,
                    'progression_id' => $progression_id
                ])
                ->first()
                ->id;
        }
        $elevesTbl = TableRegistry::get('eleves');
        $eleves = $elevesTbl->find('list')
            ->where([
                'classe_id' => $classe_id
            ])
            ->order(['nom' => 'ASC', 'prenom' => 'ASC']);
        $elevesObjs = $elevesTbl->find() //eleve sous forme d'objets
            ->where([
                'classe_id' => $classe_id
            ])
            ->order(['nom' => 'ASC', 'prenom' => 'ASC']);
        $eleve_id = $this->request->getQuery('eleve_id');
        if ($eleve_id == '') {
            $eleve_id = $elevesTbl->find()
                ->where([
                    'classe_id' => $classe_id
                ])
                ->order(['nom' => 'ASC', 'prenom' => 'ASC'])
                ->first()
                ->id;
        }

        $periodesTbl = TableRegistry::get('Periodes');
        $periodes = $periodesTbl->find('list')
            ->where(['progression_id' => $progression_id])
            ->order(['numero' => 'ASC']);
        $periode_id = $this->request->getQuery('periode_id');
        if ($periode_id == '') {
            $periode_id = $periodesTbl->find()
                ->where(['progression_id' => $progression_id])
                ->order(['numero' => 'ASC'])
                ->first()->id;
        }

        $rotationsTbl = TableRegistry::get('Rotations');
        $rotations = $rotationsTbl->find('list')
            ->contain(['Periodes'])
            ->where(['periode_id' => $periode_id])
            ->order(['Rotations.numero' => 'ASC']);
        $rotation_id = $this->request->getQuery('rotation_id');
        if ($rotation_id == '') {
            $rotation_id = $rotationsTbl->find()
                ->where(['periode_id' => $periode_id])
                ->order(['numero' => 'ASC'])
                ->first()->id;
        }

        $tachesTbl = TableRegistry::get('TachesPros');
        $taches = $tachesTbl->find('list')
            ->contain(['Activites'])
            ->order([
                'Activites.Numero' => 'ASC',
                'TachesPros.Numero' => 'ASC'
            ]);
        $tache_id = $this->request->getQuery('tache_id');
        if ($tache_id == '') {
            $tache_id = $tachesTbl->find()
                ->contain(['Activites'])
                ->order([
                    'Activites.Numero' => 'ASC',
                    'TachesPros.Numero' => 'ASC'
                ])
                ->first()->id;
        }
        $this->set(compact( //passage des variables à la vue
            'classes',
            'classe_id',
            'progression_id',
            'progressions',
            'rotations',
            'rotation_id',
            'periodes',
            'periode_id',
            'taches',
            'tache_id',
            'eleves',
            'eleve_id',
            'elevesObjs',
        ));
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
        $periode_id = $this->request->getQuery('periode_id');
        $classe_id = $this->request->getQuery('classe_id');
        $rotation_id = $this->request->getQuery('rotation_id');
        $progression_id = $this->request->getQuery('progression_id');
        $spe = $this->request->getData('spe');

        $tpElevesTable = TableRegistry::get('TpEleves');
        $tp = $tpElevesTable->get($tp_id);
        if ($this->request->getData('date_debut') !== '') {
            $tp->debut = $this->request->getData('date_debut');
        }
        if ($this->request->getData('note') !== '') {
            $tp->note = $this->request->getData('note');
        } else {
            $tp->note = null;
        }
        if ($this->request->getData('date_fin') !== null) {
            if ($this->request->getData('date_fin') != '') {
                $tp->fin = $this->request->getData('date_fin');
            } else {
                $tp->fin = null;
            }
        }
        if ($this->request->getData('pronote') !== null) {
            $tp->pronote = filter_var($this->request->getData('pronote'), FILTER_VALIDATE_BOOLEAN);
        } else {
            $tp->pronote = false;
        }
        if ($this->request->getData('base') !== null) {
            $tp->base = filter_var($this->request->getData('base'), FILTER_VALIDATE_BOOLEAN);
        } else {
            $tp->base = false;
        }
        if ($this->request->getData('memo') !== null) {
            $tp->memo = $this->request->getData('memo');
        }
        $tpElevesTable->save($tp);

        return $this->redirect(
            [
                'action' => 'tp', 1,
                '?' => [
                    'classe_id' => $classe_id,
                    'rotation_id' => $rotation_id,
                    'periode_id' => $periode_id,
                    'progression_id' => $progression_id,
                    'spe' => $spe,
                ]
            ]
        );
    }

    public function delete()
    {
        $eleve_id = $this->request->getQuery('eleve_id');
        $tp_id = $this->request->getQuery('tp_id');
        $periode_id = $this->request->getQuery('periode_id');
        $classe_id = $this->request->getQuery('classe_id');
        $rotation_id = $this->request->getQuery('rotation_id');
        $progression_id = $this->request->getQuery('progression_id');
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
        return $this->redirect(
            [
                'action' => 'tp', 1,
                '?' => [
                    'classe_id' => $classe_id,
                    'rotation_id' => $rotation_id,
                    'periode_id' => $periode_id,
                    'progression_id' => $progression_id,
                    'spe' => $spe,
                ]
            ]
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

        return $this->redirect(
            [
                'action' => 'tp', 1,
                '?' => [
                    'classe' => $selectedClasse,
                    'rotation' => $selectedRotation,
                    'periode' => $selectedPeriode,
                ]
            ]
        );
    }

    protected function _evaluated($tp_id, $eleve_id)
    {
        //on récupère la liste des entities lien tp<->objspedas
        $tableTps = TableRegistry::get('TravauxPratiques');
        $tp = $tableTps->get($tp_id, ['contain' => 'TravauxPratiquesObjectifsPedas']);

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
        } elseif (($compteur > 0) and ($compteur < $nbObjsPedas)) {
            $etat = ['value' => 'Incomplet', 'label_color' => 'label-warning'];
        } elseif ($compteur === $nbObjsPedas) {
            $etat = ['value' => 'Évalué', 'label_color' => 'label-success'];
        } else {
            $etat = ['value' => 'Erreur!', 'label_color' => 'label-danger'];
        }
        return $etat;
    }
}
