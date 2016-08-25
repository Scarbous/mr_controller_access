<?php
namespace Scarbous\MrControllerAccess\ControllerAccessValidator;

use TYPO3\CMS\Core\Utility\GeneralUtility,
    \TYPO3\CMS\Extbase\Object\ObjectManager,
    TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

abstract class AbstractAccessValidator implements AccessValidatorInterface
{
    /**
     * @var \Scarbous\MrControllerAccess\Controller\AbstractController
     */
    protected $class;
    /**
     * @var string
     */
    protected $extensionName;
    /**
     * @var
     */
    protected $controllerName;
    /**
     * @var
     */
    protected $actionName;
    /**
     * @var
     */
    protected $settings;

    /**
     * @param \Scarbous\MrControllerAccess\Controller\AbstractController $class
     * @param string $extensionName
     * @param string $controllerName
     * @param string $actionName
     * @return bool
     */
    public function __construct(&$class, $extensionName, $controllerName, $actionName)
    {
        $this->class = $class;
        $this->extensionName = $extensionName;
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;

        $this->loadTypoScriptSettings();
    }

    /**
     *
     */
    private function loadTypoScriptSettings()
    {
        /* @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /* @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager */
        $configurationManager = $objectManager->get(ConfigurationManagerInterface::class);

        $frameworkConfiguration = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK
        );
        $this->settings = $frameworkConfiguration['settings'];
    }
}