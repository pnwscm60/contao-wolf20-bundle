<?php

/**
DCA für wolfinstitute
© 2017 Markus Schenker, Phi Network
 */


/**
 * Table tl_groupdata
 * Table for wolf_original_sunspot-data
 */
$GLOBALS['TL_DCA']['tl_groupdata'] = array
(
	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
			)
		),
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'fields'                  => array('sorting'),
			'headerFields'			=> array('g_datum,g_ut'),
			'panelLayout'             => 'filter;sort,search,limit',
		),
		'label' => array
		(
			'fields'                  => array('g_datum,g_ut,g_code'),
			'format'                  => '%s %s',
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_groupdata']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_groupdata']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			/*'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_groupdata']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_groupdata', 'toggleIcon')
			),*/
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_groupdata']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif',
				'attributes'          => 'style="margin-right:3px"'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'	=> 'g_code,g_datum,g_ut,g_q,g_nr,g_f,g_Zpd,g_p,g_s,g_sector,g_A,g_pos'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),'tstamp' => array
		(
			'sql'                     => "timestamp NOT NULL default CURRENT_TIMESTAMP"
		),
		/*'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_groupdata']['alias'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alias', 'unique'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_groupdata', 'generateAlias')
			),
			'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
		),*/
	'g_code' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_data']['g_code'],
			'exclude'			=> false,
			'search'			=> true,
			'sorting'			=> true,
			'filter'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'mandatory'	=>	true,
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(5) unsigned NOT NULL default '0'"
		),
	'g_datum' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_groupdata']['g_datum']['d_datum'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'flag'                    => 11,
			'search'                  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>11,'digit' => true, 'tl_class'=>'w50'),
			'sql'                     => "date NOT NULL default '1900-01-01'"
		),
		'g_ut' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_groupdata']['g_ut'],
			'exclude'			=> false,
			'search'			=> true,
			'sorting'			=> true,
			'filter'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'mandatory'	=>	true,
				'minlength'	=>	4,
				'maxlength'	=>	4,
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(4) unsigned NOT NULL default '2400'"
		),
		'g_q' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_groupdata']['g_q'],
			'exclude'			=> false,
			'search'			=> true,
			'sorting'			=> true,
			'filter'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'mandatory'	=>	true,
				'minlength'	=>	1,
				'maxlength'	=>	1,
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(1) unsigned NOT NULL default '0'"
		),
		'g_nr' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_groupdata']['g_nr'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(2) unsigned NOT NULL default '0'"
		),
		'g_f' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_groupdata']['g_f'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(2) unsigned NOT NULL default '0'"
		),
		'g_Zpd' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_groupdata']['g_Zpd'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'alnum'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "varchar(3) NULL"
		),
		'g_p' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_groupdata']['g_p'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(1) NOT NULL default '0'"
		),
		'g_s' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_groupdata']['g_s'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(2) NOT NULL default '0'"
		),
		'g_sector' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_groupdata']['g_sector'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(1) NULL"
		),
		'g_A' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_groupdata']['g_A'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(1) NULL"
		),
		'g_pos' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_groupdata']['g_pos'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'alnum'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "varchar(6) NULL"
		),
	)
);
/*Classes*/
class tl_groupdata extends Backend {	
	
}
