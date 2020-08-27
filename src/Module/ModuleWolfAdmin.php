<?php
 
class ModuleWolfAdmin extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_wolfadmin';
 
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
	
		
	if($_REQUEST['ued']==1){	
		if($_REQUEST['save']==1){
			$sql = "UPDATE tl_member SET lastname = '".$_REQUEST['lastname']."', firstname = '".$_REQUEST['firstname']."', city = '".$_REQUEST['city']."', country = '".$_REQUEST['country']."', yearOfBirth = ".$_REQUEST['jg'].", email='".$_REQUEST['email']."' WHERE id=?";

			$this->Database->prepare($sql)->execute($_REQUEST['id']);
			$this->Template->saveok = 1;
		}	
		
		$this->import('Database');
		$sql="SELECT * from tl_member ORDER by lastname,firstname";
		$res = Database::getInstance()->query($sql);
		//echo $sql;
		while ($res->next()){
		
			$alluser[] = array
				(
					'id' => $res->id,
					'lastname' => specialchars($res->lastname),
					'firstname' => specialchars($res->firstname),
					'city' => specialchars($res->city),
					'email' => specialchars($res->email),
					'role' => specialchars($res->role),
					'country' => $res->country,
					'yearOfBirth' => $res->yearOfBirth
				);
		 }
		$this->Template->user = $alluser;
		$this->Template->ued = 1;
	}
		
		if($_REQUEST['ied']==1){
			
			if($_REQUEST['save']==1){
				$sql = "UPDATE tl_instrument SET i_type = '".$_REQUEST['type']."', i_aperture = ".$_REQUEST['apert'].", i_focal_length = ".$_REQUEST['focal'].", i_filter = '".$_REQUEST['filter']."', i_method = '".$_REQUEST['method']."', i_magnification =".$_REQUEST['magn'].", i_projection = ".$_REQUEST['proj'].", i_inputpref = ".$_REQUEST['input']." WHERE id=?";
				echo $sql;
				$this->Database->prepare($sql)->execute($_REQUEST['id']);
				$this->Template->saveok = 1;
			}	
			
		$this->import('Database');
		$sql="SELECT tl_instrument.id, i_id, i_type, i_aperture, i_focal_length, i_filter, i_method, i_magnification, i_projection, i_inputpref, concat(lastname, ' ', LEFT(firstname,1),'.') as name FROM tl_instrument, tl_member WHERE tl_member.id=i_id ORDER by tl_instrument.id";
		$res = Database::getInstance()->query($sql);
		//echo $sql;
		while ($res->next()){
		
			$allinst[] = array
				(
					'id' => $res->id,
					'us' => $res->i_id,
					'name' => $res->name,
					'type' => $res->i_type,
					'apert' => $res->i_aperture,
					'focal' => $res->i_focal_length,
					'filter' => $res->i_filter,
					'method' => $res->i_method,
					'magn' => $res->i_magnification,
					'proj' => $res->i_projection,
					'input' => $res->i_inputpref,
				);
		 }
		$this->Template->inst = $allinst;
		$this->Template->ied = 1;
	}	
		
	if($_REQUEST['us-ex']==1){
		//ob_end_clean();
		// sql-statement
		$sql='SELECT * from tl_member ORDER by lastname,firstname ASC';
		echo $sql.'<br/>';
		$this->import('Database');
		$res = $this->Database->prepare($sql)->execute();
		
		$current_date = date("y/m/d");
		$filename = "User_".$current_date.".xls";

		// Open php output stream and write headers
		$fp = fopen('php://output', 'w');
		if ($fp && $res) {
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=".$filename);  header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);

			//Kopfzeile schreiben
			echo "id \t name \t firstname \t city \t country \t email \t role \t y.o.b. \n";
			//Zeilen ausgeben
			while ($res->next()){
			echo $res->id."\t".utf8_decode($res->lastname)."\t".utf8_decode($res->firstname)."\t".utf8_decode($res->city)."\t".utf8_decode($res->country)."\t".utf8_decode($res->email)."\t".utf8_decode($res->role)."\t".$res->yearOfBirth."\n";
			}
		}
			die;
	}
		
