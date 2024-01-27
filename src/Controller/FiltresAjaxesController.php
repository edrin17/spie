<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class FiltresAjaxesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('ajax');
	}

	public function chainedCapacites()
	{
		$capacites = TableRegistry::get('Capacites');

		$referential_id = $_GET['referential_id'];


		$query = $capacites->find()
			->contain(['Referentials'])
			->where(['referential_id' => $referential_id])
			->order(['Capacites.numero' => 'ASC']);

		foreach ($query as $capacites)
		{
			$chainedCapacites[$capacites->id] = $capacites->fullName;
		}
		$ajaxContent = $chainedCapacites;
		$this->set('ajaxContent',$ajaxContent);
		$this->render('filtres_ajaxes');
	}

	public function chainedActivites()
	{
		$activites = TableRegistry::get('Activites');

		$referential_id = $_GET['referential_id'];


		$query = $activites->find()
			->contain(['Referentials'])
			->where(['referential_id' => $referential_id])
			->order(['Activites.numero' => 'ASC']);

		foreach ($query as $activites)
		{
			$chainedActivites[$activites->id] = $activites->fullName;
		}
		$ajaxContent = $chainedActivites;
		$this->set('ajaxContent',$ajaxContent);
		$this->render('filtres_ajaxes');
	}

	public function chainedSavoirs()
	{
		$savoirs = TableRegistry::get('Savoirs');

		$referential_id = $_GET['referential_id'];


		$query = $savoirs->find()
			->contain(['Referentials'])
			->where(['referential_id' => $referential_id])
			->order(['Savoirs.numero' => 'ASC']);

		foreach ($query as $savoirs)
		{
			$chainedActivites[$savoirs->id] = $savoirs->fullName;
		}
		$ajaxContent = $chainedActivites;
		$this->set('ajaxContent',$ajaxContent);
		$this->render('filtres_ajaxes');
	}

	public function chainedCompetencesTerminales()
	{
		$compsTerms = TableRegistry::get('CompetencesTerminales');

		$parentId = $_GET['capacite_id'];


		$query = $compsTerms->find()
			->contain(['Capacites'])
			->where(['capacite_id' => $parentId])
			->order(['Capacites.numero' => 'ASC',
			'CompetencesTerminales.numero' => 'ASC']);

		foreach ($query as $competence)
		{
			$chainedCompsTerms[$competence->id] = $competence->fullName;
		}
		$ajaxContent = $chainedCompsTerms;
		$this->set('ajaxContent',$ajaxContent);
		$this->render('filtres_ajaxes');
	}

	public function chainedCompetencesIntermediaires()
	{
		$compsInter = TableRegistry::get('CompetencesIntermediaires');

		$parentId = $_GET['competences_terminale_id'];


		$query = $compsInter->find()
			->contain(['CompetencesTerminales'])
			->where(['competences_terminale_id' => $parentId])
			->order([
				'CompetencesTerminales.numero' => 'ASC',
				'CompetencesIntermediaires.numero' => 'ASC',
			]);

		foreach ($query as $competence)
		{
			$chainedCompsInter[$competence->id] = $competence->fullName;
		}
		$ajaxContent = $chainedCompsInter;
		$this->set('ajaxContent',$ajaxContent);
		$this->render('filtres_ajaxes');
	}

	public function chainedCompsTerms()
	{
		$compsTerms = TableRegistry::get('CompetencesTerminales');

		$parentId = $_GET['parent_id'];
		$optionToutVoir = $_GET['optionToutVoir'];


		$query = $compsTerms->find()
			->contain(['Capacites'])
			->where(['capacite_id' => $parentId])
			->order(['CompetencesTerminales.numero' => 'ASC']);


		if ($optionToutVoir)
		{
			$chainedCompsTerms['tout'] = "Tout voir";
		}

		foreach ($query as $competence)
		{
			$chainedCompsTerms[$competence->id] = $competence->fullName;
		}
		$ajaxContent = $chainedCompsTerms;
		$this->set('ajaxContent',$ajaxContent);
		$this->render('filtres_ajaxes');
	}

	public function chainedCompsInters()
	{
		$compsInters = TableRegistry::get('CompetencesIntermediaires');

		$parentId = $_GET['parent_id'];
		$optionToutVoir = $_GET['optionToutVoir'];


		$query = $compsInters->find()
			->contain(['CompetencesTerminales.Capacites'])
			->where(['competences_terminale_id' => $parentId])
			->order(['CompetencesIntermediaires.numero' => 'ASC']);


		if ($optionToutVoir)
		{
			$chainedCompsInters['tout'] = "Tout voir";
		}

		foreach ($query as $competence)
		{
			$chainedCompsInters[$competence->id] = $competence->fullName;
		}
		$ajaxContent = $chainedCompsInters;
		$this->set('ajaxContent',$ajaxContent);
		$this->render('filtres_ajaxes');
	}

	public function chainedSousChapitres()
	{
		$sousChaps = TableRegistry::get('SousChapitres');

		$parentId = $_GET['parent_id'];
		$optionToutVoir = $_GET['optionToutVoir'];


		$query = $sousChaps->find()
			->contain(['Chapitres'])
			->where(['chapitre_id' => $parentId])
			->order(['SousChapitres.numero' => 'ASC']);


		if ($optionToutVoir)
		{
			$chainedSousChapitres['tout'] = "Tout voir";
		}

		foreach ($query as $sousChap)
		{
			$chainedSousChapitres[$sousChap->id] = $sousChap->fullName;
		}
		$ajaxContent = $chainedSousChapitres;
		$this->set('ajaxContent',$ajaxContent);
		$this->render('filtres_ajaxes');
	}

	public function chainedSousSousChaps()
	{
		$sousSousChaps = TableRegistry::get('SousSousChapitres');

		$parentId = $_GET['parent_id'];
		$optionToutVoir = $_GET['optionToutVoir'];


		$query = $sousSousChaps->find()
			->contain(['SousSousChapitres'])
			->where(['SousChapitre_id' => $parentId])
			->order(['SousSousChapitres.numero' => 'ASC']);


		if ($optionToutVoir)
		{
			$chainedSousSousChaps['tout'] = "Tout voir";
		}

		foreach ($query as $sousSousChap)
		{
			$chainedSousSousChaps[$sousSousChap->id] = $sousSousChap->fullName;
		}
		$ajaxContent = $chainedSousSousChaps;
		$this->set('ajaxContent',$ajaxContent);
		$this->render('filtres_ajaxes');
	}

    public function chainedClassesByProgression()
	{
		$classesTbl = TableRegistry::get('Classes');
        $progression_id = $this->request->getQuery('progression_id');
		$classes = $classesTbl->find('list')
			->where(['progression_id' => $progression_id,
				'archived' => 0	
			])
			->order(['Classes.nom' => 'ASC']);
        $this->set('ajaxContent', $classes);
		$this->render('filtres_ajaxes');
	}

	public function chainedPeriodesByProgression()
	{
		$periodesTbl = TableRegistry::get('Periodes');
        $progression_id = $this->request->getQuery('progression_id');
		$periodes = $periodesTbl->find('list')
			->where(['progression_id' => $progression_id])
			->order(['Periodes.numero' => 'ASC']);
        $this->set('ajaxContent', $periodes);
		$this->render('filtres_ajaxes');
	}

	public function chainedRotationsByPeriode()
	{
		$rotationsTbl = TableRegistry::get('Rotations');
        $periode_id = $this->request->getQuery('periode_id');
		$rotations = $rotationsTbl->find('list')
			->contain(['Periodes'])
			->where(['periode_id' => $periode_id])
			->order(['Rotations.numero' => 'ASC']);
        $this->set('ajaxContent', $rotations);
		$this->render('filtres_ajaxes');
	}

	public function chainedElevesByClasse()
	{
		$elevesTbl = TableRegistry::get('Eleves');
        $classe_id = $this->request->getQuery('classe_id');
		$eleves = $elevesTbl->find('list')
			->where(['classe_id' => $classe_id])
			->order(['nom' => 'ASC','prenom' => 'ASC']);
        $this->set('ajaxContent', $eleves);
		$this->render('filtres_ajaxes');
	}

	public function chainedProgressionsByReferential()
	{
		$progressionsTbl = TableRegistry::get('Progressions');
        $referential_id = $this->request->getQuery('referential_id');
		$progression = $progressionsTbl->find('list')
			->where(['referential_id' => $referential_id])
			->order(['name' => 'ASC']);
        $this->set('ajaxContent', $progression);
		$this->render('filtres_ajaxes');
	}
}
