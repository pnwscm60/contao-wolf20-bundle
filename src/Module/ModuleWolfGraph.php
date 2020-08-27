<?php
 
class ModuleWolfGraph extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_wolfgraph';
 
public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['wolfgraph'][0]) . ' ###';
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
		$sql="SELECT concat(wsb_y,'-',wsb_m,'-',wsb_d) as date,wsb_r as rz from tl_wsb;";
$ds=mysql_query($sql) or die(mysql_error());
for ($x = 0; $x < 10000; $x++) {
        $data[] = mysql_fetch_assoc($ds);
    }
$wdaten = json_encode($data);
$this->Template->wolfgraph = $wdaten;
	}
}
