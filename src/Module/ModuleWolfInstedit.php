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
            $objTemplate->wildcard = '### instedit ###';
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
		
			
	//Daten bereitstellen User > Instruments
        $this->import('FrontendUser', 'User');
        $userid = $this->User->id;

//Informationen zum Observer
        $sql="SELECT * from tl_member WHERE id = ".$userid;
        $result = $this->Database->prepare($sql)->execute();
        $this->Template->observer = $result->id;
        $this->Template->lname = $result->lastname;
        $this->Template->fname = $result->firstname;
        $this->Template->city = $result->city;
        $this->Template->country = strtoupper($result->country);		

//Show all instrument for this user
        $sql="SELECT *, tl_instrument.id as inid from tl_instrument WHERE i_id=".$userid;
        
        $result2 = $this->Database->prepare($sql)->execute();

        $instArray = array();
        while($result2->next())
        {
            $instaArray[] = array
		(
			'id' => $result2->inid,
			'i_id' => $result2->i_id,
            'i_aperture' => $result2->i_aperture,
            'i_focal_length' => $result2->i_focal_length,
            'i_filter' => $result2->i_filter,
            'i_method' => $result2->i_method,
            'i_magnification' => $result2->i_magnification,
            'i_projection' => $result2->i_projection,
            'i_inputpref' => $result2->i_inputpref,
                );
        }
        $this->Template->allinstr = $instaArray;
		
		if($_REQUEST['modifyinst']==1){ //Instrument modifizieren!
			if(isset($code)){
				$instcode=$code;
			} else {
				if(isset($_REQUEST['inst'])){
					$instcode=$_REQUEST['inst'];
				} else {
					echo "Error: Kein Instrument gewählt ...";
					//break;
				}
			}
			
		$sql="SELECT *, tl_instrument.id as inid from tl_instrument, tl_member WHERE tl_instrument.id=".$instcode." AND tl_member.id = i_id";
        //echo $sql;
        $result = $this->Database->prepare($sql)->execute();

        $instArray = array();
        while($result->next())
        {
            $instArray[] = array
		(
			'id' => $result->inid,
			'i_id' => $result->i_id,
            'i_aperture' => $result->i_aperture,
            'i_focal_length' => $result->i_focal_length,
            'i_filter' => $result->i_filter,
            'i_method' => $result->i_method,
            'i_magnification' => $result->i_magnification,
            'i_projection' => $result->i_projection,
            'i_inputpref' => $result->i_inputpref,
                );
        }
        $this->Template->instr = $instArray;
		$this->Template->modifyinst = 1;	
		}
        
        
		if($_REQUEST['saveinstmod']==1){ //Aktivierung Instrument speichern
			
			$icode = $_REQUEST['icode'];
			$ispez = $_REQUEST['iakt'];
			//echo $icode."/".$ispez."<br/>";
			$sql = "UPDATE tl_instrument set i_inputpref = ".$ispez." WHERE id=".$icode;
			//echo $sql."<br/>";
			$result = $this->Database->prepare($sql)->execute();
			$sql="SELECT *, tl_instrument.id as inid from tl_instrument,  tl_member WHERE tl_instrument.id=".$icode." AND tl_member.id = i_id";
			//echo $sql;
			 $result = $this->Database->prepare($sql)->execute();

        $instArray = array();
        while($result->next())
        {
            $inst2Array[] = array
		(
			'id' => $result->inid,
			'i_id' => $result->i_id,
            'i_aperture' => $result->i_aperture,
            'i_focal_length' => $result->i_focal_length,
            'i_filter' => $result->i_filter,
            'i_method' => $result->i_method,
            'i_magnification' => $result->i_magnification,
            'i_projection' => $result->i_projection,
            'i_inputpref' => $result->i_inputpref,
                );
        }
        $this->Template->instr = $inst2Array;
		$this->Template->safeinstmode = 1;	
		}
        
		if($_REQUEST['viewinst']==1){
            $sql1='SELECT *, tl_instrument.id as inid from tl_instrument, tl_member WHERE i_id = '.$userid.' AND i_id=tl_member.id ORDER BY tl_instrument.id';
			$result = $this->Database->prepare($sql)->execute();
            $instArray = array();
            while($result->next())
        {
            $inst3Array[] = array
		(
			'id' => $result->inid,
			'i_id' => $result->i_id,
            'i_type' => $result->i_type,
            'i_aperture' => $result->i_aperture,
            'i_focal_length' => $result->i_focal_length,
            'i_filter' => $result->i_filter,
            'i_method' => $result->i_method,
            'i_magnification' => $result->i_magnification,
            'i_projection' => $result->i_projection,
            'i_inputpref' => $result->i_inputpref,
                );
        }
        $this->Template->instr = $inst3Array;
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
