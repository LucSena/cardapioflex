<?php
namespace App\Controllers;

class DashboardController {
    function index($f3) {
        // Verifica se o usuário está logado
        if (!$f3->get('SESSION.user')) {
            $f3->reroute('/login');
            return;
        }

        // Simulação de dados
        $totalCardapios = 10; // Exemplo de dados - você deve buscar esses valores do banco de dados
        $promocoesAtivas = 3; // Exemplo de dados
        $itensIndisponiveis = 5; // Exemplo de dados
        $configuracoes = 1; // Exemplo de dados

        $atividades = [
            ['data' => '2024-06-24', 'descricao' => 'Adicionado novo cardápio', 'status' => 'Concluído', 'statusColor' => 'success'],
            ['data' => '2024-06-23', 'descricao' => 'Atualizado item de cardápio', 'status' => 'Pendente', 'statusColor' => 'warning'],
            ['data' => '2024-06-22', 'descricao' => 'Removido item indisponível', 'status' => 'Cancelado', 'statusColor' => 'danger'],
        ];

        $f3->set('totalCardapios', $totalCardapios);
        $f3->set('promocoesAtivas', $promocoesAtivas);
        $f3->set('itensIndisponiveis', $itensIndisponiveis);
        $f3->set('configuracoes', $configuracoes);
        $f3->set('atividades', $atividades);

        echo \Template::instance()->render('dashboard.html');
    }
}
