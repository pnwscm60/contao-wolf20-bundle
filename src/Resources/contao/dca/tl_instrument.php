<?php

/**
DCA für wolfinstitute
© 2017 Markus Schenker, Phi Network
 */


/**
 * Table tl_instrument
 * Table for wolf_original_sunspot-data
 */
$GLOBALS['TL_DCA']['tl_instrument'] = array
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
			'headerFields'			=> array('i_aperture'),
			'panelLayout'             => 'filter;sort,search,limit',
		),
		'label' => array
		(
			'fields'                  => array('id','i_aperture','i_focal_length'),
			'format'                  => '[%s] A:%s FL:%s',
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
				'label'               => &$GLOBALS['TL_LANG']['tl_instrument']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_instrument']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			/*'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_instrument']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_instrument', 'toggleIcon')
			),*/
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_instrument']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif',
				'attributes'          => 'style="margin-right:3px"'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'	=> 'id,i_type, i_aperture, i_focal_length, i_filter, i_method, i_magnification, i_projection, i_inputpref'
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_instrument']['alias'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alias', 'unique'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_instrument', 'generateAlias')
			),
			'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
		),*/
	
		'i_id' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_instrument']['i_id'],
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
			'sql'                     => "int(11) unsigned NOT NULL default '0'",
		),
		'i_type' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_instrument']['i_type'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'flag'                    => 11,
			'search'                  => true,
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50'),
			'sql'                     => "text NOT NULL",
		),
		'i_aperture' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_instrument']['i_aperture'],
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
			'sql'                     => "int(11) unsigned NOT NULL default '0'",
		),
		'i_focal_length' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_instrument']['i_focal_length'],
			'exclude'			=> false,
			'search'			=> true,
			'sorting'			=> true,
			'filter'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(11) unsigned NOT NULL default '0'"
		),
		'i_filter' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_instrument']['i_filter'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'flag'                    => 11,
			'search'                  => true,
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50'),
			'sql'                     => "text NOT NULL"
		),
		'i_method' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_instrument']['i_method'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'flag'                    => 11,
			'search'                  => true,
			'eval'                    => array('mandatory'=>false, 'tl_class'=>'w50'),
			'sql'                     => "text NOT NULL"
		),
		'i_magnification' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_instrument']['i_magnification'],
			'exclude'			=> false,
			'search'			=> true,
			'sorting'			=> true,
			'filter'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(11) unsigned NOT NULL default '0'"
		),
		'i_projection' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_instrument']['i_projection'],
			'exclude'			=> false,
			'search'			=> true,
			'sorting'			=> true,
			'filter'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(11) NULL"
		),
		'i_inputpref' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_instrument']['i_inputpref'],
			'exclude'			=> false,
			'search'			=> false,
			'sorting'			=> false,
			'filter'			=> false,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(11) unsigned NOT NULL default '0'"
		),
	
	'i_lasteditwho' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_instrument']['i_lasteditwho'],
			'exclude'			=> false,
			'search'			=> false,
			'sorting'			=> false,
			'filter'			=> false,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "int(11) unsigned NOT NULL default '0'"
		),
		
	)
);
/*Classes*/
class tl_instrument extends Backend {	
	
}
