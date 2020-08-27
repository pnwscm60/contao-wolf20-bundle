<?php
 
class ModuleWolfEntry0 extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_wolfentry0';
 
public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['wolfentry0'][0]) . ' ###';
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
		
		$dailysave=0;
$groupsave=0;
if($_REQUEST['etyp']=="d"){  // für daily
// Hier fehlt noch die serverseitige Datenkontrolle!
$code=$_REQUEST["code"];
$ddat=$_REQUEST["datedef"];
$dat=preg_split("/[.]+/", $ddat);
$datum=$dat[2]."-".$dat[1]."-".$dat[0];
$ut=$_REQUEST["UT"];
$qu=$_REQUEST["qu"];
$g=$_REQUEST["g"];
$f=$_REQUEST["f"];
$A=$_REQUEST["A"];
$B=$_REQUEST["B"];
$C=$_REQUEST["C"];
$D=$_REQUEST["D"];
$E=$_REQUEST["E"];
$F=$_REQUEST["F"];
$G=$_REQUEST["G"];
$H=$_REQUEST["H"];
$J=$_REQUEST["J"];
	echo "Q==".$_REQUEST['qu'];
// Dublettenabfrage für daily : gibt es datensatz mit == ut == code und ==date?
	//parse date
	$sql = "SELECT * from tl_data WHERE d_datum='".$datum."' AND d_ut = ".$ut." AND d_code=".$code;
	$dosql = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($dosql)>0){
		// Achtung: Dublette
		echo "dublette";
		$du=1;
		echo "<script language=javascript>location.assign('instrument.html?du=1');</script>";	
		break;
	}

if($J==""){
	$sql="INSERT INTO tl_data ( d_code, d_datum, d_ut, d_q, d_gruppen, d_flecken ) VALUE ( $code, '$datum', $ut, $qu, $g, $f );";
	} else {
$sql="INSERT INTO tl_data ( d_code, d_datum, d_ut, d_q, d_gruppen, d_flecken, d_A, d_B, d_C, d_D, d_E, d_F, d_G, d_H, d_J ) VALUE ( $code, '$datum', $ut, $qu, $g, $f, $A, $B, $C, $D, $E, $F, $G, $H, $J );";
	}
$eintrag=mysql_query($sql);
	if($eintrag){
		$dailysave=1;
	}
