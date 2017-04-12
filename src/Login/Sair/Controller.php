<?php
namespace Ecompassaro\Login\Sair;

use Ecompassaro\Acesso\Controller as AcessoController;

class Controller extends AcessoController
{
    protected $resource = 'sair';

    /**
     * Limpa autenticação e redireciona para a urlRedireciona passada por GET
     */
    public function sairAction()
    {
        $this->getViewModel()->limparAutenticacao();
        $redirect = $this->params()->fromQuery('routeRedirect');
        return $this->redirect()->toRoute($redirect ? $redirect : 'site');
    }
}
