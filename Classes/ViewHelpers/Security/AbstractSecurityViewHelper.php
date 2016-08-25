<?php
namespace Scarbous\MrControllerAccess\ViewHelpers\Security;

use Scarbous\MrControllerAccess\Utility\FeAccessUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup;
use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractConditionViewHelper;
use TYPO3\CMS\Extbase\Mvc\Request;

abstract class AbstractSecurityViewHelper extends AbstractConditionViewHelper
{

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     */
    protected $frontendUserRepository;

    /**
     * @var array
     */
    protected $settings;

    /**
     * @return NULL
     */
    public function render()
    {
        return NULL;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository $frontendUserRepository
     * @return void
     */
    public function injectFrontendUserRepository(FrontendUserRepository $frontendUserRepository)
    {
        $this->frontendUserRepository = $frontendUserRepository;
        $query = $this->frontendUserRepository->createQuery();
        $querySettings = $query->getQuerySettings();
        $querySettings->setRespectStoragePage(FALSE);
        $querySettings->setRespectSysLanguage(FALSE);
        $this->frontendUserRepository->setDefaultQuerySettings($querySettings);
    }

    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('extensionName', 'string', true);
        $this->registerArgument('action', 'string', true);
        $this->registerArgument('controller', 'string', false);
    }

    /**
     * Returns TRUE if all conditions from arguments are satisfied. The
     * type of evaluation (AND or OR) can be set using argument "evaluationType"
     *
     * @return boolean
     */
    protected function evaluateArguments()
    {
        $actionName = $this->arguments['action'];
        $controllerName = $this->arguments['controller'] ?: $this->controllerContext->getRequest()->getControllerName();
        $extensionName = $this->arguments['extensionName'] ?: $this->controllerContext->getRequest()->getControllerExtensionName();

        $result = FeAccessUtility::userGroup($controllerName, $actionName);

        return $result;
    }

    /**
     * Override: forcibly disables page caching - a TRUE condition
     * in this ViewHelper means page content would be depending on
     * the current visitor's session/cookie/auth etc.
     *
     * Returns value of "then" attribute.
     * If then attribute is not set, iterates through child nodes and renders ThenViewHelper.
     * If then attribute is not set and no ThenViewHelper and no ElseViewHelper is found, all child nodes are rendered
     *
     * @return string rendered ThenViewHelper or contents of <f:if> if no ThenViewHelper was found
     * @api
     */
    protected function renderThenChild()
    {
        if (TRUE === $this->isFrontendContext()) {
            $GLOBALS['TSFE']->no_cache = 1;
        }
        return parent::renderThenChild();
    }

    /**
     * @return boolean
     */
    protected function isFrontendContext()
    {
        return 'FE' === TYPO3_MODE;
    }

}
