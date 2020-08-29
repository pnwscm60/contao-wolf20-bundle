<?php
namespace Pnwscm60\Wolf20Bundle\Module;
class ModuleWolfProfil extends \Contao\Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_wolfprofil';
 
public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['wolfresults0'][0]) . ' ###';
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
	$this->import('FrontendUser', 'User');
		$userid = $this->User->id;
	//Daten bereitstellen für FE
	if($_REQUEST['save']==1){
		$sql = "UPDATE tl_member SET lastname = '".$_REQUEST['lastname']."', firstname = '".$_REQUEST['firstname']."', city = '".$_REQUEST['city']."', country = '".$_REQUEST['country']."', yearOfBirth = ".$_REQUEST['jg'].", email='".$_REQUEST['email']."' WHERE id=?";
		$this->Database->prepare($sql)->execute($userid);
		$this->Template->saveok = 1;
	}	
		
		
		$this->import('Database');
		$sql="SELECT * from tl_member WHERE id=".$userid;
		$res = Database::getInstance()->query($sql);
		//echo $sql;
		$this->Template->user = $res->fetchAllAssoc();
		
		//$rs = Database::getInstance()->query($sql);
		
			//$this ->Template->wktask = $rs->fetchAllAssoc();
		
	
		
	
		
	}
}
