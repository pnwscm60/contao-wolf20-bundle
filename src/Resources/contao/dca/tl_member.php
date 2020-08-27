<?php
 /**
DCA für wolfinstitute
© 2017 Markus Schenker, Phi Network
 */


/**
 * Ergänzung tl_member
 * 
 */

$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] = str_replace 
( 
    'dateOfBirth', 
    'yearOfBirth, role', 
    $GLOBALS['TL_DCA']['tl_member']['palettes']['default'] 
); 
  
// Hinzufügen der Feld-Konfiguration 
$GLOBALS['TL_DCA']['tl_member']['fields']['yearOfBirth'] = array 
( 
    'label'     => &$GLOBALS['TL_LANG']['tl_member']['yearOfBirth'], 
    'exclude'   => true, 
    'inputType' => 'text', 
    'eval'      => array('mandatory'=>false, 'rgxp'=>'digit', 'maxlength'=>4), 
    'sql'       => "int(4) NOT NULL default '0'" 
);
$GLOBALS['TL_DCA']['tl_member']['fields']['role'] = array 
( 
    'label'     => &$GLOBALS['TL_LANG']['tl_member']['role'], 
    'exclude'   => true, 
    'inputType' => 'text', 
    'eval'      => array('mandatory'=>false, 'rgxp'=>'alnum', 'maxlength'=>5), 
    'sql'       => "varchar(4) NOT NULL default ''" 
); 
