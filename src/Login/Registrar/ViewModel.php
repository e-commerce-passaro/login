<?php
namespace Ecompassaro\Login\Registrar;

use Ecompassaro\Acesso\Acesso;
use Ecompassaro\Autenticacao\Manager as AutenticacaoManager;
use Ecompassaro\Autenticacao\Autenticacao;
use Ecompassaro\Notificacao\Notificacao;
use Ecompassaro\Notificacao\NotificacoesContainerTrait;
use Ecompassaro\Acesso\ViewModel as AcessoViewModel;

/**
 * Gerador da estrutura da página de login
 */
class ViewModel extends AcessoViewModel
{
    use NotificacoesContainerTrait;

    const MESSAGE_INTERNAL_ERROR = 'Ocorreu um erro ao regitrar uma conta!';
    const MESSAGE_INSERT_SUCCESS = 'O login foi registrado com sucesso!';

    private $autenticacaoManager;
    private $form;

    /**
     * Injeta dependências
     * @param \Acesso\Acesso
     * @param \Autenticacao\AutenticacaoManager $autenticacaoManager
     * @param RegistrarForm $form
     */
    public function __construct(Acesso $acesso, AutenticacaoManager $autenticacaoManager, Form $form)
    {
        parent::__construct($acesso);
        $this->autenticacaoManager = $autenticacaoManager;
        $this->form = $form;
        $this->variables['formulario'] = $form;
    }

    /**
     * Obtem o formulário de registrar login
     * @return RegistrarForm
     */
    public function getFormulario($routeRedirect = null)
    {
        return $this->form->setRouteRedirect($routeRedirect);
    }

    /**
     * Salva um login a partir do formulario
     * @return array contendo as mensagens de sucesso ou erro.
     */
    public function save()
    {
        try {
            $autenticacao = new Autenticacao();
            $autenticacao->exchangeArray($this->form->getData());
            $perfilDefault = $this->autenticacaoManager->getPerfilManager()->obterPerfilByNome(Acesso::getDefaultRole());
            $autenticacao = $this->autenticacaoManager->salvar(
                $autenticacao->setPerfilId($perfilDefault->getId())
                    ->setPerfil($perfilDefault)
            );
            $this->addNotificacao(new Notificacao(Notificacao::TIPO_SUCESSO, self::MESSAGE_INSERT_SUCCESS));
        } catch (\Exception $e) {
            $this->addNotificacao(new Notificacao(Notificacao::TIPO_ERRO, self::MESSAGE_INTERNAL_ERROR));
        }

        return true;
    }
}