if($_REQUEST['upload']==1){
	$message = null;
	$allowed_extensions = array('csv');
	$upload_path = 'files/institute/upload/';
	if (!empty($_FILES['file'])) {
		if ($_FILES['file']['error'] == 0) {
			// check extension
			$file = explode(".", $_FILES['file']['name']);
			$extension = array_pop($file);
			if (in_array($extension, $allowed_extensions)) {
				if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path.'/'.$_FILES['file']['name'])) {	
				$filename = $upload_path.$_FILES['file']['name'];
				//$filename = $_FILES['file']['name'];
				$file = fopen($filename, "r");
	if ($file==false) {
		echo "file don't exists";
		exit;
	} else {
		//echo "file existiert";
	}
	$i=0;
	while (!feof ($file)) {
		$line = fgets ($file);
		/* This only works if the title and its tags are on one line */
		//Zeile in Array einlesen
		$ele[$i] = preg_split('/;/ ',$line);
		//echo $ele[$i][0]." ";
		$i=$i+1;	
	}
	fclose($file);
	//echo "end of file ";
	// Alle erlaubten Codes in array einlesen
	$sql="SELECT id from tl_instrument";
	$database = \Database::getInstance();
	$dosql = $database->query($sql) or die(mysql_error());
		//$dosql=mysql_query($sql) or die(mysql_error());
		$allcodes=array();
		$z=0;
		while($dosql->next()) 
		{ 
			$allcodes[$z]=$dosql->id;
			$z=$z+1;
		}
	
	//echo $allcodes[0]." ".$allcodes[1]." ".$allcodes[3]." ";
	//Zuerst ein Leerdurchlauf > Code prüfen: Falls ein Code nicht gültig > ganzen Upload abbrechen
	//Meldung zurückgeben: ungültiger Code > Codes manuell prüfen
	$k=0;
	//echo count($ele);
	$ct=count($ele);
	while($k!=$ct){
		if(preg_match("/[\d]/", $ele[$k][4])&&preg_match("/[\d]/", $ele[$k][5])){ //Datenzeile -> prüfen
			if(in_array($ele[$k][0],$allcodes)){
				// Nichts tun > Skript weiter ausführen
			} else {
			// Message auf Error setzen > Skript abbrechen
			//echo $ele[$k][0]." ";
			$uploaderror = "Unknown instrument code in input file, please check instrument codes in input file! First false code found: ".$ele[$k][0]." on line ".$k.". Upload has been stopped, no data have been saved.";
			return;	
			}
			//Testen ob Waldmeier-Einträge vorhanden, obwohl nicht Typ 2 > in diesem Fall abbrechen
			$twal = "SELECT i_inputpref from tl_instrument WHERE id = ".$ele[$k][0];
			//echo $twal;
			$database = \Database::getInstance();
			$testwal = $database->query($twal);
			//echo $testwal->i_inputpref;
			//$dotwal = mysql_query($twal) or die(mysql_error());
			//$testwal = mysql_fetch_row($dotwal);
			//echo $testwal[0]."/".$ele[$k][6]."/".$ele[$k][7]."/".$ele[$k][8]."/".$ele[$k][9]."/".$ele[$k][10]."/".$ele[$k][11]."/".$ele[$k][12]."/".$ele[$k][13]."/".$ele[$k][14]."<br/>";
			if($testwal->i_inputpref!=2&&($ele[$k][6]!=''||$ele[$k][7]!=''||$ele[$k][8]!=''||$ele[$k][9]!=''||$ele[$k][10]!=''||$ele[$k][11]!=''||$ele[$k][12]!=''||$ele[$k][13]!=''||$ele[$k][14]!='')){
			//if($testwal[0]!=2){echo "typ ungleich 2<br/>";}
			//if($ele[$k][6]!=''||$ele[$k][14]!=''){echo "da ist ein wurm drin  ";}
			//if($ele[$k][6]!=''||$ele[$k][7]!=''||$ele[$k][8]!=''||$ele[$k][9]!=''||$ele[$k][10]!=''||$ele[$k][11]!=''||$ele[$k][12]!=''||$ele[$k][13]!=''||$ele[$k][14]!=''){echo "da ist ein waldmeier drin";}
			//echo $testwal[0]."/".$ele[$k][6]."/".$ele[$k][7]."/".$ele[$k][8]."/".$ele[$k][9]."/".$ele[$k][10]."/".$ele[$k][11]."/".$ele[$k][12]."/".$ele[$k][13]."/".$ele[$k][14]."<br/>";
				// Message auf Error setzen > Skript abbrechen
			$uploaderror ="Instrument type mismatch error - please check instrument codes in input file! First false code found: ".$ele[$k][0]." on line ".$k.". Upload has been stopped, no data have been saved.";
				return;
			} 
		}
	$k=$k+1;	
	}

	//Länge des Arrays auslesen
	$i=0;
	$arlo=count($ele);
	while($i!=$arlo){
		if(preg_match("/[\d]/", $ele[$i][4])&&preg_match("/[\d]/", $ele[$i][5])){ //Datenzeile > Eintrag
	$rdat = explode(".",$ele[$i][1]);
	if($rdat[2]>99){
		$jahr=$rdat[2];
		} else {
		$jahr=2000+$rdat[2];	
		}
	$ndat = $jahr."-".$rdat[1]."-".$rdat[0];
	if($ele[$i][6]!=''||$ele[$i][7]!=''||$ele[$i][8]!=''||$ele[$i][9]!=''||$ele[$i][10]!=''||$ele[$i][11]!=''||$ele[$i][12]!=''||$ele[$i][13]!=''||$ele[$i][14]!=''){
		$nflag = 1; // falls ein Wert fehlt > 0 setzen, da beobachet wurde
	} else {
		$nflag = 0; // alle Werte leer > NULL eintragen
	}

	$twald = "SELECT i_inputpref from tl_instrument WHERE id = ".$ele[$i][0];
	$database = \Database::getInstance();
	$testwald = $database->query($twald);
			
	$dotwald = mysql_query($twald) or die(mysql_error());
	$testwald = mysql_fetch_row($dotwald);
	if($testwald->inputpref==2){ 
			$nflag = 1; // falls ein Wert fehlt > 0 setzen, da beobachet wurde
	} else {
		$nflag = 0; // alle Werte leer > NULL eintragen
	}

	
	$sql="INSERT INTO tl_data (`d_code`, `d_datum`, `d_ut`, `d_q`, `d_gruppen`, `d_flecken` ";
	if($ele[$i][6]!=''){
		$sql.=",d_A ";
		} else { // d_A ist leer
			if($nflag==1){
				$sql.=",d_A ";
				}
		}
	if($ele[$i][7]!=''){
		$sql.=",d_B ";
		} else { // d_B ist leer
			if($nflag==1){
				$sql.=",d_B ";
				}
		}
	if($ele[$i][8]!=''){
		$sql.=",d_C ";
		} else { // d_C ist leer
			if($nflag==1){
				$sql.=",d_C ";
				}
		}
	if($ele[$i][9]!=''){
		$sql.=",d_D ";
		} else { // d_D ist leer
			if($nflag==1){
				$sql.=",d_D ";
				}
		}
	if($ele[$i][10]!=''){
		$sql.=",d_E ";
		} else { // d_E ist leer
			if($nflag==1){
				$sql.=",d_E ";
				}
		}
	if($ele[$i][11]!=''){
		$sql.=",d_F ";
		} else { // d_F ist leer
			if($nflag==1){
				$sql.=",d_F ";
				}
		}
	if($ele[$i][12]!=''){
		$sql.=",d_G ";
		} else { // d_G ist leer
			if($nflag==1){
				$sql.=",d_G ";
				}
		}
	if($ele[$i][13]!=''){
		$sql.=",d_H ";
		} else { // d_H ist leer
			if($nflag==1){
				$sql.=",d_H ";
				}
		}
	if($ele[$i][14]!=''){
		$sql.=",d_J ";
		} else { // d_J ist leer
			if($nflag==1){
				$sql.=",d_J ";
				}
		}
	$sql.=") VALUES ( ".$ele[$i][0].", '".$ndat."', ".$ele[$i][2].", ".$ele[$i][3].", ".$ele[$i][4].", ".$ele[$i][5];
	if($ele[$i][6]!=''){
		$sql.=", ".$ele[$i][6];
		} else { // d_A ist leer
			if($nflag==1){
				$sql.=", 0";
				}
		}
	if($ele[$i][7]!=''){
		$sql.=", ".$ele[$i][7];
		} else { // d_B ist leer
			if($nflag==1){
				$sql.=", 0";
				}
		}
	if($ele[$i][8]!=''){
		$sql.=", ".$ele[$i][8];
		} else { // d_C ist leer
			if($nflag==1){
				$sql.=", 0";
				}
		}
	if($ele[$i][9]!=''){
		$sql.=", ".$ele[$i][9];
		} else { // d_D ist leer
			if($nflag==1){
				$sql.=", 0";
				}
		}
	if($ele[$i][10]!=''){
		$sql.=", ".$ele[$i][10];
		} else { // d_E ist leer
			if($nflag==1){
				$sql.=", 0";
				}
		}
	if($ele[$i][11]!=''){
		$sql.=", ".$ele[$i][11];
		} else { // d_F ist leer
			if($nflag==1){
				$sql.=", 0";
				}
		}
	if($ele[$i][12]!=''){
		$sql.=", ".$ele[$i][12];
		} else { // d_G ist leer
			if($nflag==1){
				$sql.=", 0";
				}
		}
	if($ele[$i][13]!=''){
		$sql.=", ".$ele[$i][13];
		} else { // d_H ist leer
			if($nflag==1){
				$sql.=", 0";
				}
		}
	if($ele[$i][14]!=''){
		$sql.=", ".$ele[$i][14];
		} else { // d_J ist leer
			if($nflag==1){
				$sql.=", 0";
				}
		}	
	$sql.=");";
			
	//Vor jedem Eintrag = Dublettenprüfung: Gleicher Code Datum Uhrzeit
	$sqlt="SELECT id from tl_data WHERE d_datum = '$ndat' AND d_code = ".$ele[$i][0]." AND d_ut = ".$ele[$i][2].";";
	//echo $sqlt."<br/>";
	$database = \Database::getInstance();
	$test = $database->query($sqlt);
			
	//$dosql = mysql_query($sqlt) or die(mysql_error());
	//$test=mysql_fetch_row($dosql);
	if($test->id!=''){
		$uploaderror= 'We found some dublettes in your data. These datasets have not been saved.';
	} else {
	$database = \Database::getInstance();
	$doit = $database->query($sql) or die(mysql_error());
	//echo $sql."<br/>";
	}
		}
	$i=$i+1;
	}
				}
			} else {
				$message = '<span class="red">Only .csv file format is allowed</span>';
			}

		} else {
			$message = '<span class="red">There was a problem with your file</span>';
		}

	}
	$this->Template->uploaderror = $uploaderror;
	$this->Template->message = $message;
}		
		
		
if($_REQUEST['is-ex']==1){
		//ob_end_clean();
		// sql-statement
		$sql="SELECT tl_instrument.id, i_id, i_type, i_aperture, i_focal_length, i_filter, i_method, i_magnification, i_projection, i_inputpref, concat(lastname, ' ', LEFT(firstname,1),'.') as name FROM tl_instrument, tl_member WHERE tl_member.id=i_id ORDER by tl_instrument.id;";
		echo $sql.'<br/>';
		$this->import('Database');
		$res = $this->Database->prepare($sql)->execute();
		
		$current_date = date("y/m/d");
		$filename = "Instrument_".$current_date.".xls";

		// Open php output stream and write headers
		$fp = fopen('php://output', 'w');
		if ($fp && $res) {
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=".$filename);  header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);

			//Kopfzeile schreiben
			echo "id \t user \t name \t type \t aperture \t focal length \t filter \t method \t magnification \t projection \t input \n";
			//Zeilen ausgeben
			while ($res->next()){
			echo $res->id."\t".utf8_decode($res->name)."\t".$res->i_type."\t".$res->i_aperture."\t".$res->i_focal_length."\t".$res->i_filter."\t".$res->i_method."\t".$res->i_magnification."\t".$res->i_projection."\t".$res->i_inputpref."\n";
			}
		}
		
			die;
	}
	
		if($_REQUEST['showresults']==1){
			if($_REQUEST['mo']>0){
	//echo date("n");
	$mo = $_REQUEST['mo'];
	$yr = $_REQUEST['yer'];
	$intvl1 = date('Y-m-d',mktime(0,0,0,$mo,1,$yr));
	$intvl2 = date('Y-m-t',mktime(0,0,0,$mo,1,$yr));
	} else {   //kein Monat gewählt => Zeitspanne ist spezifiziert > datum parsen!
	$tmp1 = explode(".", $_REQUEST['datefr']);
	$tmp2 = explode(".", $_REQUEST['dateto']);
	$intvl1 = $tmp1[2].'-'.$tmp1[1].'-'.$tmp1[0];
	$intvl2 = $tmp2[2].'-'.$tmp2[1].'-'.$tmp2[0];
	}

			
			$typ = $_REQUEST['dtyp'];
			$this->Template->intvl1 = $intvl1;
			$this->Template->intvl2 = $intvl2;
			$this->Template->typ = $typ;
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
echo $sql.'<br/><br/>';
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
	echo '
<script>
	window.location.replace("https://www.wolfinstitute.ch/admin.html");
</script>';
	
	
	}
