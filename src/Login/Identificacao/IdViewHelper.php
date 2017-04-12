<?php
namespace Ecompassaro\Login\Identificacao;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;

class IdViewHelper extends AbstractHelper
{
    private $authenticationService;

    /**
     * Retorna o usuario atual
     */
    public function __invoke()
    {
        $identify = $this->authenticationService->getIdentity();
        if($identify) {
            return $identify->getId();
        }
        return null;
    }

    /**
     * Injeta dependências
     * @param \Zend\Authentication\AuthenticationService $authenticationService
     */
    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }
}
