<?php
namespace Pnwscm60\Wolf20Bundle\Module;
class ModuleWolfSDO extends \Contao\Module
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
// DB verbinden
    $db = \Contao\System::getContainer()->get('database_connection');	

if($_REQUEST["newdate"]){ //Neues Datum gewünscht
	$datum = $_REQUEST["newdate"];
	$heute=date("d.m.Y");
	$idatum = $datum;
} else { // Datum heute
$heute = date("d.m.Y");
$datu=time();
$datun=$datu - (60*60*2.5); //2.5 Std früher

$datum=date("d.m.Y", $datun);
if(date("G")<11){
	$idatum=$datum;
} else {
$idatum=date("d.m.Y");
}
}
$this->Template->idatum = $idatum;
$this->Template->datum = $datum;
		
if($_REQUEST['time']){ //Zeit angefragt
//time umrechnen
$tim = explode(':',$_REQUEST['time']);
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

  //Alle Daten bereit > Abfragen

  $reqdate = $y."-".$mo."-".$d." 00:00:00";
  $sql="SELECT * from tl_dobs WHERE d_time= ? ORDER by d_num;";
  $result = $db->executeQuery($sql, array($reqdate))->fetchAll();
        $arrDobs = array();
        foreach ($result as $r) {
             $arrDobs[] = array
		(
			'id' => $r['inid'],
			'd_num' => $r['d_num'],
            'd_loc' => $r['d_loc'],
            'd_lon' => $r['d_lon'],
            'd_area' => $r['d_area'],
            'd_ext' => $r['d_ext'],
            'd_scl' => $r['d_scl'],
            'd_count' => $r['d_count'],
            'd_mag' => $r['d_mag'],
            'd_time' => $r['d_time']
                );
        }
    $this->Template->dobs = $arrDobs;
	}
}
