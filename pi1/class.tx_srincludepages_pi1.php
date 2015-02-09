<?php
	/***************************************************************
	*  Copyright notice
	*
	*  (c) 2004-2005 Stanislas Rolland (stanislas.rolland@fructifor.ca)
	*  All rights reserved
	*
	*  This script is part of the Typo3 project. The Typo3 project is
	*  free software; you can redistribute it and/or modify
	*  it under the terms of the GNU General Public License as published by
	*  the Free Software Foundation; either version 2 of the License, or
	*  (at your option) any later version.
	*
	*  The GNU General Public License can be found at
	*  http://www.gnu.org/copyleft/gpl.html.
	*
	*  This script is distributed in the hope that it will be useful,
	*  but WITHOUT ANY WARRANTY; without even the implied warranty of
	*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	*  GNU General Public License for more details.
	*
	*  This copyright notice MUST APPEAR in all copies of the script!
	***************************************************************/
	/**
	* Plugin 'Pages included' for the 'sr_include_pages' extension.
	*
	* @author Stanislas Rolland <stanislas.rolland@fructifor.ca>
	*
	*/
	require_once(PATH_tslib.'class.tslib_pibase.php');

	class tx_srincludepages_pi1 extends tslib_pibase {
		var $prefixId = 'tx_srincludepages_pi1';  // Same as class name
		var $scriptRelPath = 'pi1/class.tx_srincludepages_pi1.php'; // Path to this script relative to the extension dir.
		var $extKey = 'sr_include_pages'; // The extension key.

		/**
		 * Main function of this class
		 *
		 * @param	string		$content: entry content
		 * @param	array		$conf: TS setup array
		 * @return	string		rendered content
		 */
		function main($content, $conf) {
			$this->conf = $conf;
			$this->pi_setPiVarDefaults();
			$content = '';

			$pidInList = isset($this->cObj->data['tx_srincludepages_pages']) ? $this->cObj->data['tx_srincludepages_pages'] : $this->conf['pidInList'];
			$recursive = isset($this->cObj->data['recursive']) ? $this->cObj->data['recursive'] : $this->conf['recursive'];
			$colPos = isset($this->cObj->data['tx_srincludepages_column']) ? $this->cObj->data['tx_srincludepages_column'] : $this->conf['colPos'];

			if (trim($pidInList)) {
				/* Process pages from the included pages list, possibly recursively */
				$includedPagesArray = t3lib_div::trimExplode(',',$pidInList,1);
				reset($includedPagesArray);
				while (list(, $pageUid) = each($includedPagesArray) ) {
					if( $pageUid != $GLOBALS['TSFE']->id ) {  // Avoid loop on the current page
						$recursivePagesList = $pageUid.','.$this->cObj->getTreeList($pageUid,$recursive);
						$recursivePagesArray = t3lib_div::trimExplode(',',$recursivePagesList,1);
						reset($recursivePagesArray);
						while (list(, $recursivePageUid) = each($recursivePagesArray) ) {
							if( $recursivePageUid != $GLOBALS['TSFE']->id ) {  // Avoid loop on the current page
								$query = array(
									'table' => 'tt_content',
									'select.' => array(
										'pidInList' => $recursivePageUid,
										'orderBy' => 'sorting',
										'where' => 'colPos = ' . $colPos . ' AND CType != "'.$this->extKey.'_pi1 "'.$this->cObj->enableFields('tt_content'),   // Avoid any loop
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

	if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/sr_include_pages/pi1/class.tx_srincludepages_pi1.php"]) {
		include_once($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/sr_include_pages/pi1/class.tx_srincludepages_pi1.php"]);
	}

?>