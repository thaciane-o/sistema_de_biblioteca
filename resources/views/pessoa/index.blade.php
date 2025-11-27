<x-layoutBase>
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-6">
                <h1 class="mt-4">Pessoa</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="/home">Página inicial</a></li>
                    <li class="breadcrumb-item active">Cadastros</li>
                    <li class="breadcrumb-item active">Pessoa</li>
                </ol>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-end mb-4">
                <a class="btn btn-primary btn-block px-3 py-2" href="{{ route('pessoa.create') }}"> <i class="fas fa-plus me-1"></i> Criar</a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Dados das pessoas
            </div>
            <div class="card-body">
                <table id="datatablesSimple" style="table-layout: fixed; width: 100%;">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>NOME</th>
                        <th>TELEFONE</th>
                        <th>OPÇÕES</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pessoas as $pessoa)
                        <tr>
                            <td>{{ $pessoa->id }}</td>
                            <td>{{ $pessoa->nome }}</td>
                            <td>{{ $pessoa->telefone }}</td>
                            <td>
                                <a href="{{ route('pessoa.show', $pessoa->id)  }}" title="Visualizar" class="text-primary me-2"><i class="fas far fa-eye"></i></a>
                                <a href="{{ route('pessoa.edit', $pessoa->id)  }}" title="Atualizar" class="text-success me-2"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('pessoa.destroy', $pessoa->id) }}" title="Excluir" class="text-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layoutBase>
