<?php
namespace App\Controllers;

use DB\SQL\Mapper;

class DashboardController {
    function index($f3) {
        // Verifica se o usuário está logado
        if (!$f3->get('SESSION.user')) {
            $f3->reroute('/login');
            return;
        }
        
        $f3->set('PAGE', 'dashboard');

        // Conecta ao banco de dados
        $db = $f3->get('DB');
        
        // Verifica o conteúdo da sessão do usuário
        $userSession = $f3->get('SESSION.user');
        
        // Se for um inteiro (provavelmente o ID do usuário), busque os dados do usuário no banco
        if (is_int($userSession)) {
            $userMapper = new Mapper($db, 'administradores');  // Supondo que a tabela se chame 'usuarios'
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

        // Recupera dados reais do banco de dados
        $totalCardapios = $db->exec('SELECT COUNT(*) AS total FROM cardapios WHERE administrador_id = ?', 1)[0]['total'];
        $promocoesAtivas = $db->exec('SELECT COUNT(*) AS total FROM promocoes WHERE data_fim > NOW() AND cardapio_id IN (SELECT id FROM cardapios WHERE administrador_id = ?)', 1)[0]['total'];
        $itensIndisponiveis = $db->exec('SELECT COUNT(*) AS total FROM itens_cardapio WHERE disponivel = 0 AND cardapio_id IN (SELECT id FROM cardapios WHERE administrador_id = ?)', 1)[0]['total'];
        $configuracoes = $db->exec('SELECT COUNT(*) AS total FROM configuracoes WHERE administrador_id = ?', 1)[0]['total'];

        // Recupera as últimas atividades
        $atividadesMapper = new Mapper($db, 'atividades');
        $atividades = $atividadesMapper->find(['administrador_id = ?', 1], ['order' => 'data DESC', 'limit' => 10]);

        $f3->set('totalCardapios', $totalCardapios);
        $f3->set('promocoesAtivas', $promocoesAtivas);
        $f3->set('itensIndisponiveis', $itensIndisponiveis);
        $f3->set('configuracoes', $configuracoes);
        $f3->set('atividades', $atividades);
        $f3->set('nome', $nome);
        
        echo \Template::instance()->render('dashboard.html');
    }
}
