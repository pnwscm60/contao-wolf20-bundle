<?php
namespace Pnwscm60\Wolf20Bundle\Module;
class ModuleWolfInstedit extends \Contao\Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_wolfinstedit';
 
public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['wolfinstedit'][0]) . ' ###';
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
		
			
	// Userdaten für Angaben zu Observer
		$this->import('FrontendUser', 'User');
		$userid = $this->User->id;
		//Informationen zum Observer
		$sql="SELECT * from tl_member WHERE id = ".$userid;
		$beob=mysql_query($sql) or die(mysql_error());
		$beo=mysql_fetch_row($beob);
	
		$this->Template->userid = $userid;
		$this->Template->observer = "[".$beo[0]."] ".$beo[3]." ".$beo[2].", ".$beo[9]." (".strtoupper($beo[11]).")<br/>";
		

		
		if($_REQUEST['modifyinst']==1){ //Instrument modifizieren!
			if(isset($code)){
				$instcode=$code;
			} else {
				if(isset($_REQUEST['inst'])){
					$instcode=$_REQUEST['inst'];
				} else {
					echo "Error: Kein Instrument gewählt ...";
					break;
				}
			}
			
			$sql="SELECT * from tl_instrument, tl_member WHERE tl_instrument.id=".$instcode." AND tl_member.id = i_id";

			$beob=mysql_query($sql) or die(mysql_error());
			$beo=mysql_fetch_row($beob);

			$this->Template->instrument = "[".$beo[0]."] ".$beo[3]." ".$beo[4]." ".$beo[5]." / ".$beo[6].", Mag. ".$beo[9]."</p>";
			

			$this->Template->modifyinst = 1;
			$this->Template->instcode = $instcode;
			$this->Template->inputpref = $beo[11];
		}
		if($_REQUEST['saveinstmod']==1){ //Aktivierung Instrument speichern
			
			$icode = $_REQUEST['icode'];
			$ispez = $_REQUEST['iakt'];
			//echo $icode."/".$ispez."<br/>";
			$sql = "UPDATE tl_instrument set i_inputpref = ".$ispez." WHERE id=".$icode;
			//echo $sql."<br/>";
			$doit = mysql_query($sql) or die(mysql_error());
			$sql="SELECT * from tl_instrument, tl_member WHERE tl_instrument.id=".$icode." AND tl_member.id = i_id";
			//echo $sql;
			$beob=mysql_query($sql) or die(mysql_error());
			$beo=mysql_fetch_row($beob);
			$this->Template->instrument = "[".$beo[0]."] ".$beo[3]." ".$beo[4]." / ".$beo[5].", ".$beo[6].", Mag. ".$beo[9]."</p>";
			$this->Template->instcode = $icode;
			$this->Template->inputpref = $ispez;
			$this->Template->modifyinst = 1;
			$this->Template->saveinstmod = 1;
		}
		if($_REQUEST['viewinst']==1){
			$this->Template->viewinst = 1;
			
		}
		if($_REQUEST['newinst']==1){
			$this->Template->newinst = 1;
		}
		
		if($_REQUEST['savenewinst']==1){
			if($_REQUEST['type']){
				$type=$_REQUEST['type'];
			}
			if($_REQUEST['aperture']){
				$aperture=$_REQUEST['aperture'];
			}
			if($_REQUEST['focal']){
				$focal=$_REQUEST['focal'];
			}
			if($_REQUEST['filter']){
				$filter=$_REQUEST['filter'];
			}
			if($_REQUEST['method']){
				$method=$_REQUEST['method'];
			}
			if($_REQUEST['mag']){
				$mag=$_REQUEST['mag'];
			}
			if($_REQUEST['project']){
				$project=$_REQUEST['project'];
			}
			if($_REQUEST['input']){
				$input=$_REQUEST['input'];	
			}
			if($_REQUEST['id']){
				$id=$_REQUEST['id'];	
			}

			$sql='INSERT into tl_instrument (i_id, i_type, i_aperture, i_focal_length, i_filter, i_method, i_magnification, ';
			if($_REQUEST['project']!=''){
				$sql.='i_projection, ';
			} 
			$sql.='i_inputpref) VALUES ('.$userid.', "'.$type.'", '.$aperture.', '.$focal.', "'.$filter.'", "'.$method.'", '.$mag.', ';
			if($_REQUEST['project']!=''){
				$sql.=$project.',';
			}
			$sql.= '0);'; 


			//echo $sql;
			$doit = mysql_query($sql) or die(mysql_error());
			$this->newmessage = 'Data of new instr has been saved.';
			
		}
		if($_REQUEST['instexcel']==1){
			ob_end_clean();
			// sql-statement
			$sql='SELECT * from tl_instrument WHERE i_id = '.$userid.' ORDER by id ASC;';

			//echo $sql.'<br/><br/>';
			$result=mysql_query($sql) or die(mysql_error());
			$num_fields = mysql_num_fields($result);

			// Filename with current date
			$current_date = date("y/m/d");
					$filename = "Instruments_".$current_date.".xls";

			// Open php output stream and write headers
			$fp = fopen('php://output', 'w');
			if ($fp && $result) {
			header("Content-Type: application/vnd.ms-excel; charset=utf-8");
			header("Content-Disposition: attachment; filename=".$filename);  header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);

				//Kopfzeile schreiben
				echo "code \t user \t type \t apert \t foc.l \t filter \t method \t magn \t proj \t input \n";
				//Zeilen ausgeben
				while ($r = mysql_fetch_row($result)) {
				//$row_tally = $row_tally + 1;
				echo $r[0]."\t".$r[3]."\t".$r[4]."\t".$r[5]."\t".$r[6]."\t".$r[7]."\t".$r[8]."\t".$r[9]."\t".$r[10]."\t".$r[11]."\n";
				}

			}
				die;
		}
	}
}
