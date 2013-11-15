<?php
namespace FNagel\Beautyofcode\Service;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Thomas Juhnke <tommy@van-tomas.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('t3jquery')) {
	require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('t3jquery') . 'class.tx_t3jquery.php');
}

/**
 * Service which adds and generates all necessary assets for the jquery version
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class JqueryAssetService extends \FNagel\Beautyofcode\Service\AbstractVersionAssetService {

	/**
	 *
	 * @var string
	 */
	protected $templatePathAndFilename = 'typo3conf/ext/beautyofcode/Resources/Private/Templates/Inline/Jquery.js';

	/**
	 * (non-PHPdoc)
	 * @see \FNagel\Beautyofcode\Service\AbstractVersionAssetService::load()
	 */
	public function load() {
		$this->addJavascriptLibraries();

		$this->addInlineJavascript();
	}

	/**
	 *
	 * @return void
	 */
	protected function addJavascriptLibraries() {
		$addJquery = (boolean) $this->configuration['addjQuery'];
		$addJqueryFromT3Jquery = T3JQUERY === TRUE;

		if ($addJquery && $addJqueryFromT3Jquery) {
			\tx_t3jquery::addJqJS();
		}
		if ($addJquery && !$addJqueryFromT3Jquery) {
			$this->pageRenderer->addJsFooterLibrary(
				'beautyofcode_jquery',
				$this
					->typoscriptFrontendController
					->tmpl
					->getFileName(
						'EXT:beautyofcode/Resources/Public/Javascript/vendor/jquery/jquery-1.3.2.min.js'
					)
			);
		}

		$this->pageRenderer->addJsFooterLibrary(
			'beautyofcode_boc',
			$this->bocGeneralUtility->makeAbsolutePath(trim($this->configuration['scriptUrl']))
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see \FNagel\Beautyofcode\Service\AbstractLibraryService::getCssConfig()
	 */
	public function getClassAttributeConfiguration($config = array()) {
		$string = '';

		foreach ($config as $configKey => $configValue) {
			if ($configValue == '' || $configValue == 'auto') {
				continue;
			}

			if ($configKey == 'highlight') {
				$string .= sprintf(' boc-highlight[%s]',
					\TYPO3\CMS\Core\Utility\GeneralUtility::expandList($configValue)
				);
			} else {
				$string .= sprintf(' boc-%s%s',
					$configValue ? '' : 'no-',
					$configKey
				);
			}
		}

		return $string;
	}
}
?>