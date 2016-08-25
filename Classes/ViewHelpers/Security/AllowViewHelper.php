<?php
namespace Scarbous\MrControllerAccess\ViewHelpers\Security;

use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\ChildNodeAccessInterface;

class AllowViewHelper extends AbstractSecurityViewHelper implements ChildNodeAccessInterface {

    /**
     * Render allow - i.e. render "then" child if arguments are satisfied
     *
     * @return string
     */
    public function render() {
        $evaluation = $this->evaluateArguments();
        if (TRUE === $evaluation) {
            return $this->renderThenChild();
        } else {
            return $this->renderElseChild();
        }
    }

}
