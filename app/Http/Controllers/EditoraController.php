<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EditoraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $editoras = DB::select('SELECT id, nome FROM editora');

        return view('editora.index', ['editoras' => $editoras]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('editora.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string',
        ]);

        try {
            if ($validator->fails()) {
                return redirect()->route('editora.index')->with('error', 'Confira os campos e tente novamente!');
            }

            DB::beginTransaction();

            DB::insert('INSERT INTO editora (nome, created_at, updated_at) VALUES (?, NOW(), NOW())',
                [
                    $request->input('nome')
                ]
            );

            DB::commit();

            return redirect()->route('editora.index')->with('success', 'Cadastro realizado com sucesso!');
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
        $editora = DB::select('SELECT * FROM editora WHERE id = ?', [$id]);

        return response()->json([
            'editora' => $editora[0]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $editora = DB::select('SELECT * FROM editora WHERE id = ?', [$id]);

        return view('editora.edit', ['editora' => $editora[0]]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string',
        ]);

        try {
            if ($validator->fails()) {
                return redirect()->route('editora.index')->with('error', 'Confira os campos e tente novamente!');
            }

            DB::beginTransaction();

            DB::update('UPDATE editora SET nome = ?, updated_at = NOW() WHERE id = ?',
                [
                    $request->input('nome'),
                    $id
                ]
            );

            DB::commit();

            return redirect()->route('editora.index')->with('success', 'Cadastro atualizado com sucesso!');
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

            DB::delete('DELETE FROM editora WHERE id = ?', [$id]);

            DB::commit();

            return redirect()->route('editora.index')->with('success', 'Cadastro deletado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['Erro' => $e->getMessage()]);
        }
    }
}