if($_REQUEST['radl']==1){ //nur wenn definitive Resultatausgabe angefragt		
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

// Collect Data from RWG repository
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
//ob_end_clean();
// produce results depending on typ
if($typ==0){
	$sql='SELECT d_datum,d_ut,d_q,d_gruppen,d_flecken,d_A,d_B,d_C,d_D,d_E,d_F,d_G,d_H,d_J, d_code,i_aperture,i_focal_length,i_filter,i_method,i_magnification,i_projection, tl_member.id,lastname,firstname,country from tl_data,tl_instrument,tl_member WHERE tl_instrument.id=d_code AND tl_instrument.i_id=tl_member.id AND d_datum >= "'.$intvl1.'" AND d_datum <= "'.$intvl2.'" ORDER by d_datum,d_code, d_ut ';
	} else {
	$sql='SELECT g_datum,g_ut,g_q,g_nr,g_f,g_Zpd,g_p,g_s,g_pos,g_sector,g_A, g_code,i_aperture,i_focal_length,i_filter,i_method,i_magnification,i_projection, tl_member.id,lastname,firstname,country from tl_groupdata,tl_instrument, tl_member WHERE tl_instrument.id = g_code AND tl_instrument.i_id = tl_member.id AND g_datum >= "'.$intvl1.'" AND g_datum <= "'.$intvl2.'" ORDER by g_datum, g_code, g_ut, g_nr';
	
}
echo $sql.'<br/><br/>';
$result=mysql_query($sql) or die(mysql_error());
$num_fields = mysql_num_fields($result);

// Filename with current date
$current_date = date("y/m/d");
if($typ==0){
		$filename = "Dailydata_".$intvl1."-".$intvl2.".xlsx";
	} else {
		$filename = "Groupdata_".$intvl1."-".$intvl2.".xlsx";
	}
	
	
	
	
/** Include PHPExcel */
ob_end_clean(); //delete all previous output
require_once 'files/script/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Rudolf Wolf Society")
							 ->setLastModifiedBy("Rudolf Wolf Society")
							 ->setTitle("Data Download from RWG")
							 ->setSubject("Data Download from RWG")
							 ->setDescription("")
							 ->setKeywords("")
							 ->setCategory("Data Download");

	//date \t UT \t Q \t g \t f \t A \t B \t C \t D \t E \t F \t G \t H \t J \t instr \t aperture \t foc \t filter \t method \t mag \t proj \t user \t lname \t fname \t country


	
switch ($typ) {
	case 0: // Write Daily Data
	// Add header
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'instr')
    ->setCellValue('B1', 'Date')
    ->setCellValue('C1', 'UT')
    ->setCellValue('D1', 'Q')
    ->setCellValue('E1', 'g')
	->setCellValue('F1', 'f')
	->setCellValue('G1', 'A')
	->setCellValue('H1', 'B')
	->setCellValue('I1', 'C')
	->setCellValue('J1', 'D')
	->setCellValue('K1', 'E')
	->setCellValue('L1', 'F')
	->setCellValue('M1', 'G')
	->setCellValue('N1', 'H')
	->setCellValue('O1', 'J')
	->setCellValue('P1', 'aperture')
	->setCellValue('Q1', 'foc')
	->setCellValue('R1', 'filter')
	->setCellValue('S1', 'method')
	->setCellValue('T1', 'mag')
	->setCellValue('U1', 'proj')
	->setCellValue('V1', 'user')
	->setCellValue('W1', 'lname')
	->setCellValue('X1', 'fname')
	->setCellValue('Y1', 'country');
		
	//Zeilen ausgeben
	$row = 1;
    while ($r = mysql_fetch_row($result)) {
		$dat = explode('-',$r[0]);
		$da = $dat[2].".".$dat[1].".".$dat[0];
    $row = $row+1;
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$row, $r[14])
	->setCellValue('B'.$row, $da)
    ->setCellValue('C'.$row, $r[1])
    ->setCellValue('D'.$row, $r[2])
    ->setCellValue('E'.$row, $r[3])
	->setCellValue('F'.$row, $r[4])
	->setCellValue('G'.$row, $r[5])
	->setCellValue('H'.$row, $r[6])
	->setCellValue('I'.$row, $r[7])
	->setCellValue('J'.$row, $r[8])
	->setCellValue('K'.$row, $r[9])
	->setCellValue('L'.$row, $r[10])
	->setCellValue('M'.$row, $r[11])
	->setCellValue('N'.$row, $r[12])
	->setCellValue('O'.$row, $r[13])
	->setCellValue('P'.$row, $r[15])
	->setCellValue('Q'.$row, $r[16])
	->setCellValue('R'.$row, $r[17])
	->setCellValue('S'.$row, $r[18])
	->setCellValue('T'.$row, $r[19])
	->setCellValue('U'.$row, $r[20])
	->setCellValue('V'.$row, $r[21])
	->setCellValue('W'.$row, $r[22])
	->setCellValue('X'.$row, $r[23])
	->setCellValue('Y'.$row, $r[24]);
    }
	break;

	case 1:
	//Kopfzeile schreiben
	//echo "date \t UT \t Q \t gnr \t f \t Zpd \t p \t s \t pos \t sect \t A \t instr \t aperture \t foc \t filter \t method \t mag \t proj \t user \t lname \t fname \t country \n";
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'instr')
    ->setCellValue('B1', 'Date')
    ->setCellValue('C1', 'UT')
    ->setCellValue('D1', 'Q')
    ->setCellValue('E1', 'gnr')
	->setCellValue('F1', 'f')
	->setCellValue('G1', 'Zpd')
	->setCellValue('H1', 'p')
	->setCellValue('I1', 's')
	->setCellValue('J1', 'pos')
	->setCellValue('K1', 'sect')
	->setCellValue('L1', 'A')
	->setCellValue('M1', 'aperture')
	->setCellValue('N1', 'foc')
	->setCellValue('O1', 'filter')
	->setCellValue('P1', 'method')
	->setCellValue('Q1', 'mag')
	->setCellValue('R1', 'proj')
	->setCellValue('S1', 'user')
	->setCellValue('T1', 'lname')
	->setCellValue('U1', 'fname')
	->setCellValue('V1', 'country');
	//Zeilen ausgeben
	$row = 1;
    while ($r = mysql_fetch_row($result)) {
		$dat = explode('-',$r[0]);
		$da = $dat[2].".".$dat[1].".".$dat[0];
    $row = $row+1;
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$row, $r[11])
	->setCellValue('B'.$row, $da)
    ->setCellValue('C'.$row, $r[1])
    ->setCellValue('D'.$row, $r[2])
    ->setCellValue('E'.$row, $r[3])
	->setCellValue('F'.$row, $r[4])
	->setCellValue('G'.$row, $r[5])
	->setCellValue('H'.$row, $r[6])
	->setCellValue('I'.$row, $r[7])
	->setCellValue('J'.$row, $r[8])
	->setCellValue('K'.$row, $r[9])
	->setCellValue('L'.$row, $r[10])
	->setCellValue('M'.$row, $r[12])
	->setCellValue('N'.$row, $r[13])
	->setCellValue('O'.$row, $r[14])
	->setCellValue('P'.$row, $r[15])
	->setCellValue('Q'.$row, $r[16])
	->setCellValue('R'.$row, $r[17])
	->setCellValue('S'.$row, $r[18])
	->setCellValue('T'.$row, $r[19])
	->setCellValue('U'.$row, $r[20])
	->setCellValue('V'.$row, $r[21]);
	//echo $r[0]."\t".$r[1]."\t".$r[2]."\t".$r[3]."\t".$r[4]."\t".$r[5]."\t".$r[6]."\t".$r[7]."\t".$r[8]."\t".$r[9]."\t".$r[10]."\t".$r[11]."\t".$r[12]."\t".$r[13]."\t".$r[14]."\t".$r[15]."\t".$r[16]."\t".$r[17]."\t".$r[18]."\t".utf8_decode($r[19])."\t".utf8_decode($r[20])."\t".$r[21]."\n";
    }
	break;
		
}	
// Miscellaneous glyphs, UTF-8
//$objPHPExcel->setActiveSheetIndex(0)
  //          ->setCellValue('A4', 'Miscellaneous glyphs')
    //        ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Daily '.$intvl1.' to '.$intvl2);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;		
}
	}
}
