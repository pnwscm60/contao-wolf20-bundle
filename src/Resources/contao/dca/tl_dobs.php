<?php

/**
DCA für wolfinstitute
© 2020 Markus Schenker, Phi Network
 */


/**
 * Table tl_dobs
 * Table for wolf_original_sunspot-data
 */
$GLOBALS['TL_DCA']['tl_dobs'] = array
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
			'headerFields'			=> array('d_time'),
			'panelLayout'             => 'filter;sort,search,limit',
		),
		'label' => array
		(
			'fields'                  => array('d_time'),
			'format'                  => '%s',
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
				'label'               => &$GLOBALS['TL_LANG']['tl_dobs']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_dobs']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			/*'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_dobs']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_dobs', 'toggleIcon')
			),*/
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_dobs']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif',
				'attributes'          => 'style="margin-right:3px"'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'	=> 'd_num, d_loc, d_lon, d_area, d_ext, d_scl, d_count, d_mag, d_time'
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_dobs']['alias'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alias', 'unique'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_dobs', 'generateAlias')
			),
			'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
		),*/
	
		'd_num' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_dobs']['d_num'],
			'exclude'			=> false,
			'search'			=> true,
			'sorting'			=> true,
			'filter'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'mandatory'	=>	true,
				'alnum'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
	'd_loc' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_dobs']['d_loc'],
			'exclude'			=> false,
			'search'			=> true,
			'sorting'			=> true,
			'filter'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'mandatory'	=>	true,
				'alnum'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "varchar(6) NOT NULL default ''"
		),
		'd_lon' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_dobs']['d_lon'],
			'exclude'			=> false,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'mandatory'	=>	true,
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(3) NULL"
		),
		'd_area' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_dobs']['d_area'],
			'exclude'			=> false,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'mandatory'	=>	false,
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(4) NULL"
		),
		'd_ext' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_dobs']['d_ext'],
			'exclude'			=> false,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'mandatory'	=>	false,
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(3) NULL"
		),
		'd_scl' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_dobs']['d_scl'],
			'exclude'			=> false,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'mandatory'	=>	false,
				'alnum'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "varchar(5) NULL"
		),
		'd_count' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_dobs']['d_count'],
			'exclude'			=> false,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'mandatory'	=>	false,
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(3) NULL"
		),
		'd_mag' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_dobs']['d_mag'],
			'exclude'			=> false,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'mandatory'	=>	false,
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(3) NULL"
		),
		'd_time' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_dobs']['d_time'],
			'exclude'			=> false,
			'inputType'			=> 'text',
			'eval'				=> array(
				'tl_class'=>'w50'
				),
			'sql'                     => "timestamp NOT NULL default '0000-00-00 00:00:00'"
		),
	)
);
/*Classes*/
class tl_dobs extends Backend {	
	
}
