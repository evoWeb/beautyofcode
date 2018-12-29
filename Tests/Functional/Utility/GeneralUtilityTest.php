<?php

namespace TYPO3\Beautyofcode\Tests\Functional\Utility;

/***************************************************************
 * Copyright notice
 *
 * (c) 2013 ...
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Tests the general utility class.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @link http://www.van-tomas.de/
 */
class GeneralUtilityTest extends \TYPO3\TestingFramework\Core\Functional\FunctionalTestCase
{
    /**
     * @var array
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/beautyofcode'];

    /**
     * @test
     */
    public function prefixingWithExtReturnsPathSiteAbsolutePathToExtensionFile()
    {
        $path = \TYPO3\Beautyofcode\Utility\GeneralUtility::makeAbsolutePath(
            'EXT:beautyofcode/ext_emconf.php'
        );

        $this->assertStringStartsWith('typo3conf/', $path);
    }

    /**
     * @test
     */
    public function prefixingWithFileReturnsPathSiteAbsolutePathToFile()
    {
        define('TYPO3_OS', !stristr(PHP_OS, 'darwin') && stristr(PHP_OS, 'win') ? 'WIN' : '');
        $path = \TYPO3\Beautyofcode\Utility\GeneralUtility::makeAbsolutePath('FILE:fileadmin/test.js');

        $this->assertStringStartsWith('fileadmin/', $path);
    }

    /**
     * @test
     */
    public function passingInAnExternalUrlWillReturnItUntouched()
    {
        $externalPath = 'http://www.example.org/test.js';

        $path = \TYPO3\Beautyofcode\Utility\GeneralUtility::makeAbsolutePath($externalPath);

        $this->assertEquals($externalPath, $path);
    }

    /**
     * @test
     */
    public function passingInCombinedFileAndExtNotationWillReturnPathSiteAbsolutePathToExtensionFile()
    {
        $path = \TYPO3\Beautyofcode\Utility\GeneralUtility::makeAbsolutePath('FILE:EXT:beautyofcode/ext_localconf.php');

        $this->assertStringStartsWith('typo3conf/', $path);
    }

    /**
     * @test
     */
    public function passingInACompletelyInvalidPathLeavesItUntouched()
    {
        $invalidPath = 'foo://bar.jpeg';

        $path = \TYPO3\Beautyofcode\Utility\GeneralUtility::makeAbsolutePath($invalidPath);

        $this->assertEquals($invalidPath, $path);
    }

    /**
     * @test
     */
    public function passingFileNotationWithExternalUrlWillReturnAnEmptyString()
    {
        $invalidExternalPath = 'FILE:http://example.org/test.js';

        $path = \TYPO3\Beautyofcode\Utility\GeneralUtility::makeAbsolutePath($invalidExternalPath);

        $this->assertEquals('', $path);
    }
}
