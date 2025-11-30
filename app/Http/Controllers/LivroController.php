<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LivroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livros = DB::select('SELECT id, titulo, isbn, edicao FROM livro');

        return view('livro.index', ['livros' => $livros]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $autores = DB::select('SELECT id, nome FROM autor');
        $editoras = DB::select('SELECT id, nome FROM editora');

        return view('livro.create', ['autores' => $autores, 'editoras' => $editoras]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string',
            'isbn' => 'required|string|max:13|unique:livro',
            'edicao' => 'required|integer',
            'dataPublicacao' => 'required|date',
            'valorEmprestimo' => 'required|numeric|min:0',
            'qtdEstoque' => 'required|integer|min:0',
            'autores' => 'required|array|min:1',
            'editoras' => 'array',
        ]);

        try {
            if ($validator->fails()) {
                dd($validator->errors());
                return redirect()->route('livro.index')->with('error', 'Confira os campos e tente novamente!');
            }

            DB::beginTransaction();

            DB::insert('INSERT INTO livro (titulo, isbn, edicao, dataPublicacao, valorEmprestimo,
                   qtdEstoque, descricao, created_at, updated_at) VALUES (?,?,?,?,?,?,?, NOW(), NOW())',
                [
                    $request->input('titulo'),
                    $request->input('isbn'),
                    $request->input('edicao'),
                    $request->input('dataPublicacao'),
                    $request->input('valorEmprestimo'),
                    $request->input('qtdEstoque'),
                    $request->input('descricao'),
                ]
            );

            $idLivro = DB::getPdo()->lastInsertId();

            foreach ($request->input('autores') as $autor) {
                DB::insert('INSERT INTO escrito (autor_id, livro_id, created_at, updated_at) VALUES (?,?, NOW(), NOW())',
                    [
                        $autor,
                        $idLivro
                    ]
                );
            }

            foreach ($request->input('editoras') as $editora) {
                DB::insert('INSERT INTO publicado (editora_id, livro_id, created_at, updated_at) VALUES (?,?, NOW(), NOW())',
                    [
                        $editora,
                        $idLivro
                    ]
                );
            }

            DB::commit();

            return redirect()->route('livro.index')->with('success', 'Cadastro realizado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Erro' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $livro = DB::select('SELECT
                livro.*,
                GROUP_CONCAT(DISTINCT autor.nome SEPARATOR ", ") AS autores,
                GROUP_CONCAT(DISTINCT editora.nome SEPARATOR ", ") AS editoras
            FROM
                livro
                INNER JOIN escrito ON escrito.livro_id = livro.id
                INNER JOIN autor ON autor.id = escrito.autor_id
                LEFT JOIN publicado ON publicado.livro_id = livro.id
                LEFT JOIN editora ON editora.id = publicado.editora_id
            WHERE
                livro.id = ?
            GROUP
                BY livro.id', [$id]);

        return response()->json([
            'livro' => $livro[0]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $livro = DB::select('SELECT * FROM livro WHERE id = ?', [$id]);

        $autores = DB::select('SELECT id, nome FROM autor');
        $editoras = DB::select('SELECT id, nome FROM editora');

        $escritos = DB::select('SELECT autor_id FROM escrito WHERE livro_id = ?', [$id]);
        $escritos = array_map(fn($e) => $e->autor_id, $escritos);

        $publicados = DB::select('SELECT editora_id FROM publicado WHERE livro_id = ?', [$id]);
        $publicados = array_map(fn($e) => $e->editora_id, $publicados);

        return view('livro.edit', [
            'livro' => $livro[0],
            'autores' => $autores,
            'editoras' => $editoras,
            'escritos' => $escritos,
            'publicados' => $publicados,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string',
            'isbn' => 'required|string|max:13|unique:livro,isbn,' . $id . ',id',
            'edicao' => 'required|integer',
            'dataPublicacao' => 'required|date',
            'valorEmprestimo' => 'required|numeric|min:0',
            'qtdEstoque' => 'required|integer|min:0',
            'autores' => 'required|array|min:1',
            'editoras' => 'array',
        ]);

        try {
            if ($validator->fails()) {
                dd($validator->errors());
                return redirect()->route('livro.index')->with('error', 'Confira os campos e tente novamente!');
            }

            DB::beginTransaction();

            DB::update('UPDATE livro SET titulo = ?, isbn = ?, edicao = ?, dataPublicacao = ?,
                 valorEmprestimo = ?, qtdEstoque = ?, descricao = ?, updated_at = NOW() WHERE id = ?',
                [
                    $request->input('titulo'),
                    $request->input('isbn'),
                    $request->input('edicao'),
                    $request->input('dataPublicacao'),
                    $request->input('valorEmprestimo'),
                    $request->input('qtdEstoque'),
                    $request->input('descricao'),
                    $id
                ]
            );

            $escritos = DB::select('SELECT autor_id FROM escrito WHERE livro_id = ?', [$id]);
            $escritosIds = array_map(fn($e) => $e->autor_id, $escritos);
            $autoresRequest = $request->input('autores', []);

            foreach ($autoresRequest as $autorId) {
                if (!in_array($autorId, $escritosIds)) {
                    DB::insert(
                        'INSERT INTO escrito (autor_id, livro_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())',
                        [$autorId, $id]
                    );
                }
            }
            foreach ($escritosIds as $autorId) {
                if (!in_array($autorId, $autoresRequest)) {
                    DB::delete(
                        'DELETE FROM escrito WHERE autor_id = ? AND livro_id = ?',
                        [$autorId, $id]
                    );
                }
            }

            $escritos = DB::select('SELECT autor_id FROM escrito WHERE livro_id = ?', [$id]);
            $escritosIds = array_map(fn($e) => $e->autor_id, $escritos);
            $autoresRequest = $request->input('autores', []);

            foreach ($autoresRequest as $autorId) {
                if (!in_array($autorId, $escritosIds)) {
                    DB::insert(
                        'INSERT INTO escrito (autor_id, livro_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())',
                        [$autorId, $id]
                    );
                }
            }

            foreach ($escritosIds as $autorId) {
                if (!in_array($autorId, $autoresRequest)) {
                    DB::delete(
                        'DELETE FROM escrito WHERE autor_id = ? AND livro_id = ?',
                        [$autorId, $id]
                    );
                }
            }

            $publicados = DB::select('SELECT editora_id FROM publicado WHERE livro_id = ?', [$id]);
            $publicadosIds = array_map(fn($p) => $p->editora_id, $publicados);
            $requestEditoras = $request->input('editoras', []);

            foreach ($requestEditoras as $editoraId) {
                if (!in_array($editoraId, $publicadosIds)) {
                    DB::insert(
                        'INSERT INTO publicado (editora_id, livro_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())',
                        [$editoraId, $id]
                    );
                }
            }

            foreach ($publicadosIds as $editoraId) {
                if (!in_array($editoraId, $requestEditoras)) {
                    DB::delete(
                        'DELETE FROM publicado WHERE editora_id = ? AND livro_id = ?',
                        [$editoraId, $id]
                    );
                }
            }

            DB::commit();

            return redirect()->route('livro.index')->with('success', 'Cadastro atualizado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Erro' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            DB::delete('DELETE FROM livro WHERE id = ?', [$id]);

            DB::commit();

            return redirect()->route('livro.index')->with('success', 'Cadastro deletado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Erro' => $e->getMessage()]);
        }
    }
}
