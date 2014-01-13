<?php
namespace TYPO3\Beautyofcode\Tests\Unit\Domain;

/***************************************************************
 * Copyright notice
 *
 * (c) 2013 Thomas Juhnke <typo3@van-tomas.de>
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
 * Tests the flexform domain object
 *
 * @package \TYPO3\Beautyofcode\Tests\Unit\Domain
 * @author Thomas Juhnke <typo3@van-tomas.de>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @link http://www.van-tomas.de/
 */
class FlexformTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

	/**
	 *
	 * @var \TYPO3\Beautyofcode\Domain\Model\Flexform
	 */
	protected $sut;

	public function setUp() {
		$this->sut = new \TYPO3\Beautyofcode\Domain\Model\Flexform();
		$this->sut->setCLabel('The label');
		$this->sut->setCLang('typoscript');
		$this->sut->setCCode('page = PAGE\npage.10 = TEXT\npage.10.value = Hello World!');
		$this->sut->setCHighlight('1,2-3,8');
		$this->sut->setCCollapse('1');
		$this->sut->setCGutter('1');
		$this->sut->setCToolbar('1');
		$this->sut->setBrushes('Xml,Php,Typoscript');
	}

	/**
	 *
	 * @test
	 */
	public function settingAnEmptyValueForJQueryLibraryWillSkipTheOutputForTheSetting() {
		$this->sut->setCCollapse('');

		$this->assertNotContains('collapse', $this->sut->getJqueryClassAttributeConfiguration());
	}

	/**
	 *
	 * @test
	 */
	public function settingAutoValueForJQueryLibraryWillSkipTheOutputForTheSetting() {
		$this->sut->setCGutter('auto');

		$this->assertNotContains('gutter', $this->sut->getJqueryClassAttributeConfiguration());
	}

	/**
	 *
	 * @test
	 */
	public function settingAnEmptyValueForStandaloneLibraryWillSkipTheOutputForTheSetting() {
		$this->sut->setCCollapse('');

		$this->assertNotContains('collapse', $this->sut->getStandaloneClassAttributeConfiguration());
	}

	/**
	 *
	 * @test
	 */
	public function settingAutoValueForStandaloneLibraryWillSkipTheOutputForTheSetting() {
		$this->sut->setCGutter('auto');

		$this->assertNotContains('gutter', $this->sut->getStandaloneClassAttributeConfiguration());
	}

	/**
	 *
	 * @test
	 */
	public function standaloneLibraryClassAttributeConfigurationWillNotContainAToolbarSetting() {
		$this->sut->setCToolbar('1');

		$this->assertNotContains('toolbar', $this->sut->getStandaloneClassAttributeConfiguration());
	}

	/**
	 *
	 * @test
	 */
	public function highlightSettingHasSpecialFormattingForJQueryLibrary() {
		$this->assertContains('boc-highlight[', $this->sut->getJqueryClassAttributeConfiguration());
	}

	/**
	 *
	 * @test
	 */
	public function highlightSettingHasSpecialFormattingForStandaloneLibrary() {
		$this->assertContains('highlight: [', $this->sut->getStandaloneClassAttributeConfiguration());
	}

	/**
	 *
	 * @test
	 */
	public function highlightSettingWillBeExpandedForJQueryLibrary() {
		$this->assertContains('boc-highlight[1,2,3,8]', $this->sut->getJqueryClassAttributeConfiguration());
	}

	/**
	 *
	 * @test
	 */
	public function highlightSettingWilllBeExpandedForStandaloneLibrary() {
		$this->assertContains('highlight: [1,2,3,8]', $this->sut->getStandaloneClassAttributeConfiguration());
	}

	/**
	 *
	 * @test
	 */
	public function nonEmptySettingWillResultInAnPrefixedSettingStringForJQueryLibrary() {
		$this->assertContains('boc-collapse', $this->sut->getJqueryClassAttributeConfiguration());
	}

	/**
	 *
	 * @test
	 */
	public function boolishTrueSettingWillResultInAPrefixedSettingStringContainingTheConfigurationKeyForJqueryLibrary() {
		$this->assertContains('boc-collapse', $this->sut->getJqueryClassAttributeConfiguration());
	}

	/**
	 *
	 * @test
	 */
	public function boolishFalseSettingWillResultInAPrefixedSettingStringContainingTheConfigurationKeyAndNoForJqueryLibrary() {
		$this->sut->setCCollapse('0');

		$this->assertContains('boc-no-collapse', $this->sut->getJqueryClassAttributeConfiguration());
	}

	/**
	 *
	 * @test
	 */
	public function plainBrushIsAlwaysAvailableInAutoloaderBrushesStackForStandaloneLibrary() {
		$brushes = $this->sut->getStandaloneBrushesForAutoloader();

		$this->assertArrayHasKey('plain', $brushes);
	}

	/**
	 *
	 * @test
	 */
	public function brushesForStandaloneLibraryAreMappedToASuitableCssTagString() {
		$this->sut->setBrushes('Typoscript,AS3');

		$brushes = $this->sut->getStandaloneBrushesForAutoloader();

		$this->assertArrayHasKey('typoscript', $brushes);
		$this->assertArrayHasKey('actionscript3', $brushes);
	}

	/**
	 *
	 * @test
	 */
	public function getIsGutterActiveReturnsFalseIfInstanceIsSetToZero() {
		$this->sut->setCGutter('0');

		$this->assertFalse($this->sut->getIsGutterActive());
	}

	/**
	 *
	 * @test
	 */
	public function getIsGutterActiveReturnsTrueIfInstanceIsSetToOne() {
		$this->sut->setCGutter('1');

		$this->assertTrue($this->sut->getIsGutterActive());
	}

	/**
	 *
	 * @test
	 */
	public function getIsGutterActiveReturnsFalseIfInstanceIsSetToAutoAndDefaultValueIsFalsy() {
		$this->sut->setCGutter('auto');
		$this->sut->setTyposcriptDefaults(array('gutter' => ''));

		$this->assertFalse($this->sut->getIsGutterActive());
	}

	/**
	 *
	 * @test
	 */
	public function getIsGutterActiveReturnsFalseIfInstanceIsSetToAutoAndDefaultValueIsOff() {
		$this->sut->setCGutter('auto');
		$this->sut->setTyposcriptDefaults(array('gutter' => '0'));

		$this->assertFalse($this->sut->getIsGutterActive());
	}

	/**
	 *
	 * @test
	 */
	public function getIsGutterActiveReturnsTrueIfInstanceIsSetToAutoAndDefaultValueIsOn() {
		$this->sut->setCGutter('auto');
		$this->sut->setTyposcriptDefaults(array('gutter' => '1'));

		$this->assertTrue($this->sut->getIsGutterActive());
	}
}
?>