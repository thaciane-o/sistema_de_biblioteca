<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pessoas = DB::select('SELECT * FROM pessoa');

        return view('pessoa.index', ['pessoas' => $pessoas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pessoa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string',
            'cpf' => 'required|string|max:11',
            'telefone' => 'required|string|max:11',
            'endereco' => 'required|string',
        ]);

        try {
            if ($validator->fails()) {
                throw new Exception("Confira os campos e tente novamente!");
            }

            DB::beginTransaction();

            DB::insert('INSERT INTO pessoa (nome, cpf, telefone, endereco) VALUES (?,?,?,?)',
                [
                    $request->input('nome'),
                    $request->input('cpf'),
                    $request->input('telefone'),
                    $request->input('endereco')
                ]
            );

            DB::commit();

            return redirect()->route('pessoa.index')->with('success', 'Cadastro realizado com sucesso!');
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

    public function dados(DataTables $datatables)
    {
        $pessoas = DB::table('pessoa')->select('id', 'nome', 'cpf')->get();

        return $datatables->eloquent($pessoas)
            ->rawColumns(['status', 'action', 'details'])
            ->make(true);
    }

}
