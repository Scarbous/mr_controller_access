<?php
namespace Scarbous\MrControllerAccess\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility,
    TYPO3\CMS\Core\Utility\HttpUtility;

abstract class ActionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var \TYPO3\CMS\Extbase\Reflection\ReflectionService
     * @inject
     */
    protected $reflectionService;

    /*
     * @return void
     */
    function initializeAction()
    {
        parent::initializeAction();
        $this->checkAccessRules();
    }

    protected function checkAccessRules()
    {
        $annotations = $this->reflectionService->getMethodTagsValues(get_class($this), $this->actionMethodName);
        $access = true;

        if($annotations['accessValidator']){
            foreach($annotations['accessValidator'] as $accessValidator) {
                if(!class_exists($accessValidator)){
                    $accessValidator = 'Scarbous\\MrControllerAccess\\ControllerAccessValidator\\'.$accessValidator;
                }
                $access = GeneralUtility::makeInstance(
                    $accessValidator,
                    $this,
                    $this->request->getControllerExtensionName(),
                    $this->request->getControllerName(),
                    $this->request->getControllerActionName()
                )->isValid();
            }
        }
        if(!$access) {
            HttpUtility::setResponseCodeAndExit(HttpUtility::HTTP_STATUS_401);
        }
    }

}