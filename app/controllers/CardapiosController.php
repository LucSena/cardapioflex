<?php
namespace App\Controllers;

use DB\SQL\Mapper;

class CardapiosController {
    function index($f3) {
        // Verifica se o usuário está logado
        if (!$f3->get('SESSION.user')) {
            $f3->reroute('/login');
            return;
        }
        
        $f3->set('PAGE', 'cardapios');

        // Conecta ao banco de dados
        $db = $f3->get('DB');
        
        // Verifica o conteúdo da sessão do usuário
        $userSession = $f3->get('SESSION.user');
        
        // Se for um inteiro (provavelmente o ID do usuário), busque os dados do usuário no banco
        if (is_int($userSession)) {
            $userMapper = new Mapper($db, 'administradores');  // Supondo que a tabela se chame 'administradores'
            $user = $userMapper->load(['id=?', $userSession]);
            $nome = $user['nome'];  // Supondo que o campo do nome seja 'nome'
            $id = $userSession;
        } elseif (is_array($userSession)) {
            // Se for um array, tente acessar diretamente
            $nome = $userSession['nome'] ?? 'Nome não disponível';
            $id = $userSession['id'] ?? null;
        } else {
            // Caso não seja nem inteiro nem array, defina valores padrão
            $nome = 'Usuário';
            $id = null;
        }

        // Recupera os cardápios do banco de dados
        $cardapiosMapper = new Mapper($db, 'cardapios');
        $cardapios = $cardapiosMapper->find(['administrador_id = ?', $id]);

        // Recupera as configurações de cada cardápio
        $configuracoesMapper = new Mapper($db, 'configuracoes_cardapio');
        foreach ($cardapios as &$cardapio) {
            $configuracao = $configuracoesMapper->load(['cardapio_id = ?', $cardapio['id']]);
            $cardapio['configuracao'] = $configuracao;
            $cardapio['criado_em'] = date('d/m/Y H:i:s', strtotime($cardapio['criado_em']));
        }

        $f3->set('nome', $nome);
        $f3->set('cardapios', $cardapios);
        
        echo \Template::instance()->render('cardapios.html');
    }
    
}