<?php
namespace Pnwscm60\Wolf20Bundle\Module; 
class ModuleWolfEntry extends \Contao\Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_wolfentry';
 
public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### wolfentry ###';
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
	//Daten bereitstellen User > $userid
        $this->import('FrontendUser', 'User');
        $userid = $this->User->id;

//Informationen zum Observer
        $qsql='SELECT * from tl_member WHERE id = ?';
        $mresult = $db->executeQuery($qsql, array($userid))->fetch();
        $this->Template->observer = $mresult['id'];
        $this->Template->lname = $mresult['lastname'];
        $this->Template->fname = $mresult['firstname'];
        $this->Template->city = $mresult['city'];
        $this->Template->country = strtoupper($mresult['country']);
        
//STEP0 Instrument + Datum > ergibt Abfragetyp        
//Abfrage alle Instrumente > Auswahl des Instruments ==> bestimmt Beobachtungsart
        if($_REQUEST['step1']!=1&&$_REQUEST['step2']!=1){
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
        $this->Template->step0 = 1;
        }
        
//STEP1 Instrument is chosen > check inputpref > daily or group entry? 
//Check for other entry on this day for this instrument > Warn and cancel.
//Daily -> go directly to STEP2
//Group -> enter time, group count and quality
      if($_REQUEST['step1']==1){
//inputpref of the chosen instrument
          if($_REQUEST['inst']){$instrid = $_REQUEST['inst'];}
          $isql='SELECT * from tl_instrument WHERE id = ?';
          $iresult = $db->executeQuery($isql, array($instrid))->fetchAll();
          foreach($iresult as $result)
        {
            $inst4Array[] = array
		(
			'id' => $result['id'],
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
            $inputpref = $result['i_inputpref'];
        }
          
//inputpref 0 > not activated > Message, that no observation possible with this instrument before activation
          if($inputpref == 0){
              $this->Template->warning = "This instrument is not activated. You have to activate this instrument <a href='instedit.html'>here</a> to enter an observation with this instrument.";
              $this->Template->step1 = 1;
          }
//inputpref 1||2 -> check, if dublette in tl_data (daily)
          if($inputpref == 1||$inputpref == 2){
              if($_REQUEST['inst']){$code = $_REQUEST['inst'];}
              if($_REQUEST['cdate']){$cdate = $_REQUEST['cdate'];}
              
              $dat=preg_split("/[-]+/", $cdate);
              $datum=$dat[2].".".$dat[1].".".$dat[0];
              $dsql = "SELECT * from tl_data WHERE d_datum = ? AND d_code = ?";
              
              $dresult = $db->executeQuery($dsql, array($cdate,$code))->fetch();
              //var_dump($dresult);
              if(empty($dresult)){ //Bereits Datensatz vorhanden > Warnmeldung und Abbruch
                  
                  $this->Template->input = $inputpref;
                  $this->Template->inst = $inst4Array;
                  $this->Template->instcode = $instrid;
                  
                  $this->Template->cdate = $datum;
                  $this->Template->step2 = 1;
                  $this->Template->step1 = 0;
              } else {
                $this->Template->warning = "We found an entry in daily observations for this date and this instrument. Only one observation/day/instrument is allowed.";
                  $this->Template->step1 = 1;
                  
      }  
    } elseif ($inputpref==3 || $inputpref==4 || $inputpref==5){ //groupe observation
           if($_REQUEST['inst']){$code = $_REQUEST['inst'];}
              if($_REQUEST['cdate']){$cdate = $_REQUEST['cdate'];}
              $dat=preg_split("/[-]+/", $cdate);
              $datum=$dat[2].".".$dat[1].".".$dat[0];
              $dsql = "SELECT * from tl_groupdata WHERE g_datum = ? AND g_code = ?";
              
              $dresult = $db->executeQuery($dsql, array($cdate,$code))->fetch();
              //var_dump($dresult);
              if(empty($dresult)){ //Bereits Datensatz vorhanden > Warnmeldung und Abbruch
                  
                  $this->Template->input = $inputpref;
                  $this->Template->inst = $inst4Array;
                  $this->Template->instcode = $instrid;
                  $this->Template->cdate = $datum;
                  $this->Template->step3 = 1;
                  $this->Template->step1 = 0;
              } else {
                $this->Template->warning = "We found an entry in daily observations for this date and this instrument. Only one observation/day/instrument is allowed.";
                  $this->Template->step1 = 1;
                  
                }    
            if($inputpref==5){
                $part = explode(".",$datum);
                $ht = mktime(0,0,0,date("n"),date("j"),date("Y"));
                //echo $ht." ";
                $at = mktime(0,0,0,intval($part[1]),intval($part[0]),intval($part[2]));
                //echo $at;
                if(date("n")==1){
	               $lt = mktime(0,0,0,12,1,(date("Y")-1));
	               $lt2 = mktime(0,0,0,1,1,date("Y"));
                } else {
                  $lt = mktime(0,0,0,(date("n")-1),1,date("Y"));
                  $lt2 = mktime(0,0,0,date("n"),1,date("Y"));
                }
                $lt3 = mktime(0,0,0,12,31,2013);
                $this->Template->ht = $ht;
                $this->Template->at = $at;
                $this->Template->lt = $lt;
                $this->Template->lt2 = $lt2;
                $this->Template->lt3 = $lt3;
            }
          }
      }
        
        if($_REQUEST['step3']==1){ // This is a group observation
           
//inputpref of the chosen instrument
          if($_REQUEST['inst']){$instrid = $_REQUEST['inst'];}
          $isql='SELECT * from tl_instrument WHERE id = ?';
          $iresult = $db->executeQuery($isql, array($instrid))->fetchAll();
          foreach($iresult as $result)
        {
            $inst5Array[] = array
		(
			'id' => $result['id'],
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
            $inputpref = $result['i_inputpref'];
            $instid = $result['id'];
        }
// Collect basic data (date, ut, Q, groups)
         if($_REQUEST['cdate']){$cdate = $_REQUEST['cdate'];}
         if($_REQUEST['UT']){$ut = $_REQUEST['UT'];}
         if($_REQUEST['qu']){$qu = $_REQUEST['qu'];}
        if($_REQUEST['ge']){$ge = $_REQUEST['ge'];} else {$ge = 0;}
            if($_REQUEST['cdate']){$cdate = $_REQUEST['cdate'];}
            $this->Template->input = $inputpref;
            $this->Template->code = $instid;
            $this->Template->inst = $inst5Array;
            $this->Template->UT = $ut;
            $this->Template->cdate = $cdate;
            $this->Template->qu = $qu;
            $this->Template->ge = $ge;
            $this->Template->step4 = 1;
            $this->Template->step0 = 0;
            $this->Template->step1 = 0;
            $this->Template->step2 = 0;
            $this->Template->step3 = 0;
        }
    
// Speichern Daily observation
    if($_REQUEST['savemode']=="basic"){ //Daily input without Waldmeier
        if($_REQUEST['instcode']){$code = $_REQUEST['instcode'];}
        if($_REQUEST['cdate']){$cdate = $_REQUEST['cdate'];}
        if($_REQUEST['UT']){$ut = $_REQUEST['UT'];}
        if($_REQUEST['qu']){$qu = $_REQUEST['qu'];}
        if($_REQUEST['ge']){$ge = $_REQUEST['ge'];}
        if($_REQUEST['ef']){$ef = $_REQUEST['ef'];}
        if($_REQUEST['a']){$a = $_REQUEST['a'];}
        if($_REQUEST['b']){$b = $_REQUEST['b'];}
        if($_REQUEST['c']){$c = $_REQUEST['c'];}
        if($_REQUEST['d']){$d = $_REQUEST['d'];}
        if($_REQUEST['e']){$e = $_REQUEST['e'];}
        if($_REQUEST['f']){$f = $_REQUEST['f'];}
        if($_REQUEST['g']){$g = $_REQUEST['g'];}
        if($_REQUEST['h']){$h = $_REQUEST['h'];}
        if($_REQUEST['j']){$j = $_REQUEST['j'];}
        $cdat = preg_split("/[.]+/", $cdate);
        $datum=$cdat[2]."-".$cdat[1]."-".$cdat[0];
        $now = date('Y-m-d H:m:s');
        if($_REQUEST['savewald']=="yes"){ //Daily save with Waldmeier
            $db->insert('tl_data', array('tstamp' => $now, 'd_code' => $code, 'd_datum' => $datum, 'd_ut' => $ut, 'd_q' => $qu, 'd_gruppen' => $ge, 'd_flecken' => $ef, 'd_A' => $a, 'd_B' => $b, 'd_C' => $c, 'd_D' => $d, 'd_E' => $e, 'd_F' => $f, 'd_G' => $g, 'd_H' => $h, 'd_J' => $j));
			$this->Template->newmessage = 'Observation of '.$cdate.' has been saved as daily observation with Waldmeier classification.';
            $this->Template->step0 = 1;
            $this->Template->code = $code;
        } else { //Daily save without Waldmeier
            $db->insert('tl_data', array('tstamp' => $now, 'd_code' => $code, 'd_datum' => $datum, 'd_ut' => $ut, 'd_q' => $qu, 'd_gruppen' => $ge, 'd_flecken' => $ef));
			$this->Template->newmessage = 'Observation of '.$cdate.' has been saved as daily observation without Waldmeier classification.';
            $this->Template->step0 = 1;
            $this->Template->code = $code;
        }
//Bisheriges Instrument wieder abrufen und zum Template senden
          $isql='SELECT * from tl_instrument WHERE id = ?';
          $iresult = $db->executeQuery($isql, array($code))->fetchAll();
          foreach($iresult as $result)
        {
            $inst4Array[] = array
		(
			'id' => $result['id'],
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
            $inputpref = $result['i_inputpref'];
        }
        $this->Template->allinstr = $inst3Array;
        $this->Template->step0 = 1;
        $this->Template->input = $inputpref;
    }
// Groupe Save > Speichern von groupe observation
//**************************************************
    if($_REQUEST['step4']==1){// groupesavemode
        $now = date('Y-m-d H:m:s');
        $code=$_REQUEST["incode"];
        $ddat=$_REQUEST["cdate"];
        $dat=preg_split("/[.]+/", $ddat);
        $datum=$dat[2]."-".$dat[1]."-".$dat[0];
        $ut=$_REQUEST["UT"];
        $qu=$_REQUEST["qu"];
        $ge=$_REQUEST["ge"];
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
        
        $i=0; // Zähler für die gruppenarrays
     
        if($f[$i]==NULL){ //keine Flecken > ergibt einen Nulleintrag   
// Datensatz in groupdata speichern            
            $db->insert('tl_groupdata', array('tstamp' => $now, 'g_code' => $code, 'g_datum' => $datum, 'g_ut' => $ut, 'g_q' => $qu, 'g_nr' => $ge, 'g_f' => 0, 'g_p' => 0, 'g_s' => 0, 'g_A' => 0));
// Datensatz in daily speichern
        //tlim bestimmen
        $part = explode(".",$datum);
        $at = mktime(0,0,0,intval($dat[1]),intval($dat[0]),intval($dat[2]));
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
            $db->insert('tl_data', array('tstamp' => $now, 'd_code' => $code, 'd_datum' => $datum, 'd_ut' => $ut, 'd_q' => $qu, 'd_gruppen' => 0, 'd_flecken' => 0, 'd_A' => 0, 'd_B' => 0, 'd_C' => 0, 'd_D' => 0, 'd_E' => 0, 'd_F' => 0, 'd_G' => 0, 'd_H' => 0, 'd_J' => 0));
             }
            
            $this->Template->newmessage = 'Observation of '.$ddat.' has been saved as group observation (no groups observed).';
            $this->Template->step0 = 1;
            $this->Template->code = $code;
        } // Ende Nulleintrag
        
//mindestens 1 Fleck > While-Schleife, um alle Arrays zu durchlaufen
//Zusätzlich: Unterschiedliche Speicherroutine je nach inputpref
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
              //break;
          case "Bxi":
          case "Bxo":
              $sB=$sB+1;
              //break;
          case "Cri":
          case "Csi":
          case "Cai":
          case "Chi":
          case "Cki":
          case "Cro":
          case "Cso":
          case "Cao":
              $sC=$sC+1;
              //break;
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
              //break;
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
        
//jetzt eintragen in tl_groupdata > pro Gruppe ein Record
          $grparray = array('tstamp' => $now, 'g_code' => $code, 'g_datum' => $datum, 'g_ut' => $ut, 'g_q' => $qu, 'g_nr' => $ge,
                      'g_f' => $f[$i], 'g_Zpd' => $zpd[$i], 'g_p' => $p[$i], 'g_s' => $s[$i], 'g_sector' => $sect[$i]);
          if($a[$i]!=99){
                    $grparray['g_A'] = $a[$i];
                }
          if($pos[$i]!=99){
                  $grparray['g_pos'] =$pos[$i];	
                }
          $db->insert('tl_groupdata', $grparray);
    
        $i=$i+1;
          
            

//Eintrag in daily
            }
        if($at >= $lt){
        $db->insert('tl_data', array('tstamp' => $now, 'd_code' => $code, 'd_datum' => $datum, 'd_ut' => $ut, 'd_q' => $qu, 'd_gruppen' => $ge, 'd_flecken' => $sff, 'd_A' => $sA, 'd_B' => $sB, 'd_C' => $sC, 'd_D' => $sD, 'd_E' => $sE, 'd_F' => $sF, 'd_G' => $sG, 'd_H' => $sH, 'd_J' => $sJ));
        }
        $this->Template->newmessage = 'Observation of '.$ddat.' has been saved as group observation. There were '.$i.' records with a f total of '.$ef;
            $this->Template->step0 = 1;
            $this->Template->code = $code;
        
    }
    }
  }
