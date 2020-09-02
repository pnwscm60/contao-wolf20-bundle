<?php
/**
 * Back end modules
 * Front end modules
 */
use Pnwscm60\Wolf20Bundle\Module\ModuleWolfAdmin;
use Pnwscm60\Wolf20Bundle\Module\ModuleWolfEntry0;
use Pnwscm60\Wolf20Bundle\Module\ModuleWolfEntry1;
use Pnwscm60\Wolf20Bundle\Module\ModuleWolfEntry;
use Pnwscm60\Wolf20Bundle\Module\ModuleWolfProfil;
use Pnwscm60\Wolf20Bundle\Module\ModuleWolfGraph;
use Pnwscm60\Wolf20Bundle\Module\ModuleWolfInstedit;
use Pnwscm60\Wolf20Bundle\Module\ModuleWolfResults;
use Pnwscm60\Wolf20Bundle\Module\ModuleWolfReview;
use Pnwscm60\Wolf20Bundle\Module\ModuleWolfSDO;
use Pnwscm60\Wolf20Bundle\Module\ModuleWolfTable;
$GLOBALS['FE_MOD']['wolf20'] = [ 
	'admin' => ModuleWolfAdmin::class,
	'entry0' => ModuleWolfEntry0::class,
	'entry1' => ModuleWolfEntry1::class,
	'entry' => ModuleWolfEntry::class,
	'profil' => ModuleWolfProfil::class,
	'graph' => ModuleWolfGraph::class,
	'instedit' => ModuleWolfInstedit::class,
	'results' => ModuleWolfResults::class,
	'review' => ModuleWolfReview::class,
  'sdo' => ModuleWolfSDO::class,
  'table' => ModuleWolfTable::class
];  
