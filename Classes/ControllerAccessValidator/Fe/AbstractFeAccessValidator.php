<?php
namespace Scarbous\MrControllerAccess\ControllerAccessValidator\Fe;

use Scarbous\MrControllerAccess\ControllerAccessValidator\AbstractAccessValidator;

abstract class AbstractFeAccessValidator extends AbstractAccessValidator
{
    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository;

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository $frontendUserRepository
     * @return void
     */
    public function injectFrontendUserRepository(\TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository $frontendUserRepository)
    {
        $this->frontendUserRepository = $frontendUserRepository;
    }

    /*
     *
     * @return FrontendUser|NULL
     */
    protected function getCurrentFrontendUser()
    {
        if (TRUE === empty($GLOBALS['TSFE']->loginUser)) {
            return NULL;
        }
        return $this->frontendUserRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
    }
}