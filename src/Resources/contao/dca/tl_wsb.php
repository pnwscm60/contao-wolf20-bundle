<?php

/**
DCA für wolfinstitute
© 2017 Markus Schenker, Phi Network
 */


/**
 * Table tl_wsb
 * Table for wolf_original_sunspot-data
 */
$GLOBALS['TL_DCA']['tl_wsb'] = array
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
			'fields'                  => array('wsb_y'),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_wsb']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_wsb']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			/*'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_wsb']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_wsb', 'toggleIcon')
			),*/
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_wsb']['show'],
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_wsb']['alias'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alias', 'unique'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_wsb', 'generateAlias')
			),
			'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
		),*/
	
		'wsb_y' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsb'],
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
		'wsb_m' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsb'],
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
		'wsb_d' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsb'],
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
		'wsb_oid' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsb'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(11) unsigned NULL"
		),
		'wsb_o' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_wsb']['descript'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'flag'                    => 11,
			'search'                  => true,
			'eval'                    => array('mandatory'=>false, 'maxlength'=>11, 'tl_class'=>'w50'),
			'sql'                     => "varchar(11) NULL"
		),
		'wsb_g' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsb'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(11) unsigned NULL"
		),
		'wsb_f' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsb'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(11) NULL"
		),
		'wsb_r' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsb'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(11) unsigned NULL"
		),
		'wsb_fl' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsb'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(11) NOT NULL default '0'"
		),
	)
);
/*Classes*/
class tl_wsb extends Backend {	
	
}
