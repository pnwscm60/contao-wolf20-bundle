<?php
namespace Pnwscm60\Wolf20Bundle\Module;
class ModuleWolfReview extends \Contao\Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_wolfreview';
 
public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### REVIEW ###';
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
    // Angaben zum User
	$this->import('FrontendUser', 'User');
	$userid = $this->User->id;	
	
        if($_REQUEST['er']==1){
		// Error ist 1 > Datenbereich falsch
		$this->Template->er = 1;
        
	}
		//Informationen zum Observer
        $qsql='SELECT * from tl_member WHERE id = ?';
        $mresult = $db->executeQuery($qsql, array($userid))->fetch();
        $this->Template->observer = $mresult['id'];
        $this->Template->lname = $mresult['lastname'];
        $this->Template->fname = $mresult['firstname'];
        $this->Template->city = $mresult['city'];
        $this->Template->country = strtoupper($mresult['country']);
		
/*****  AUSGABE ALS EXCEL-FILE ****/
	if($_REQUEST['rdl']==1){ //nur wenn definitive Resultatausgabe angefragt
		  if($_REQUEST['fr']){
			$fr = $_REQUEST['fr'];
		  }
		  if($_REQUEST['to']){
			$to = $_REQUEST['to'];
		  }
		
// Clear any previous output
    /*$intvl10 = $_REQUEST['fr'];
    $dat1 = preg_split("/[.]+/", $intvl10);
    $intvl1 = $dat1[2]."-".$dat1[1]."-".$dat1[0];
    $intvl20 = $_REQUEST['to'];
    $dat2 = preg_split("/[.]+/", $intvl20);
    $intvl2 = $dat2[2]."-".$dat2[1]."-".$dat2[0];*/
    $intvl1 = $_REQUEST['fr'];
    $intvl2 = $_REQUEST['to'];
    $typ = $_REQUEST['typ'];
    $code = $_REQUEST['ins'];
    ob_end_clean();
// produce results depending on typ
    if($typ==0){
        $sql='SELECT d_datum,d_ut,d_q,d_gruppen,d_flecken,d_A,d_B,d_C,d_D,d_E,d_F,d_G,d_H,d_J, d_code,i_aperture,i_focal_length,i_filter,i_method,i_magnification,i_projection, tl_member.id,lastname,firstname,country from tl_data,tl_instrument,tl_member WHERE tl_instrument.id=d_code AND tl_instrument.i_id=tl_member.id AND d_datum >= ? AND d_datum <= ? AND tl_instrument.id = ? ORDER by d_datum,d_code, d_ut';
        } else {
        $sql='SELECT g_datum,g_ut,g_q,g_nr,g_f,g_Zpd,g_p,g_s,g_pos,g_sector,g_A, g_code,i_aperture,i_focal_length,i_filter,i_method,i_magnification,i_projection, tl_member.id,lastname,firstname,country from tl_groupdata,tl_instrument, tl_member WHERE tl_instrument.id = g_code AND tl_instrument.i_id = tl_member.id AND g_datum >= ? AND g_datum <= ? AND tl_instrument.id = ? ORDER by g_datum, g_code, g_ut, g_nr';
    }
        
    $result = $db->executeQuery($sql, array($intvl1,$intvl2,$code))->fetchAll();
//$num_fields = mysql_num_fields($result);
        
// Filename with current date
    $current_date = date("y/m/d");
    if($typ==0){
            $filename = "Dailydata_".$intvl1."-".$intvl2.".csv";
        }else{
            $filename = "Groupdata_".$intvl1."-".$intvl2.".csv";
        }
    //echo $filename;
        //var_dump($res);
// Open php output stream and write headers
    $fp = fopen('php://output', 'w');
    if ($fp && $result) {
    header('Content-Type: text/csv; charset=utf-8');
    header("Content-Disposition: attachment; filename=".$filename);  header("Expires: 0");
/*header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=".$filename);  header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);*/

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

// Löschanfrage > anschliessend showresults auf 1 setzen, damit Daten wieder ausgegeben werden.
        if($_REQUEST['del']==1){
                $deldate = $_REQUEST['deldate'];
                $icode = $_REQUEST['inst'];
                $d_id = $_REQUEST['id'];
                $showresult = 1;
				if($_REQUEST['typ']==0){ //nur daily löschen
					   $sql = "DELETE from tl_data WHERE id = ?";
                        $stmt = $db->prepare($sql);
                        $stmt->bindValue(1, $d_id);
                        //echo $d_id;
                        $stmt->execute();
				} else { //group und daily löschen
                    //id=23685&inst=503&deldate=2020-09-08&datefr=01.09.2020&dateto=30.09.2020&typ=1&showresults=1
                        
                        $sql = "DELETE from tl_groupdata WHERE g_code = ? AND g_datum = ?";
                        $stmt = $db->prepare($sql);
                        $stmt->bindValue(1, $icode);
                        $stmt->bindValue(2, $deldate);
                        //echo $deldate;
                        $stmt->execute();
                        $sql = "DELETE from tl_data WHERE d_code = ? AND d_datum = ?";
                        $stmt = $db->prepare($sql);
                        $stmt->bindValue(1, $icode);
                        $stmt->bindValue(2, $deldate);
                        //$stmt->execute();
				}		
			}
// Ergebnisse auf Bildschirm ausgeben		
if($_REQUEST['showresults']){ //nur wenn Resultatperiode angefragt wird
				if($_REQUEST['inst']){
					$instcode=$_REQUEST['inst'];
				} else {
					echo "Error: Kein Instrument gewählt ...";
				}
			
			
			$sql="SELECT *, tl_instrument.id as inid from tl_instrument, tl_member WHERE tl_instrument.id = ? AND tl_member.id = i_id";

			$result = $db->executeQuery($sql, array($instcode))->fetch();

			$this->Template->instcode = $result['inid'];
			$this->Template->i_id = $result['i_id'];
            $this->Template->i_aperture = $result['i_aperture'];
            $this->Template->i_focal_length = $result['i_focal_length'];
            $this->Template->i_filter = $result['i_filter'];
            $this->Template->i_method = $result['i_method'];
            $this->Template->i_magnification = $result['i_magnification'];
            $this->Template->i_projection = $result['i_projection'];
            $this->Template->i_inputpref = $result['i_inputpref'];
			$inputpref= $result['i_inputpref'];
			//Wurde ein Monat gewählt > Zeitspanne = gewählter Monat
			if($_REQUEST['mo']>0){
				$mo = $_REQUEST['mo'];
				$yr = $_REQUEST['yr'];
				$intvl1 = date('Y-m-d',mktime(0,0,0,$mo,1,$yr));
				$intvl2 = date('Y-m-t',mktime(0,0,0,$mo,1,$yr));
				} else {   //kein Monat gewählt => Zeitspanne ist spezifiziert
					if(isset($intvl1)){
				} else {

					$intvl01 = explode(".",$_REQUEST['datefr']);
					$intvl1 = $intvl01[2]."-".$intvl01[1]."-".$intvl01[0];

				}
				if(isset($intvl2)){
				} else {
					$intvl02 = explode(".",$_REQUEST['dateto']);
					$intvl2 = $intvl02[2]."-".$intvl02[1]."-".$intvl02[0];
				}
				}
                			//Datengrenze zum editieren
			$tlim = date("Y-m-01", strtotime("-1 month"));
			$tlim2 = date("Y-m-01");
			$tlim3 = date("2013-12-31");
			
			//echo $tlim." ".$tlim2;
			$this->Template->intvl1 = $intvl1;
			$this->Template->intvl2 = $intvl2;
			$this->Template->tlim = $tlim;
			$this->Template->tlim2 = $tlim2;
			$this->Template->tlim3 = $tlim3;
			$this->Template->showresults = 1;
        
// DAten für Ausgabe bereitstellen
// DATEN DAILY > nur wenn inputpref 1 oder 2
            if($inputpref==1 || $inputpref==2){
            $sql='SELECT * from tl_data WHERE d_datum >= ? AND d_datum <= ? AND d_code= ? ORDER by d_datum';
            $result = $db->executeQuery($sql, array($intvl1,$intvl2,$instcode))->fetchAll();
            foreach($result as $re){
                $ddata[] = array(
                    'd_id' => $re['id'],
                    'd_datum' => $re['d_datum'],
                    'd_ut' => $re['d_ut'],
                    'd_q' => $re['d_q'],
                    'd_flecken' => $re['d_flecken'],
                    'd_gruppen' => $re['d_gruppen'],
                    'd_A' => $re['d_A'],
                    'd_B' => $re['d_B'],
                    'd_C' => $re['d_C'],
                    'd_D' => $re['d_D'],
                    'd_E' => $re['d_E'],
                    'd_F' => $re['d_F'],
                    'd_G' => $re['d_G'],
                    'd_H' => $re['d_H'],
                    'd_J' => $re['d_J']
                );
            }
            $this->Template->ddata = $ddata;
            }
// DATEN FÜR GROUPS
            if($inputpref>2){
            $sql='SELECT * from tl_groupdata WHERE g_datum >= ? AND g_datum <= ? AND g_code= ? ORDER by g_datum';
            $gresult = $db->executeQuery($sql, array($intvl1,$intvl2,$instcode))->fetchAll();
            foreach($gresult as $re){
                $dsql='SELECT * from tl_data WHERE d_datum = ?';
                $dresult = $db->executeQuery($dsql, array($re['g_datum']))->fetch();
                $gdata[] = array(
                    'id' => $re['id'],
                    'g_datum' => $re['g_datum'],
                    'g_ut' => $re['g_ut'],
                    'g_q' => $re['g_q'],
                    'g_f' => $re['g_f'],
                    'g_Zpd' => $re['g_Zpd'],
                    'g_nr' => $re['g_nr'],
                    'g_p' => $re['g_p'],
                    'g_s' => $re['g_s'],
                    'g_sector' => $re['g_sector'],
                    'g_A' => $re['g_A'],
                    'g_pos' => $re['g_pos'],
                    'd_gruppen' => $dresult['d_gruppen'],
                    'd_flecken' => $dresult['d_flecken'],
                    'd_A' => $dresult['d_A'],
                    'd_B' => $dresult['d_B'],
                    'd_C' => $dresult['d_C'],
                    'd_D' => $dresult['d_D'],
                    'd_E' => $dresult['d_E'],
                    'd_F' => $dresult['d_F'],
                    'd_G' => $dresult['d_G'],
                    'd_H' => $dresult['d_H'],
                    'd_J' => $dresult['d_J'],
                );
            }
            $this->Template->gdata = $gdata;
            }
   // }
			
            
    


} else {		
//Weder csv-Ausgabe noch Bildschirmdarstellung angefordert > Alle Instrumente zur Auswahl abrufen
        $qsql='SELECT *, tl_instrument.id as inid from tl_instrument, tl_member WHERE tl_member.id = ? AND i_id = tl_member.id AND i_inputpref > ? ORDER BY tl_instrument.id';
			$resultall2 = $db->executeQuery($qsql, array($userid, 0))->fetchAll();
            $instArray = array();
            foreach($resultall2 as $result)
        {
            $inst3Array[] = array
		(
			'id' => $result['inid'],
			'i_id' => $result['i_id'],
            'i_type' => $result['i_type'],
            'i_aperture' => $result['i_aperture'],
            'i_focal_length' => $result['i_focal_length'],
            'i_filter' => $result['i_filter'],
            'i_method' => $result['i_method'],
            'i_magnification' => $result['i_magnification'],
            'i_projection' => $result['i_projection'],
            'i_inputpref' => $result['i_inputpref'],
                );
        }
        $this->Template->allinstr = $inst3Array;
    }
	}
}
