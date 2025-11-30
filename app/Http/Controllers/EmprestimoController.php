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
        $emprestimos = DB::select('SELECT
                emprestimo.id, emprestimo.dataInicio, emprestimo.dataFimEsperado, emprestimo.renovacoes,
                livro.titulo, cliente_nome, GROUP_CONCAT(funcionario_nome SEPARATOR ", ") AS funcionario_nome
            FROM
                emprestimo
                INNER JOIN livro ON (livro.id = emprestimo.livro_id)
                INNER JOIN responsavel_emprestimo ON (emprestimo.id = responsavel_emprestimo.emprestimo_id)
                JOIN
                    (
                        SELECT
                            funcionario.id AS funcionario_id, pessoa.nome AS funcionario_nome
                        FROM
                            funcionario
                        INNER JOIN
                            pessoa ON (pessoa.id = funcionario.pessoa_id)
                    ) AS funcionario ON (funcionario.funcionario_id = responsavel_emprestimo.responsavel_id)
                JOIN
                    (
                        SELECT
                            cliente.id AS cliente_id, pessoa.nome AS cliente_nome
                        FROM
                            cliente
                        INNER JOIN
                            pessoa ON (pessoa.id = cliente.pessoa_id)
                    ) AS cliente ON (cliente.cliente_id = emprestimo.cliente_id)
            GROUP BY
                emprestimo.id, emprestimo.dataInicio, emprestimo.dataFimEsperado,
                emprestimo.renovacoes, livro.titulo, cliente_nome');

        return view('emprestimo.index', ['emprestimos' => $emprestimos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $livros = DB::select('SELECT id, titulo FROM livro');
        $clientes = DB::select('SELECT cliente.id, nome FROM cliente INNER JOIN pessoa ON (pessoa.id = cliente.pessoa_id)');
        $funcionarios = DB::select('SELECT funcionario.id, nome FROM funcionario INNER JOIN pessoa ON (pessoa.id = funcionario.pessoa_id)');

        return view('emprestimo.create', ['livros' => $livros, 'clientes' => $clientes, 'funcionarios' => $funcionarios]);
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
            'responsavel_id' => 'required|integer',
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

            $idEmprestimo = DB::getPdo()->lastInsertId();

            DB::insert('INSERT INTO responsavel_emprestimo (emprestimo_id, responsavel_id, created_at, updated_at) VALUES (?,?, NOW(), NOW())',
                [
                    $idEmprestimo,
                    $request->input('responsavel_id'),
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
        $emprestimo = DB::select('SELECT
                emprestimo.*, livro.titulo, cliente_nome, GROUP_CONCAT(funcionario_nome SEPARATOR ", ") AS funcionario_nome
            FROM
                emprestimo
                INNER JOIN livro ON (livro.id = emprestimo.livro_id)
                INNER JOIN responsavel_emprestimo ON (emprestimo.id = responsavel_emprestimo.emprestimo_id)
                JOIN
                    (
                        SELECT
                            funcionario.id AS funcionario_id, pessoa.nome AS funcionario_nome
                        FROM
                            funcionario
                        INNER JOIN
                            pessoa ON (pessoa.id = funcionario.pessoa_id)
                    ) AS funcionario ON (funcionario.funcionario_id = responsavel_emprestimo.responsavel_id)
                JOIN
                    (
                        SELECT
                            cliente.id AS cliente_id, pessoa.nome AS cliente_nome
                        FROM
                            cliente
                        INNER JOIN
                            pessoa ON (pessoa.id = cliente.pessoa_id)
                    ) AS cliente ON (cliente.cliente_id = emprestimo.cliente_id)
            WHERE
                emprestimo.id = ?
            GROUP BY
                emprestimo.id, emprestimo.dataInicio, emprestimo.dataFimEsperado,
                emprestimo.renovacoes, livro.titulo, cliente_nome',
        [$id]);

        return response()->json([
            'emprestimo' => $emprestimo[0]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $emprestimo = DB::select('SELECT * FROM emprestimo WHERE id = ?', [$id]);

        $responsaveisEmprestimo = DB::select('SELECT responsavel_id FROM responsavel_emprestimo WHERE emprestimo_id = ?', [$id]);
        $responsaveisEmprestimo = array_map(fn($e) => $e->responsavel_id, $responsaveisEmprestimo);

        $livros = DB::select('SELECT id, titulo FROM livro');
        $clientes = DB::select('SELECT cliente.id, nome FROM cliente INNER JOIN pessoa ON (pessoa.id = cliente.pessoa_id)');
        $funcionarios = DB::select('SELECT funcionario.id, nome FROM funcionario INNER JOIN pessoa ON (pessoa.id = funcionario.pessoa_id)');

        return view('emprestimo.edit', [
            'emprestimo' => $emprestimo[0],
            'livros' => $livros,
            'clientes' => $clientes,
            'funcionarios' => $funcionarios,
            'responsaveisEmprestimo' => $responsaveisEmprestimo
        ]);
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
            'responsaveis_id' => 'required|array|min:1',
        ]);

        try {
            if ($validator->fails()) {
                dd($validator->errors());
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

            $responsaveis = DB::select('SELECT responsavel_id FROM responsavel_emprestimo WHERE emprestimo_id = ?', [$id]);
            $responsaveisIds = array_map(fn($e) => $e->responsavel_id, $responsaveis);
            $responsaveisRequest = $request->input('responsaveis_id', []);

            foreach ($responsaveisRequest as $respId) {
                if (!in_array($respId, $responsaveisIds)) {
                    DB::insert(
                        'INSERT INTO responsavel_emprestimo (responsavel_id, emprestimo_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())',
                        [$respId, $id]
                    );
                }
            }
            foreach ($responsaveisIds as $respId) {
                if (!in_array($respId, $responsaveisRequest)) {
                    DB::delete(
                        'DELETE FROM responsavel_emprestimo WHERE responsavel_id = ? AND emprestimo_id = ?',
                        [$respId, $id]
                    );
                }
            }

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
