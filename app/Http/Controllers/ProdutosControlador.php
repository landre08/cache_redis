<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
use Illuminate\Support\Facades\Cache;

class ProdutosControlador extends Controller
{
    public function index()
    {
        $expiracao = 1; // Em minutos
        // Aqui ele verifica se já tá na cache todososprodutos, se nao estiver ele executa
        // a função anônima e vai buscar na base de dados
        // Na primeira vez como nao tem cache, ele busca na base
        // mas depois busca na cache todososprodutos, até o tempo expirar em $expiracao
        $produtos = Cache::remember('todososprodutos', $expiracao, function() {
            return Produto::with('categorias')->get();
        });

        return view('produtos', compact(['produtos']));
    }
}
