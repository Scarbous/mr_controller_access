<?php
namespace Scarbous\MrControllerAccess\ControllerAccessValidator\Fe;


use \Scarbous\MrControllerAccess\Utility\FeAccessUtility;

class UserGroup extends AbstractFeAccessValidator
{
    public function isValid()
    {
        return FeAccessUtility::userGroup($this->controllerName, $this->actionName);

    }
}