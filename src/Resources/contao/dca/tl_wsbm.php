<?php

/**
DCA für wolfinstitute
© 2017 Markus Schenker, Phi Network
 */


/**
 * Table tl_wsbm

 * Table for wolf_original_sunspot-data
 */
$GLOBALS['TL_DCA']['tl_wsbm'] = array
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
			'headerFields'			=> array('wsbm
		_y','wsbm
		_d'),
			'panelLayout'             => 'filter;sort,search,limit',
		),
		'label' => array
		(
			'fields'                  => array('wsbm
		_y'),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_wsbm
			']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_wsbm
			']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			/*'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_wsbm
			']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_wsbm
			', 'toggleIcon')
			),*/
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_wsbm
			']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif',
				'attributes'          => 'style="margin-right:3px"'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'	=> 'wsbm_y,wsbm_m,wsbm_ro,wsbm_rw'
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_wsbm
		']['alias'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alias', 'unique'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_wsbm
			', 'generateAlias')
			),
			'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
		),*/
	
		'wsbm_y' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsbm'],
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
			'sql'                     => "int(11) unsigned NOT NULL default '0'"
		),
		'wsbm_m' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsbm'],
			'exclude'			=> false,
			'search'			=> true,
			'sorting'			=> true,
			'filter'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'mandatory'	=>	true,
				'minlength'	=>	2,
				'maxlength'	=>	2,
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(11) unsigned NOT NULL default '0'"
		),
		'wsbm_ro' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsbm'],
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
			'sql'                     => "float(11,1) NOT NULL default '0.0'"
		),
		'wsbm_rw' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsbm'],
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
			'sql'                     => "float(11,1) NOT NULL default '0.0'"
		),
	)
);
/*Classes*/
class tl_wsbm
extends Backend {	
	
}
