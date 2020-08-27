<?php

/**
DCA für wolfinstitute
© 2017 Markus Schenker, Phi Network
 */


/**
 * Table tl_wsbo
 * Table for wolf_original_sunspot-data
 */
$GLOBALS['TL_DCA']['tl_wsbo'] = array
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
			'headerFields'			=> array('wsbo_y','wsbo_d'),
			'panelLayout'             => 'filter;sort,search,limit',
		),
		'label' => array
		(
			'fields'                  => array('wsbo_y'),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_wsbo']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_wsbo']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			/*'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_wsbo']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_wsbo', 'toggleIcon')
			),*/
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_wsbo']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif',
				'attributes'          => 'style="margin-right:3px"'
			),
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'	=> 'wsbo_c,wsbo_y,wsbo_o,wsbo_kf,wsbo_t1,wsbo_t2'
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_wsbo']['alias'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'alias', 'unique'=>true, 'maxlength'=>128, 'tl_class'=>'w50'),
			'save_callback' => array
			(
				array('tl_wsbo', 'generateAlias')
			),
			'sql'                     => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
		),*/
	
		'wsbo_c' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsbo'],
			'exclude'			=> false,
			'search'			=> true,
			'sorting'			=> true,
			'filter'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'mandatory'	=>	true,
				'alphanum'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "varchar(11) NOT NULL"
		),
		'wsbo_y' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsbo'],
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
		'wsbo_o' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsbo'],
			'exclude'			=> false,
			'search'			=> true,
			'sorting'			=> true,
			'filter'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'mandatory'	=>	true,
				'alphanum'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "varchar(11) NOT NULL"
		),
		'wsbo_kf' => array
		(
			'label'				=> &$GLOBALS['TL_LANG']['tl_wsbo'],
			'exclude'			=> false,
			'sorting'			=> true,
			'flag'				=> 11,
			'inputType'			=> 'text',
			'eval'				=> array(
				'digit'		=>	true,
				'unique'	=>	false,
				'tl_class'=>'w50'
				),
			'sql'                     => "float(11,2) NULL"
		),
		'wsbo_t1' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_wsbo']['descript'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'flag'                    => 11,
			'search'                  => true,
			'eval'                    => array('mandatory'=>false, 'alphanum'=>true, 'maxlength'=>11, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL"
		),
		'wsbo_t2' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_wsbo']['descript'],
			'inputType'               => 'text',
			'exclude'                 => false,
			'flag'                    => 11,
			'search'                  => true,
			'eval'                    => array('mandatory'=>false, 'alphanum'=>true, 'maxlength'=>11, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL"
		),
	)
);
/*Classes*/
class tl_wsbo extends Backend {	
	
}
