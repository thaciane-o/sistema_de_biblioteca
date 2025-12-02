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
        // Buscar quantas vezes cada livro foi emprestado OK OK
        $qtdEmprestimos = DB::select('SELECT
                COUNT(livro_id) AS qtdEmprestado,
                titulo
            FROM
                emprestimo
                INNER JOIN livro ON (livro.id = emprestimo.livro_id)
            GROUP BY
                livro_id,
                titulo');

        // Buscar quantos livros cada autor possui
        $qtdEscritos = DB::select('SELECT
                COUNT(escrito.id) AS qtdEscritos,
                autor.id,
                nome
            FROM
                autor
                INNER JOIN escrito ON (escrito.autor_id = autor.id)
            GROUP BY
                autor.id,
                nome');

        // Buscar quais clientes pegaram 10 ou mais livros emprestados OK
        $clienteEmprestado = DB::select('SELECT
                cliente.id,
                pessoa.nome
            FROM
                cliente
                INNER JOIN pessoa ON (pessoa.id = cliente.pessoa_id)
                INNER JOIN emprestimo ON (emprestimo.cliente_id = cliente.id)
            GROUP BY
                cliente.id,
                pessoa.nome
            HAVING
                COUNT(emprestimo.id) >= 10');

        // Buscar última vez que um cliente pegou um livro emprestado OK
        $ultimoEmprestimo = DB::select('SELECT
                pessoa.nome,
                dataInicio
            FROM
                emprestimo
                INNER JOIN cliente ON (cliente.id = emprestimo.cliente_id)
                INNER JOIN pessoa ON (pessoa.id = cliente.pessoa_id)
            WHERE
                dataInicio = (
                    SELECT MAX(dataInicio) FROM emprestimo
                )
            GROUP BY
                dataInicio,
                pessoa.nome');

        return view('home', [
            'qtdEmprestimos' => $qtdEmprestimos,
            'clienteEmprestado' => $clienteEmprestado,
            'qtdEscritos' => $qtdEscritos

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
