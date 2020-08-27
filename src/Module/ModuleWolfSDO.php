<?php
 
class ModuleWolfSDO extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_wolfsdo';
 
public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['wolfsdo'][0]) . ' ###';
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
	

if($_REQUEST["newdate"]){
	$datum = $_REQUEST["newdate"];
	$heute=date("d.m.Y");
	$idatum = $datum;
} else {
$heute = date("d.m.Y");
$datu=time();
$datun=$datu - (60*60*2.5);

$datum=date("d.m.Y", $datun);
if(date("G")<11){
	$idatum=$datum;
} else {
$idatum=date("d.m.Y");
}
}
$this->Template->idatum = $idatum;
$this->Template->datum = $datum;
		
if($_REQUEST['time']){
//time umrechnen
$tim = split(':',$_REQUEST['time']);
$h = $tim[0];
$mi = floor($tim[1]/15)*15;

//if($mi = 0){$mi='00';}
} else {
	$h = date("H", $datun);
	$mi = date("i", $datun);
	$mi = floor($mi/15)*15;

}

$idat=explode(".",$idatum);
$dat=explode(".",$datum);
//echo $datum;
$y = $dat[2];
$mo = $dat[1];
$d = $idat[0];
$ti = $h+$mi/60;

$this->Template->hour =$h;
$this->Template->mi = $mi;
$this->Template->y = $y;
$this->Template->mo = $mo;
$this->Template->d = $d;
$this->Template->ti = $ti;
$this->Template->idat = $idat;
$this->Template->dat = $dat;
	}
}
