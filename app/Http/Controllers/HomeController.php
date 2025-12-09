<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $qtdEmprestimos = DB::select('SELECT
                COUNT(livro_id) AS qtdEmprestado,
                titulo
            FROM
                emprestimo
                INNER JOIN livro ON (livro.id = emprestimo.livro_id)
            GROUP BY
                livro_id,
                titulo');

        $clienteEmprestado = DB::select('
            SELECT
                cliente.id,
                pessoa.nome,
                COUNT(emprestimo.id) AS totalEmprestimos
            FROM
                cliente
                INNER JOIN pessoa ON pessoa.id = cliente.pessoa_id
                INNER JOIN emprestimo ON emprestimo.cliente_id = cliente.id
            GROUP BY
                cliente.id,
                pessoa.nome
            ORDER BY
                totalEmprestimos DESC
            LIMIT 10');

        $faturamentoEsseMes = DB::select('
            SELECT
                livro_id,
                livro.titulo,
                SUM(valorPraticado * (renovacoes + 1)) AS faturamento
            FROM
                emprestimo
                INNER JOIN livro ON (livro.id = emprestimo.livro_id)
            WHERE
                MONTH(emprestimo.dataFimReal) = MONTH(NOW())
            GROUP BY
                livro_id, livro.titulo
        ');

        $faturamentoMesPassado = DB::select('
            SELECT
                livro_id,
                livro.titulo,
                SUM(valorPraticado * (renovacoes + 1)) AS faturamento
            FROM
                emprestimo
                INNER JOIN livro ON (livro.id = emprestimo.livro_id)
            WHERE
                MONTH(emprestimo.dataFimReal) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH))
            GROUP BY
                livro_id, livro.titulo
        ');

        $totalEsseMes = array_reduce($faturamentoEsseMes, function ($carry, $item) {
            return $carry + $item->faturamento;
        }, 0);

        $totalMesPassado = array_reduce($faturamentoMesPassado, function ($carry, $item) {
            return $carry + $item->faturamento;
        }, 0);

        return view('home', [
            'qtdEmprestimos' => $qtdEmprestimos,
            'clienteEmprestado' => $clienteEmprestado,
            'faturamentoEsseMes' => $faturamentoEsseMes,
            'totalEsseMes' => $totalEsseMes,
            'faturamentoMesPassado' => $faturamentoMesPassado,
            'totalMesPassado' => $totalMesPassado
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       //
    }
}
