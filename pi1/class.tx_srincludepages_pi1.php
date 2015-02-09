<?php
/**
 * This file is part of the TYPO3 CMS project.
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Plugin\AbstractPlugin;

/**
 * Plugin 'Pages included' for the 'sr_include_pages' extension.
 * @author Stanislas Rolland <stanislas.rolland@fructifor.ca>
 * @author Thomas Löffler <loeffler@spooner-web.de>
 */
class tx_srincludepages_pi1 extends AbstractPlugin {

	/**
	 * @var string
	 */
	public $prefixId = 'tx_srincludepages_pi1';

	/**
	 * @var string
	 */
	public $scriptRelPath = 'pi1/class.tx_srincludepages_pi1.php';

	/**
	 * @var string
	 */
	public $extKey = 'sr_include_pages';

	/**
	 * Main function of this class
	 * @param    string $content : entry content
	 * @param    array $conf : TS setup array
	 * @return    string        rendered content
	 */
	public function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$content = '';

		$pidInList = isset($this->cObj->data['tx_srincludepages_pages']) ? $this->cObj->data['tx_srincludepages_pages'] : $this->conf['pidInList'];
		$recursive = isset($this->cObj->data['recursive']) ? $this->cObj->data['recursive'] : $this->conf['recursive'];
		$colPos = isset($this->cObj->data['tx_srincludepages_column']) ? $this->cObj->data['tx_srincludepages_column'] : $this->conf['colPos'];

		if (trim($pidInList)) {
			/* Process pages from the included pages list, possibly recursively */
			$includedPagesArray = GeneralUtility::trimExplode(',', $pidInList, 1);
			reset($includedPagesArray);
			while (list(, $pageUid) = each($includedPagesArray)) {
				if ($pageUid != $GLOBALS['TSFE']->id) {  // Avoid loop on the current page
					$recursivePagesList = $pageUid . ',' . $this->cObj->getTreeList($pageUid, $recursive);
					$recursivePagesArray = GeneralUtility::trimExplode(',', $recursivePagesList, 1);
					reset($recursivePagesArray);
					while (list(, $recursivePageUid) = each($recursivePagesArray)) {
						if ($recursivePageUid != $GLOBALS['TSFE']->id) {  // Avoid loop on the current page
							$query = array(
								'table' => 'tt_content',
								'select.' => array(
									'pidInList' => $recursivePageUid,
									'orderBy' => 'sorting',
									'where' => 'colPos = ' . $colPos . ' AND CType != "' . $this->extKey . '_pi1 "' . $this->cObj->enableFields('tt_content'),   // Avoid any loop
									'languageField' => 'sys_language_uid'
								)
							);
							if ($this->conf['renderObj']) {
								$query['renderObj'] = $this->conf['renderObj'];
								$query['renderObj.'] = $this->conf['renderObj.'];
							}
							$content .= $GLOBALS['TSFE']->cObj->CONTENT($query);
						}
					}
				}
			}
		}

		return $this->pi_wrapInBaseClass($content);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sr_include_pages/pi1/class.tx_srincludepages_pi1.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sr_include_pages/pi1/class.tx_srincludepages_pi1.php']);
}