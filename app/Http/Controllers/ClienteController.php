<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = DB::select('SELECT * FROM cliente INNER JOIN pessoa ON (pessoa.id = cliente.pessoa_id)');

        return view('cliente.index', ['clientes' => $clientes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pessoas = DB::select('SELECT id, nome FROM pessoa');

        return view('cliente.create', ['pessoas' => $pessoas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'matricula' => 'required|string|max:10',
            'pessoa_id' => 'required|integer',
        ]);

        try {
            if ($validator->fails()) {
                return redirect()->route('cliente.index')->with('error', 'Confira os campos e tente novamente!');
            }

            DB::beginTransaction();

            DB::insert('INSERT INTO cliente (matricula, pessoa_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())',
                [
                    $request->input('matricula'),
                    $request->input('pessoa_id'),
                ]
            );

            DB::commit();

            return redirect()->route('cliente.index')->with('success', 'Cadastro realizado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao realizar cadastro!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cliente = DB::select('SELECT * FROM cliente WHERE id = ?', [$id]);
        $pessoa = DB::select('SELECT * FROM pessoa WHERE id = ?', [$cliente[0]->pessoa_id]);

        return response()->json([
            'cliente' => $cliente[0],
            'pessoa' => $pessoa[0]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cliente = DB::select('SELECT * FROM cliente WHERE id = ?', [$id]);
        $pessoas = DB::select('SELECT id, nome FROM pessoa');

        return view('cliente.edit', ['cliente' => $cliente[0], 'pessoas' => $pessoas]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'matricula' => 'required|string|max:10',
            'pessoa_id' => 'required|integer',
        ]);

        try {
            if ($validator->fails()) {
                return redirect()->route('cliente.index')->with('error', 'Confira os campos e tente novamente!');
            }

            DB::beginTransaction();

            DB::update('UPDATE cliente SET matricula = ?, pessoa_id = ?, updated_at = NOW() WHERE id = ?',
                [
                    $request->input('matricula'),
                    $request->input('pessoa_id'),
                    $id
                ]
            );

            DB::commit();

            return redirect()->route('cliente.index')->with('success', 'Cadastro atualizado com sucesso!');
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

            DB::delete('DELETE FROM cliente WHERE id = ?', [$id]);

            DB::commit();

            return redirect()->route('cliente.index')->with('success', 'Cadastro deletado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with(['error' => 'Erro ao deletar cadastro!']);
        }
    }
}
