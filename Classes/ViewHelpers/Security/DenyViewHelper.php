<?php
namespace Scarbous\MrControllerAccess\ViewHelpers\Security;

use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\ChildNodeAccessInterface;

class DenyViewHelper extends AbstractSecurityViewHelper implements ChildNodeAccessInterface {

	/**
	 * Render deny - i.e. render "else" child only if arguments are satisfied,
	 * resulting in an inverse match.
	 *
	 * @return string
	 */
	public function render() {
		$evaluation = $this->evaluateArguments();
		if (FALSE === $evaluation) {
			return $this->renderThenChild();
		} else {
			return $this->renderElseChild();
		}
	}

}
