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
	
	public function chainedSousChaps() 
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
			$chainedSousChaps['tout'] = "Tout voir";
		}
		
		foreach ($query as $sousChap) 
		{
			$chainedSousChaps[$sousChap->id] = $sousChap->fullName;
		}
		$ajaxContent = $chainedSousChaps;
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
    
    public function chainedPeriodes() 
	{
		$periodes = TableRegistry::get('Periodes');

		$parentId = $_GET['parent_id'];
		
		$query = $periodes->find()
			->where(['classe_id' => $parentId])
			->order(['Periodes.numero' => 'ASC']);
		
		foreach ($query as $periode) 
		{
			$chainedPeriodes[$periode->id] = "Période n°". $periode->numero;
		}
        $ajaxContent = $chainedPeriodes;
		$this->set('ajaxContent',$ajaxContent);
		$this->render('filtres_ajaxes');
	}

}
