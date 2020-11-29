<?php
namespace Pnwscm60\Wolf20Bundle\Module;
class ModuleWolfResults extends \Contao\Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_wolfresults';
 
public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['wolfresults'][0]) . ' ###';
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
    
	if($_REQUEST['er']==1){
		// Error ist 1 > Datenbereich falsch
		$this->Template->er = 1;
	}
if($_REQUEST['showresults']==1){ //nur wenn Resultatperiode angefragt wird
		if($_REQUEST['dtyp']==1){
			$dtyp = 1;
		}else{
			$dtyp = 0;
		}
		if($_REQUEST['datefr']){
			$datefr = $_REQUEST['datefr'];
		}
		if($_REQUEST['dateto']){
			$dateto = $_REQUEST['dateto'];
		}
	//echo $dtyp." / ".$datefr." / ".$dateto;
	
	$this->Template->showresults = 1;
}

if($_REQUEST['rdl']==1){ //nur wenn definitive Resultatausgabe angefragt
		
		if($_REQUEST['fr']){
			$fr = $_REQUEST['fr'];
		}
		if($_REQUEST['to']){
			$to = $_REQUEST['to'];
		}
		
	// Clear any previous output
$intvl1 = $_REQUEST['fr'];
$intvl2 = $_REQUEST['to'];
$typ = $_REQUEST['typ'];
ob_end_clean();
// produce results depending on typ
if($typ==0){
	$sql='SELECT d_datum,d_ut,d_q,d_gruppen,d_flecken,d_A,d_B,d_C,d_D,d_E,d_F,d_G,d_H,d_J, d_code,i_aperture,i_focal_length,i_filter,i_method,i_magnification,i_projection, tl_member.id,lastname,firstname,country from tl_data,tl_instrument,tl_member WHERE tl_instrument.id=d_code AND tl_instrument.i_id=tl_member.id AND d_datum >= ? AND d_datum <= ? ORDER by d_datum,d_code, d_ut ';
	} else {
	$sql='SELECT g_datum,g_ut,g_q,g_nr,g_f,g_Zpd,g_p,g_s,g_pos,g_sector,g_A, g_code,i_aperture,i_focal_length,i_filter,i_method,i_magnification,i_projection, tl_member.id,lastname,firstname,country from tl_groupdata,tl_instrument, tl_member WHERE tl_instrument.id = g_code AND tl_instrument.i_id = tl_member.id AND g_datum >= ? AND g_datum <= ? ORDER by g_datum, g_code, g_ut, g_nr';	
}
//echo $sql.'<br/><br/>';
$result = $db->executeQuery($sql, array($intvl1,$intvl2))->fetchAll();
//$result=mysql_query($sql) or die(mysql_error());
//$num_fields = mysql_num_fields($result);

// Filename with current date
$current_date = date("y/m/d");
if($typ==0){
		$filename = "Dailydata_".$intvl1."-".$intvl2.".csv";
	}else{
		$filename = "Groupdata_".$intvl1."-".$intvl2.".csv";
	}


// Open php output stream and write headers
/*$fp = fopen('php://output', 'w');
if ($fp && $result) {
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=".$filename);  header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);*/
$fp = fopen('php://output', 'w');
    if ($fp && $result) {
    header('Content-Type: text/csv; charset=utf-8');
    header("Content-Disposition: attachment; filename=".$filename);  header("Expires: 0");

//Schreibe Daten > abhängig von typ
if($typ==0) {
	//Kopfzeile schreiben
	echo "date;UT;Q;g;f;A;B;C;D;E;F;G;H;J;instr;aperture;foc;filter;method;mag;proj;user;lname;fname;country\n";
	//Zeilen ausgeben
    foreach ($result as $r) {
    //$row_tally = $row_tally + 1;
	echo $r['d_datum'].";".$r['d_ut'].";".$r['d_q'].";".$r['d_gruppen'].";".$r['d_flecken'].";".$r['d_A'].";".$r['d_B'].";".$r['d_C'].";".$r['d_D'].";".$r['d_E'].";".$r['d_F'].";".$r['d_G'].";".$r['d_H'].";".$r['d_J'].";".$r['d_code'].";".$r['i_aperture'].";".$r['i_focal_length'].";".$r['i_filter'].";".$r['i_method'].";".$r['i_magnification'].";".$r['i_projection'].";".$r['tl_member.id'].";".utf8_decode($r['lastname']).";".utf8_decode($r['firstname']).";".$r['country']."\n";
    }
} else {
	//Kopfzeile schreiben
	echo "date;UT;Q;gnr;f;Zpd;p;s;pos;sect;A;instr;aperture;foc;filter;method;mag;proj;user;lname;fname;country\n";
	//Zeilen ausgeben
    //while ($r = mysql_fetch_row($result)) {
    //$row_tally = $row_tally + 1;
    foreach ($result as $r) {
	echo $r['g_datum'].";".$r['g_ut'].";".$r['g_q'].";".$r['g_nr'].";".$r['g_f'].";".$r['g_Zpd'].";".$r['g_p'].";".$r['g_s'].";".$r['g_pos'].";".$r['g_sector'].";".$r['g_A'].";".$r['g_code'].";".$r['i_aperture'].";".$r['i_focal_length'].";".$r['i_filter'].";".$r['i_method'].";".$r['i_magnification'].";".$r['i_projection'].";".$r['tl_member.id'].";".utf8_decode($r['lastname']).";".utf8_decode($r['firstname']).";".$r['country']."\n";
    }
}
    die;
}
	}
	}
}
