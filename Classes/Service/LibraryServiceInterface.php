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
/**
 * Class short description
 *
 * Class long description
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
interface LibraryServiceInterface extends \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * Sets the configuration manager from the controller
	 *
	 * This is necessary, as the flud standalone view otherwise creates its own
	 * ContentObjectRenderer instance. It seems there is a race conditon and the
	 * content object within the controller gets the instance from the service
	 * and returns an empty `data` array and no flexform values.
	 *
	 * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
	 */
	public function setConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager);

	/**
	 *
	 * @param string $library
	 */
	public function load($library);

	/**
	 * Returns the class attribute configuration string for the concrete service
	 *
	 * @param array $config
	 * @return string
	 */
	public function getClassAttributeConfiguration($config = array());
}
?>