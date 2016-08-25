<?php
namespace Scarbous\MrControllerAccess\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class FeAccessUtility
{
    static public function userGroup($controllerName, $actionName)
    {

        $pluginSettingsService = GeneralUtility::makeInstance(\Scarbous\MrControllerAccess\Service\SettingsService::class);
        $settings = $pluginSettingsService->getSettings();

        if (!($userGroups = $settings['controllerAccess'][$controllerName][$actionName]['UserGroups']))
            return true;

        $userGroups = explode(',', $userGroups);
        foreach ($userGroups as $userGroup) {
            if (in_array($userGroup, $GLOBALS['TSFE']->fe_user->groupData['uid']))
                return true;
        }

        return false;

    }

}