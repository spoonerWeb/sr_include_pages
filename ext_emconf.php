<?php

########################################################################
# Extension Manager/Repository config file for ext: "sr_include_pages"
#
# Auto generated 03-07-2009 15:28
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Included pages',
	'description' => 'Adds a content element type that allows to include on a page all content elements from a list of pages and from a given column. The list of pages may be recursive. Only content in current language is selected.',
	'category' => 'fe',
	'shy' => 0,
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'tt_content',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author' => 'Stanislas Rolland',
	'author_email' => 'stanislas.rolland@fructifor.ca',
	'author_company' => 'Fructifor Inc.',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'version' => '1.0.1',
	'constraints' => array(
		'depends' => array(
			'php' => '3.0.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:9:{s:12:"ext_icon.gif";s:4:"6f9c";s:17:"ext_localconf.php";s:4:"d39b";s:14:"ext_tables.php";s:4:"c938";s:14:"ext_tables.sql";s:4:"558e";s:13:"locallang.php";s:4:"915c";s:16:"locallang_db.php";s:4:"dbaa";s:14:"pi1/ce_wiz.gif";s:4:"4264";s:35:"pi1/class.tx_srincludepages_pi1.php";s:4:"f056";s:43:"pi1/class.tx_srincludepages_pi1_wizicon.php";s:4:"06b7";}',
);

?>