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
		
	//DB
    $db = \Contao\System::getContainer()->get('database_connection');
	//Daten bereitstellen User > Instruments
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
			
		$qsql="SELECT *, tl_instrument.id as inid from tl_instrument, tl_member WHERE tl_instrument.id= ?";
        //echo $sql;
        $result = $db->executeQuery($qsql, array($instcode))->fetch();
			$this->Template->id = $result['inid'];
			$this->Template->i_id = $result['i_id'];
            $this->Template->i_aperture = $result['i_aperture'];
            $this->Template->i_focal_length = $result['i_focal_length'];
            $this->Template->i_filter = $result['i_filter'];
            $this->Template->i_method = $result['i_method'];
            $this->Template->i_magnification = $result['i_magnification'];
            $this->Template->i_projection = $result['i_projection'];
            $this->Template->i_inputpref = $result['i_inputpref'];
		$this->Template->modifyinst = 1;	
		}
        
        
		if($_REQUEST['saveinstmod']==1){ //Aktivierung Instrument speichern
			
			$icode = $_REQUEST['icode'];
			$ispez = $_REQUEST['iakt'];
            $db->update('tl_instrument', array('i_inputpref' => $ispez), array('id' => $icode));
                
			//$result = $this->Database->prepare($sql)->execute();
			$qsql="SELECT *, tl_instrument.id as inid from tl_instrument, tl_member WHERE tl_instrument.id= ?";
        $result = $db->executeQuery($qsql, array($icode))->fetch();
			$this->Template->id = $result['inid'];
			$this->Template->i_id = $result['i_id'];
            $this->Template->i_aperture = $result['i_aperture'];
            $this->Template->i_focal_length = $result['i_focal_length'];
            $this->Template->i_filter = $result['i_filter'];
            $this->Template->i_method = $result['i_method'];
            $this->Template->i_magnification = $result['i_magnification'];
            $this->Template->i_projection = $result['i_projection'];
            $this->Template->i_inputpref = $result['i_inputpref'];
		$this->Template->safeinstmode = 1;	
		}
        
		if($_REQUEST['viewinst']==1){
            $qsql='SELECT *, tl_instrument.id as inid from tl_instrument, tl_member WHERE tl_member.id = ? AND i_id = tl_member.id ORDER BY tl_instrument.id';
			$resultall2 = $db->executeQuery($qsql, array($userid))->fetchAll();
            
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
			if($_REQUEST['project']||$_REQUEST['project']==0){
				$project=$_REQUEST['project'];
			}
			if($_REQUEST['input']){
				$input=$_REQUEST['input'];	
			}
			if($_REQUEST['id']){
				$id=$_REQUEST['id'];	
			}
            $db->insert('tl_instrument', array('i_id' => $userid, 'i_type' => $type, 'i_aperture' => $aperture, 'i_focal_length' => $focal, 'i_filter' => $filter, 'i_method' => $method, 'i_magnification' => $mag, 'i_projection' => $project));
			/*$sql='INSERT into tl_instrument (i_id, i_type, i_aperture, i_focal_length, i_filter, i_method, i_magnification, ';
			if(isset($project)){
				$sql.='i_projection, ';
			} 
			$sql.='i_inputpref) VALUES ('.$userid.', "'.$type.'", '.$aperture.', '.$focal.', "'.$filter.'", "'.$method.'", '.$mag.', ';
			if(isset($project)){
				$sql.=$project.',';
			}
			$sql.= '0);'; 
*/
            //echo $project;    
			//echo $sql;
			//$result = $this->Database->prepare($sql)->execute();
			$this->newmessage = 'Data of new instrument has been saved.';
			$this->Template->newinst = 1;
            $this->Template->savenewinst = 1;
		}
        
        
		if($_REQUEST['instexcel']==1){
			ob_end_clean();
			// sql-statement
			$csql='SELECT * from tl_instrument WHERE i_id = ? ORDER by id ASC;';
			$resultcsv = $db->executeQuery($csql, array($userid))->fetchAll();
            
			//echo $sql.'<br/><br/>';
			//$result=mysql_query($sql) or die(mysql_error());
			
			// Filename with current date
			$current_date = date("y/m/d");
					$filename = "Instruments_".$mresult['lastname']."_".$current_date.".csv";

			// Open php output stream and write headers
			$fp = fopen('php://output', 'w');
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=".$filename);  header("Expires: 0");
			//if ($fp && $resultcsv) {
			//header("Content-Type: application/vnd.ms-excel; charset=utf-8");
			//header("Content-Disposition: attachment; filename=".$filename);  header("Expires: 0");
			//header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			//header("Cache-Control: private",false);

				//Kopfzeile schreiben
				//echo "code \t user \t type \t apert \t foc.l \t filter \t method \t magn \t proj \t input \n";
				echo "code;user;type;apert;foc.l;filter;method;magn;proj;inputpref\n";
                //Zeilen ausgeben
				foreach($resultcsv as $r) {
				//$row_tally = $row_tally + 1;
				//echo $r[0]."\t".$r[3]."\t".$r[4]."\t".$r[5]."\t".$r[6]."\t".$r[7]."\t".$r[8]."\t".$r[9]."\t".$r[10]."\t".$r[11]."\n";
                echo $r['id'].";".$r['i_id'].";".$r['i_type'].";".$r['i_aperture'].";".$r['i_focal_length'].";".$r['i_filter'].";".$r['i_method'].";".$r['i_magnification'].";".$r['i_projection'].";".$r['i_inputpref']."\n";
				}

			//}
				die;
		}
        
        //Show all instrument for this user
        $qsql="SELECT *, tl_instrument.id as inid from tl_instrument WHERE i_id = ?";
        $resultall = $db->executeQuery($qsql, array($userid))->fetchAll();
        $instArray = array();
        foreach($resultall as $result)
        {
            $instaArray[] = array
		(
			'id' => $result['inid'],
			'i_id' => $result['i_id'],
            'i_aperture' => $result['i_aperture'],
            'i_focal_length' => $result['i_focal_length'],
            'i_filter' => $result['i_filter'],
            'i_method' => $result['i_method'],
            'i_magnification' => $result['i_magnification'],
            'i_projection' => $result['i_projection'],
            'i_inputpref' => $result['i_inputpref'],
                );
        }
        $this->Template->allinstr = $instaArray;
	}
}
