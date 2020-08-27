<?php

/**
DCA für wolfinstitute
© 2017 Markus Schenker, Phi Network
 */


/**
 * Table tl_data
 * Table for wolf_original_sunspot-data
 */
$GLOBALS['TL_DCA']['tl_data'] = array
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
			'headerFields'			=> array('wsb_y','wsb_d'),
			'panelLayout'             => 'filter;sort,search,limit',
		),
		'label' => array
		(
			'fields'                  => array('d_datum'),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_data']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_data']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			/*'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_data']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_data', 'toggleIcon')
			),*/
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_data']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif',
				'attributes'          => 'style="margin-right:3px"'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'	=> 'wsb_y,wsb_m,wsb_d,wsb_oid,wsb_o,wsb_g,wsb_f,wsb_r,wsb_fl'
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_data']['alias'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alias', 'unique'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_data', 'generateAlias')
			),
			'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
		),*/
	
		'd_code' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_data']['d_code'],
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
	'd_datum' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_data']['d_datum'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'flag'                    => 11,
			'search'                  => true,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>11, 'tl_class'=>'w50'),
			'sql'                     => "date NOT NULL default '0001-01-01'"
		),
		'd_ut' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_data']['d_ut'],
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
		'd_q' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_data']['d_q'],
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
		'd_gruppen' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_data']['d_gruppen'],
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
		'd_flecken' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_data']['d_flecken'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(3) unsigned NOT NULL default '0'"
		),
		'd_A' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_data']['d_A'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(2) NULL"
		),
		'd_B' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_data']['d_B'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(2) NULL"
		),
		'd_C' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_data']['d_C'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(2) NULL"
		),
		'd_D' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_data']['d_D'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(2) NULL"
		),
		'd_E' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_data']['d_E'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(2) NULL"
		),
		'd_F' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_data']['d_F'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(2) NULL"
		),
		'd_G' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_data']['d_G'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(2) NULL"
		),
		'd_H' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_data']['d_H'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(2) NULL"
		),
		'd_J' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_data']['d_J'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(2) NULL"
		),
	)
);
/*Classes*/
class tl_data extends Backend {	
	
}
