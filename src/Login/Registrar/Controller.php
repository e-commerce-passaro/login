<?php
namespace Ecompassaro\Login\Registrar;

use Ecompassaro\Acesso\Controller as AcessoController;
use Ecompassaro\Notificacao\FlashMessagesContainerTrait;
use Ecompassaro\Login\ViewModel as LoginViewModel;

class Controller extends AcessoController
{
    use FlashMessagesContainerTrait;

    protected $resource = 'registrar';
    protected $loginViewModel;

	public function __construct(ViewModel $viewModel, LoginViewModel $loginViewModel) {
        $this->viewModel = $viewModel;
        $this->loginViewModel = $loginViewModel;
	}

    /**
     * Mostra a página de registrar
     *
     * @return RegistrarViewModel
     */
    public function indexAction()
    {
        return $this->getViewModel()->setTemplate('login/new');
    }

    /**
     * Cadastra o usuario e redireciona para a página que for passada por parâmetro ou para
     * a página default
     */
    public function registrarAction()
    {
        $this->getViewModel()->getFormulario()->setData($this->params()->fromPost());
        if ($this->getViewModel()->getFormulario()->isValid() && $this->getViewModel()->save()) {
            $redirect = $this->params()->fromPost('routeRedirect');
            $this->loginViewModel->validaLogin($this->getViewModel()->getFormulario()->getData());
            $this->getViewModel()->getFormulario($redirect?$redirect:'site');
        }

        $mensagens = $this->getViewModel()->getNotificacoes();
        if ($mensagens) {
            $this->setFlashMessagesFromNotificacoes($mensagens);
        } else {
            $this->setFlashMessagesFromNotificacoes($this->getViewModel()->getFormulario()->getMessages());
        }
        return $this->redirect()->toRoute('registrar');
    }
}
