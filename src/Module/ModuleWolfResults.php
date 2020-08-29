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
	$sql='SELECT d_datum,d_ut,d_q,d_gruppen,d_flecken,d_A,d_B,d_C,d_D,d_E,d_F,d_G,d_H,d_J, d_code,i_aperture,i_focal_length,i_filter,i_method,i_magnification,i_projection, tl_member.id,lastname,firstname,country from tl_data,tl_instrument,tl_member WHERE tl_instrument.id=d_code AND tl_instrument.i_id=tl_member.id AND d_datum >= "'.$intvl1.'" AND d_datum <= "'.$intvl2.'" ORDER by d_datum,d_code, d_ut ';
	} else {
	$sql='SELECT g_datum,g_ut,g_q,g_nr,g_f,g_Zpd,g_p,g_s,g_pos,g_sector,g_A, g_code,i_aperture,i_focal_length,i_filter,i_method,i_magnification,i_projection, tl_member.id,lastname,firstname,country from tl_groupdata,tl_instrument, tl_member WHERE tl_instrument.id = g_code AND tl_instrument.i_id = tl_member.id AND g_datum >= "'.$intvl1.'" AND g_datum <= "'.$intvl2.'" ORDER by g_datum, g_code, g_ut, g_nr';
	
}
//echo $sql.'<br/><br/>';
$result=mysql_query($sql) or die(mysql_error());
$num_fields = mysql_num_fields($result);

// Filename with current date
$current_date = date("y/m/d");
if($typ==0){
		$filename = "Dailydata_".$intvl1."-".$intvl2.".xls";
	}else{
		$filename = "Groupdata_".$intvl1."-".$intvl2.".xls";
	}


// Open php output stream and write headers
$fp = fopen('php://output', 'w');
if ($fp && $result) {
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=".$filename);  header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

//Schreibe Daten > abhängig von typ
switch ($typ) {
	case 0:
	//Kopfzeile schreiben
	echo "date \t UT \t Q \t g \t f \t A \t B \t C \t D \t E \t F \t G \t H \t J \t instr \t aperture \t foc \t filter \t method \t mag \t proj \t user \t lname \t fname \t country \n";
	//Zeilen ausgeben
    while ($r = mysql_fetch_row($result)) {
    //$row_tally = $row_tally + 1;
	echo $r[0]."\t".$r[1]."\t".$r[2]."\t".$r[3]."\t".$r[4]."\t".$r[5]."\t".$r[6]."\t".$r[7]."\t".$r[8]."\t".$r[9]."\t".$r[10]."\t".$r[11]."\t".$r[12]."\t".$r[13]."\t".$r[14]."\t".$r[15]."\t".$r[16]."\t".$r[17]."\t".$r[18]."\t".$r[19]."\t".$r[20]."\t".$r[21]."\t".utf8_decode($r[22])."\t".utf8_decode($r[23])."\t".$r[24]."\n";
    }
	break;

	case 1:
	//Kopfzeile schreiben
	echo "date \t UT \t Q \t gnr \t f \t Zpd \t p \t s \t pos \t sect \t A \t instr \t aperture \t foc \t filter \t method \t mag \t proj \t user \t lname \t fname \t country \n";
	//Zeilen ausgeben
    while ($r = mysql_fetch_row($result)) {
    //$row_tally = $row_tally + 1;
	echo $r[0]."\t".$r[1]."\t".$r[2]."\t".$r[3]."\t".$r[4]."\t".$r[5]."\t".$r[6]."\t".$r[7]."\t".$r[8]."\t".$r[9]."\t".$r[10]."\t".$r[11]."\t".$r[12]."\t".$r[13]."\t".$r[14]."\t".$r[15]."\t".$r[16]."\t".$r[17]."\t".$r[18]."\t".utf8_decode($r[19])."\t".utf8_decode($r[20])."\t".$r[21]."\n";
    }
	break;
}
    die;
}
	
	
	}
	
		
	}
}
