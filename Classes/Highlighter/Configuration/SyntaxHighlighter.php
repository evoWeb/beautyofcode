<?php

namespace TYPO3\Beautyofcode\Highlighter\Configuration;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * SyntaxHighlighter.
 *
 * @author Thomas Juhnke <typo3@van-tomas.de>
 */
class SyntaxHighlighter extends AbstractConfiguration
{
    /**
     * Failsafe brush alias map.
     *
     * Fallback from one highlighter engine to another.
     * Key Prism SH CSS class and value is SH CSS class.
     *
     * @var array
     */
    protected $failSafeBrushAliasMap = [
        'Prism' => [
            'actionscript' => 'actionscript3',
            'c' => 'cpp',
            'coffeescript' => 'javascript',
            'gherkin' => 'plain',
            'git' => 'plain',
            'go' => 'plain',
            'http' => 'plain',
            'less' => 'plain',
            'markdown' => 'plain',
            'markup' => 'xml',
            'scss' => 'sass',
            'twig' => 'plain',
            'yaml' => 'plain',
        ],
    ];

    /**
     * A CSS class/label map for the select box.
     *
     * Key is the brush string from TS Setup; Value is an array with the CSS
     * class in key 0 and the label for the select box in key 1
     *
     * @var array
     */
    protected $brushIdentifierAliasLabelMap = [
        'AppleScript' => ['applescript', 'AppleScript'],
        'AS3' => ['actionscript3', 'Actionscript 3'],
        'Bash' => ['bash', 'Bash / Shell'],
        'ColdFusion' => ['coldfusion', 'ColdFusion'],
        'Cpp' => ['cpp', 'C / C++'],
        'CSharp' => ['csharp', 'C#'],
        'Css' => ['css', 'CSS'],
        'Delphi' => ['delphi', 'Delphi / Pas / Pascal'],
        'Diff' => ['diff', 'Diff / Patch'],
        'Erlang' => ['erlang', 'Erlang'],
        'Groovy' => ['groovy', 'Groovy'],
        'Java' => ['java', 'Java'],
        'JavaFX' => ['javafx', 'Java FX'],
        'JScript' => ['javascript', 'Java-Script'],
        'Perl' => ['perl', 'Perl'],
        'Php' => ['php', 'PHP'],
        'PowerShell' => ['powershell', 'Power-Shell'],
        'Python' => ['python', 'Python'],
        'Ruby' => ['ruby', 'Ruby on Rails'],
        'Sass' => ['sass', 'Sass'],
        'Scala' => ['scala', 'Scala'],
        'Sql' => ['sql', 'SQL / MySQL'],
        'Typoscript' => ['typoscript', 'Typoscript'],
        'Vb' => ['vbnet', 'Virtual Basic / .Net'],
        'Xml' => ['xml', 'XML / XSLT / XHTML / HTML'],
    ];

    /**
     * GetAutoloaderBrushMap.
     *
     * @return array
     */
    public function getAutoloaderBrushMap()
    {
        $brushes = [];

        $configuredBrushes = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(
            ',',
            $this->settings['brushes']
        );

        $brushes['plain'] = 'shBrushPlain.js';

        foreach ($configuredBrushes as $brush) {
            list($cssTag) = $this->brushIdentifierAliasLabelMap[$brush];
            $brushPath = 'shBrush' . $brush . '.js';

            $brushes[$cssTag] = $brushPath;
        }

        return $brushes;
    }

    /**
     * GetClassAttributeString.
     *
     * @param \TYPO3\Beautyofcode\Domain\Model\Flexform $flexform Flexform
     *
     * @return string
     */
    public function getClassAttributeString(\TYPO3\Beautyofcode\Domain\Model\Flexform $flexform)
    {
        $configurationItems = [];

        $classAttributeConfigurationStack = [
            'highlight' => \TYPO3\CMS\Core\Utility\GeneralUtility::expandList($flexform->getCHighlight()),
            'gutter' => $flexform->getCGutter(),
            'collapse' => $flexform->getCCollapse(),
        ];

        foreach ($classAttributeConfigurationStack as $configurationKey => $configurationValue) {
            if (true === in_array($configurationValue, ['', 'auto'])) {
                continue;
            }

            if ($configurationKey === 'highlight') {
                $key = $configurationKey;
                $value = sprintf('[%s]', $configurationValue);
            } else {
                $key = $configurationKey;
                $value = var_export((boolean)$configurationValue, true);
            }

            $configurationItems[] = sprintf('%s: %s', $key, $value);
        }

        return '; ' . implode('; ', $configurationItems);
    }
}
