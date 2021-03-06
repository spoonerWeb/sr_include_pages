<?php
defined ('TYPO3_MODE') || die ('Access denied.');

$tempColumns = array (
	'tx_srincludepages_pages' => array (
		'exclude' => 0,
		'label' => 'LLL:EXT:sr_include_pages/locallang_db.php:tt_content.tx_srincludepages_pages',
		'config' => array (
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'pages',
			'size' => '5',
			'maxitems' => 50,
			'minitems' => 1,
			'show_thumbs' => 1,
		)
	),
	'tx_srincludepages_column' => array(),
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns, 1);
$TCA['tt_content']['columns']['tx_srincludepages_column'] = $TCA['tt_content']['columns']['colPos'];
$TCA['tt_content']['columns']['tx_srincludepages_column']['exclude'] = 0;
$TCA['tt_content']['types'][$_EXTKEY.'_pi1']['showitem'] = 'CType;;4;button;1-1-1,
	header;;3;;2-2-2,
	tx_srincludepages_pages;;;;3-3-3,recursive,tx_srincludepages_column';


$TCA['tt_content']['ctrl']['typeicons'][$_EXTKEY.'_pi1'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'ext_icon.gif';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
	array(
		'LLL:EXT:sr_include_pages/locallang_db.php:tt_content.CType', $_EXTKEY . '_pi1'
	),
	'CType'
);

if (TYPO3_MODE=='BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_srincludepages_pi1_wizicon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'pi1/class.tx_srincludepages_pi1_wizicon.php';
}
?>

