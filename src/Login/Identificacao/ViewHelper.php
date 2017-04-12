<?php
namespace Ecompassaro\Login\Identificacao;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;

class ViewHelper extends AbstractHelper
{
    private $authenticationService;

    /**
     * Retorna se existe identificação autenticada
     * @return boolean
     */
    public function __invoke()
    {
        return $this->authenticationService->hasIdentity();
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
