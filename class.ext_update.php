<?php
/***************************************************************
 * Copyright notice
 *
 * (c) 2013 Thomas Juhnke <typo3@van-tomas.de>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Updates tt_content records.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class ext_update
{
    /**
     * TYPO3.CMS global DatabaseConnection.
     *
     * @var \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    protected $db;

    /**
     * Amount of old plugins detected.
     *
     * @var int
     */
    protected $countOldPlugins;

    /**
     * Initializes the updater.
     */
    protected function initialize()
    {
        if (false === isset($this->db)) {
            $this->db = $GLOBALS['TYPO3_DB'];
        }
    }

    /**
     * Checks if the update script must be run.
     *
     * @return bool
     */
    public function access()
    {
        $this->initialize();

        $hasOldPlugins = $this->hasInstanceOldPlugins();

        return $hasOldPlugins;
    }

    /**
     * Counts the amount of old plugin instances within tt_content records.
     *
     * @return bool
     */
    protected function hasInstanceOldPlugins()
    {
        $this->countOldPlugins = $this->db->exec_SELECTcountRows('*', 'tt_content', 'list_type = "beautyofcode_contentrenderer"');

        return 0 < $this->countOldPlugins;
    }

    /**
     * Executes the update script.
     *
     * @return string
     */
    public function main()
    {
        $this->initialize();

        $output = '';

        if ($this->hasInstanceOldPlugins()) {
            $output .= $this->updateOldPlugins();
        }

        if ($output === '') {
            $output = 'Nothing needs to be updated.';
        }

        return $output;
    }

    /**
     * Updates tt_content records by setting `list_type` to new plugin signature.
     *
     * @return string
     */
    protected function updateOldPlugins()
    {
        // switch from CType = 'list' to custom CE
        $this->db->exec_UPDATEquery(
            'tt_content',
            'list_type = "beautyofcode_contentrenderer"',
            [
                'CType' => 'beautyofcode_contentrenderer',
                'list_type' => '',
            ]
        );

        $contentElements = $this->db->exec_SELECTquery(
            'uid, pi_flexform',
            'tt_content',
            'CType = "beautyofcode_contentrenderer" AND hidden = 0 AND deleted = 0'
        );

        while (($contentElement = $this->db->sql_fetch_assoc($contentElements))) {
            $uid = (int)$contentElement['uid'];
            $flexformData = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($contentElement['pi_flexform']);

            try {
                $codeBlock = \TYPO3\CMS\Core\Utility\ArrayUtility::getValueByPath($flexformData, 'data/sDEF/lDEF/cCode/vDEF');
            } catch (\Exception $exc) {
                continue;
            }

            $this->db->exec_UPDATEquery(
                'tt_content',
                'uid = ' . $uid,
                [
                    'bodytext' => $codeBlock,
                ]
            );
        }

        return sprintf('<p>Updated plugin signature of %s tt_content records.</p>', $this->countOldPlugins);
    }
}
