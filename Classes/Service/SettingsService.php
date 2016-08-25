<?php

namespace Scarbous\MrControllerAccess\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Service to get the configuration of the current plugin
 *
 * Example
 * $pluginSettingsService = GeneralUtility::makeInstance(\Scarbous\MrControllerAccess\Service\SettingsService::class);
 * $settings = $pluginSettingsService->getSettings();
 *
 */
class SettingsService
{

    /**
     * @var mixed
     */
    protected $settings = null;


    /**
     * Returns all settings.
     *
     * @return array
     */
    public function getSettings()
    {
        if ($this->settings === null) {
            /* @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

            /* @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager */
            $configurationManager = $objectManager->get(ConfigurationManagerInterface::class);

            $frameworkConfiguration = $configurationManager->getConfiguration(
                ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
            );
            $this->settings = $frameworkConfiguration['settings'];
        }
        return $this->settings;
    }
}