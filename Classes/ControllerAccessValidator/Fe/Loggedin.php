<?php
namespace Scarbous\MrControllerAccess\ControllerAccessValidator\Fe;

class Loggedin extends AbstractFeAccessValidator
{
    /**
     * @return bool
     */
    function isValid()
    {
        $currentFrontendUser = $this->getCurrentFrontendUser();
        if (TRUE === $currentFrontendUser instanceof FrontendUser) {
            return TRUE;
        }

        return false;
    }
}