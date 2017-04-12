<?php
namespace Ecompassaro\Login\Identificacao;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;

class UsuarioViewHelper extends AbstractHelper
{
    private $authenticationService;

    /**
     * Retorna o usuario atual
     */
    public function __invoke()
    {
        return $this->authenticationService->getIdentity()->getUsuario();
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
