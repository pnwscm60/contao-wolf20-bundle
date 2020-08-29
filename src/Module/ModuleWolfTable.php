<?php
namespace Pnwscm60\Wolf20Bundle\Module;
class ModuleWolfTable extends \Contao\Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_wolftable';
 
public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['wolftable'][0]) . ' ###';
            //$objTemplate->firma = $this->headline;
            return $objTemplate->parse();
        }
    return parent::generate();
    }
	
	/**
	 * Compile the current element
	 */
	protected function compile()
	{
	}
}
