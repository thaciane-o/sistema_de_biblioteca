<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmprestimoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emprestimos = DB::select('SELECT emprestimo.id, emprestimo.dataInicio, emprestimo.dataFimEsperado,
                                            emprestimo.renovacoes, livro.titulo, pessoa.nome FROM emprestimo
                                            INNER JOIN cliente ON (cliente.id = emprestimo.cliente_id)
                                            INNER JOIN pessoa ON (pessoa.id = cliente.pessoa_id)
                                            INNER JOIN livro ON (livro.id = emprestimo.livro_id)');

        return view('emprestimo.index', ['emprestimos' => $emprestimos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $livros = DB::select('SELECT id, titulo FROM livro');
        $clientes = DB::select('SELECT cliente.id, nome FROM cliente INNER JOIN pessoa ON (pessoa.id = cliente.pessoa_id)');

        return view('emprestimo.create', ['livros' => $livros], ['clientes' => $clientes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'valorPraticado' => 'required|numeric',
            'cliente_id' => 'required|integer',
            'livro_id' => 'required|integer',
        ]);

        try {
            if ($validator->fails()) {
                return redirect()->route('emprestimo.index')->with('error', 'Confira os campos e tente novamente!');
            }

            DB::beginTransaction();

            DB::insert('INSERT INTO emprestimo (valorPraticado, dataInicio, dataFimEsperado, dataFimReal, renovacoes, cliente_id, livro_id, created_at, updated_at) VALUES (?, NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY), null, 0, ?, ?, NOW(), NOW())',
                [
                    $request->input('valorPraticado'),
                    $request->input('cliente_id'),
                    $request->input('livro_id'),
                ]
            );

            DB::commit();

            return redirect()->route('emprestimo.index')->with('success', 'Cadastro realizado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', "Erro ao realizar cadastro!");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $emprestimo = DB::select('SELECT * FROM emprestimo WHERE id = ?', [$id]);
        $livro = DB::select('SELECT * FROM livro WHERE id = ?', [$emprestimo[0]->livro_id]);
        $cliente = DB::select('SELECT * FROM cliente INNER JOIN pessoa ON (pessoa.id = cliente.pessoa_id)
                                        WHERE cliente.id = ?', [$emprestimo[0]->cliente_id]);

        return response()->json([
            'emprestimo' => $emprestimo[0],
            'livro' => $livro[0],
            'cliente' => $cliente[0]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $emprestimo = DB::select('SELECT * FROM emprestimo WHERE id = ?', [$id]);
        $livros = DB::select('SELECT id, titulo FROM livro');
        $clientes = DB::select('SELECT cliente.id, nome FROM cliente INNER JOIN pessoa ON (pessoa.id = cliente.pessoa_id)');

        return view('emprestimo.edit', ['emprestimo' => $emprestimo[0], 'livros' => $livros, 'clientes' => $clientes]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'valorPraticado' => 'required|numeric',
            'dataInicio' => 'required|date',
            'dataFimEsperado' => 'required|date',
            'dataFimReal' => 'nullable|date',
            'renovacoes' => 'required|integer',
            'cliente_id' => 'required|integer',
            'livro_id' => 'required|integer',
        ]);

        try {
            if ($validator->fails()) {
                return redirect()->route('emprestimo.index')->with('error', 'Confira os campos e tente novamente!');
            }

            DB::beginTransaction();

            DB::update('UPDATE emprestimo SET valorPraticado = ?, dataInicio = ?, dataFimEsperado = ?,
                      dataFimReal = ?, renovacoes = ?, cliente_id = ?, livro_id = ?, updated_at = NOW() WHERE id = ?',
                [
                    $request->input('valorPraticado'),
                    $request->input('dataInicio'),
                    $request->input('dataFimEsperado'),
                    $request->input('dataFimReal'),
                    $request->input('renovacoes'),
                    $request->input('cliente_id'),
                    $request->input('livro_id'),
                    $id
                ]
            );

            DB::commit();

            return redirect()->route('emprestimo.index')->with('success', 'Cadastro atualizado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with(['error' => 'Erro ao atualizar cadastro!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            DB::delete('DELETE FROM emprestimo WHERE id = ?', [$id]);

            DB::commit();

            return redirect()->route('emprestimo.index')->with('success', 'Cadastro deletado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with(['error' => 'Erro ao deletar cadastro!']);
        }
    }
}