//echo $sql;

} elseif($_REQUEST['etyp']=="g"){ // für group-Daten
$sA=0;
$sB=0;
$sC=0;
$sD=0;
$sE=0;
$sF=0;
$sG=0;
$sH=0;
$sJ=0;
$sff=0;

// für jede Gruppe vollen eintrag erstellen > grunddaten

$code=$_REQUEST["code"];
$ddat=$_REQUEST["datum"];
$dat=preg_split("/[.]+/", $ddat);
$datum=$dat[2]."-".$dat[1]."-".$dat[0];
$ut=$_REQUEST["UT"];
$qu=$_REQUEST["qu"];
$g=$_REQUEST["g"];
// jetzt alle arrays einlesen
	$f = array();
	$f = $_REQUEST['f'];
	$zpd = array();
	$zpd = $_REQUEST['zpd'];
	$p = array();
	$p = $_REQUEST['pp'];
	$s = array();
	$s = $_REQUEST['ss'];
	$sect = array();
	$sect = $_REQUEST['sect'];
	$a = array();
	$a = $_REQUEST['a'];
	$ah = array();
	$ah = $_REQUEST['ah'];
	$pos = array();
	$pos = $_REQUEST['pos'];
//soviele schlaufen durchlaufen wie einträge in den arrays da sind
$i=0;
if($f[$i]==NULL){
	$sql="INSERT INTO tl_groupdata ( g_datum, g_code, g_nr, g_ut, g_q, g_f, g_p, g_s, g_A ) VALUES ( '$datum', $code, 0, $ut, $qu, 0, 0, 0, 0);";
//echo $sql."<br/>";
	$eintrag=mysql_query($sql) or die(mysql_error());
		if($eintrag){
		$groupsave=1;
		}
//tlim bestimmen
$part = explode(".",$datum);
//echo $ht." ";
$at = mktime(0,0,0,intval($dat[1]),intval($dat[0]),intval($dat[2]));
//echo $at;
if($dat[1]==1){
	$lt = mktime(0,0,0,12,1,(date("Y")-1));
	$lt2 = mktime(0,0,0,1,1,date("Y"));
} else {
	$lt = mktime(0,0,0,(date("n")-1),1,date("Y"));
	$lt2 = mktime(0,0,0,date("n"),1,date("Y"));
}
if(date("j")>15){
	$lt=$lt2;
}

//
if($at >= $lt){
$sqld="INSERT INTO tl_data ( d_code, d_datum, d_ut, d_q, d_gruppen, d_flecken, d_A, d_B, d_C, d_D, d_E, d_F, d_G, d_H, d_J ) VALUE ( $code, '$datum', $ut, $qu, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 );";
	if($_SESSION['autosave']=="on"){
		//$eintrag=mysql_query($sqld) or die(mysql_error());
			if($eintrag){
				$dailysave=1;
			}
		}
	}
} else {
while($f[$i]<>NULL){
	$nr = $i+1;
	$f[$i] = $f[$i]=='' ? NULL : $f[$i];
	$zpd[$i] = $zpd[$i]=='' ? NULL : $zpd[$i];
	$p[$i] = $p[$i]=='' ? NULL : $p[$i];
	$s[$i] = $s[$i]=='' ? NULL : $s[$i];
	$sect[$i] = $sect[$i]=='' ? NULL : $sect[$i];
	$a[$i] = $a[$i]=='' ? 99 : $a[$i];
	$ah[$i] = $ah[$i]=='' ? 99 : $ah[$i];
// Summation rechnen

$sff=$sff+$f[$i];
switch($zpd[$i]){
case "Axx":
case "Axi":
	$sA=$sA+1;
	break;
case "Bxi":
case "Bxo":
	$sB=$sB+1;
	break;
case "Cri":
case "Csi":
case "Cai":
case "Chi":
case "Cki":
case "Cro":
case "Cso":
case "Cao":
	$sC=$sC+1;
	break;
case "Dri":
case "Dro":
case "Dsi":
case "Dsc":
case "Dso":
case "Dai":
case "Dac":
case "Dao":
case "Dhi":
case "Dhc":
case "Dki":
case "Dkc":
	$sD=$sD+1;
	break;
case "Eri":
case "Esi":
case "Esc":
case "Eai":
case "Eac":
case "Ehi":
case "Ehc":
case "Eki":
case "Ekc":
	$sE=$sE+1;
	break;
case "Fri":
case "Fsi":
case "Fsc":
case "Fai":
case "Fac":
case "Fhi":
case "Fhc":
case "Fki":
case "Fkc":
	$sF=$sF+1;
	break;
case "Cho":
case "Cko":
case "Dho":
case "Dko":
case "Ero":
case "Eso":
case "Eao":
case "Eho":
case "Eko":
case "Fro":
case "Fso":
case "Fao":
case "Fho":
case "Fko":
	$sG=$sG+1;
	break;
case "Hhx":
case "Hhi":
case "Hhc":
case "Hkx":
case "Hki":
case "Hkc":
	$sH=$sH+1;
	break;
case "Hrx":
case "Hri":
case "Hrc":
case "Hsx":
case "Hsi":
case "Hsc":
case "Hax":
case "Hai":
case "Hac":
	$sJ=$sJ+1;
	break;
}

//jetzt eintragen
$sql="INSERT INTO tl_groupdata ( g_datum, g_code, g_nr, g_ut, g_q, g_f, g_Zpd, g_p, g_s, g_sector";
if($a[$i]!=99){
	$sql.=", g_A";
}
if($pos[$i]!=99){
	$sql.=", g_pos";	
}
$sql.=" ) VALUES ( '$datum', $code, $nr, $ut, $qu, $f[$i], '$zpd[$i]', $p[$i], $s[$i], $sect[$i]";
if($a[$i]!=99){
$sql.=", $a[$i]";
}
if($pos[$i]!=99){
	$sql.=", '$pos[$i]'";	
}

$sql.=" );";
//echo "Q=".$_REQUEST['qu'];
//echo $sql."<br/>";
$i=$i+1;
$eintrag=mysql_query($sql) or die(mysql_error());
if($eintrag){
	$groupsave=1;
	}

}
}


//Print out Summation

$prstring='
<div class="boo" style="width:5em;">Datum</div>
<div class="bo">UT</div>
<div class="bo">q</div>
<div class="bo">g</div>
<div class="bo">f</div>
<div class="bo">A</div>
<div class="bo">B</div>
<div class="bo">C</div>
<div class="bo">D</div>
<div class="bo">E</div>
<div class="bo">F</div>
<div class="bo">G</div>
<div class="bo">H</div>
<div class="bo" style="clear:both;">J</div>
<div class="buu" style="width:5em;">'.$datum.'</div>
<div class="bu">'.$ut.'</div>
<div class="bu">'.$q.'</div>
<div class="bu">'.$i.'</div>
<div class="bu">'.$sff.'</div>
<div class="bu">'.$sA.'</div>
<div class="bu">'.$sB.'</div>
<div class="bu">'.$sC.'</div>
<div class="bu">'.$sD.'</div>
<div class="bu">'.$sE.'</div>
<div class="bu">'.$sF.'</div>
<div class="bu">'.$sG.'</div>
<div class="bu">'.$sH.'</div>
<div class="bu" style="clear:both;">'.$sJ.'</div>';
//echo $prstring;
//tlim bestimmen
$part = explode(".",$datum);
//echo $ht." ";
$at = mktime(0,0,0,intval($dat[1]),intval($dat[0]),intval($dat[2]));
//echo $at;
if($dat[1]==1){
	$lt = mktime(0,0,0,12,1,(date("Y")-1));
	$lt2 = mktime(0,0,0,1,1,date("Y"));
} else {
	$lt = mktime(0,0,0,(date("n")-1),1,date("Y"));
	$lt2 = mktime(0,0,0,date("n"),1,date("Y"));
}
if(date("j")>15){
	$lt=$lt2;
}
	
if($at >=$lt){
$sqld="INSERT INTO tl_data ( d_code, d_datum, d_ut, d_q, d_gruppen, d_flecken, d_A, d_B, d_C, d_D, d_E, d_F, d_G, d_H, d_J ) VALUE ( $code, '$datum', $ut, $qu, $g, $sff, $sA, $sB, $sC, $sD, $sE, $sF, $sG, $sH, $sJ );";
//if($_SESSION['autosave']=="on"){
	$eintrag=mysql_query($sqld) or die(mysql_error());
	echo $sql;
if($eintrag){
	$dailysave=1;
	}
}
}
//}

$this->Template->dailysave = $dailysave;
$this->Template->groupsave = $groupsave;
$this->Template->du = $_REQUEST['du'];
$this->Template->inst = $_REQUEST['inst'];
	
		
	}
}
