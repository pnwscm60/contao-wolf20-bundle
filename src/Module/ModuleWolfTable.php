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
//DB
    $db = \Contao\System::getContainer()->get('database_connection');

//Gewählte Zeitspanne      
    if($_REQUEST['year']==''){
        $year = '1849';
    } else {
        $year = $_REQUEST['year'];
    }
    if($_REQUEST['sobs']==''){
        $sobs = '0';
    } else {
        $sobs = $_REQUEST['sobs'];
    }
    if($_REQUEST['hy']==''){
        $hy = 1;
    } else {
        if($_REQUEST['hy']=='1'){
        $hy = 1;
        } else {
        $hy = 7;	
        }
    }
    $this->Template->hy = $hy;
    $this->Template->year = $year;
    $hye = $hy+5;
// Jahr manipulieren
    $ym10=$year-10;
    $ym1=$year-1;
    $yp10=$year+10;
    $yp1=$year+1;
    $this->Template->ym10 = $ym10;
    $this->Template->ym1 = $ym1;
    $this->Template->yp10 = $yp10;
    $this->Template->yp1 = $yp1;

    if($hy==1){
		$this->Template->hyy="next half-year";
		$this->Template->hyact=7;
	} else {
		$this->Template->hyy="previous half-year";
		$this->Template->hyact=1;		
	}
   
    if($_REQUEST['sobs']==1){
		$this->Template->sob="hide standardobserver";
		$this->Template->sobs= 1;
        $this->Template->sobb=0;
	} else {
		$this->Template->sob="show standardobserver";
		$this->Template->sobs=0;
        $this->Template->sobb=1;
	}
 // DAten klar > Abfragen
// 1. Mittelwerte berechnen und an Tpl übergeben
        
    $sql="SELECT * from tl_wsby WHERE wsby_y = ?";
    $s0m = $db->executeQuery($sql, array($year))->fetch();
    $this->Template->wsby_ro = $s0m['wsby_ro'];
    $this->Template->wsby_rw = $s0m['wsby_rw'];
    $sql="SELECT AVG(wsb_r) as mean from tl_wsb WHERE wsb_y = ?";
    $s00 = $db->executeQuery($sql, array($year))->fetch();
    $this->Template->mean = $s00['mean'];
    
    $sql="SELECT * from tl_wsbo WHERE wsbo_y = ? ORDER BY wsbo_c;";
    $com = $db->executeQuery($sql, array($year))->fetchAll();
        foreach($com as $c){
                $arrCom[] = array(
                    'wsbo_o' => $c['wsbo_o'],
                    'wsbo_kf' => $c['wsbo_kf'],
                    'wsbo_t1' => $c['wsbo_t1'],
                    'wsbo_t2' => $c['wsbo_t2'],
                    );
        }
        $this->Template->com = $arrCom;
        
    //Tabellendaten
    
	$ii=$i+43;
//Daten der Tabelle
$sum = array();
for($i=$hy; $i <= $hye; $i++) {
        
$sql="SELECT *,wsbo_c from tl_wsb LEFT JOIN tl_wsbo ON wsb_oid = tl_wsbo.id WHERE wsb_y = ? and wsb_m = ? order by wsb_d;";
$sql2="SELECT wsbm_ro from tl_wsbm WHERE wsbm_y = ? and wsbm_m = ?";
$sql3="SELECT AVG(wsb_r) as mean from tl_wsb WHERE wsb_y = ? and wsb_m = ?";
$sql4="SELECT wsbm_rw from tl_wsbm WHERE wsbm_y = ? and wsbm_m = ?";
//echo $sql."<br/>";
$s1m=$db->executeQuery($sql, array($year, $i))->fetchAll();
$s2m=$db->executeQuery($sql2, array($year, $i))->fetch();
$s3m=$db->executeQuery($sql3, array($year, $i))->fetch();
$s4m=$db->executeQuery($sql4, array($year, $i))->fetch();
foreach($s1m as $c){
                $arrS1m[$i][] = array(
                    'wsb_m' => $c['wsb_m'],
                    'wsb_d' => $c['wsb_d'],
                    'wsb_oid' => $c['wsb_oid'],
                    'wsb_o' => $c['wsb_o'],
                    'wsb_g' => $c['wsb_g'],
                    'wsb_f' => $c['wsb_f'],
                    'wsb_r' => $c['wsb_r'],
                    'wsb_fl' => $c['wsb_fl'],
                    'wsbo_c' => $c['wsbo_c'],
                    );
        }
   //var_dump($arrS1m); 
$this->Template->wsbo = $arrS1m;
//Summation pro Spalte
$sum[$i][0] = $s2m['wsbm_ro'];
$sum[$i][1] = $s3m['mean'];
$sum[$i][2] = $s4m['wsbm_rw'];    
$this->Template->rsum = $sum;
        }
	}
}
