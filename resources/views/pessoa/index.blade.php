<x-layoutBase>
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-6">
                <h1 class="mt-4">Pessoa</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Página inicial</a></li>
                    <li class="breadcrumb-item">Cadastros</li>
                    <li class="breadcrumb-item active">Pessoa</li>
                </ol>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-end mb-4">
                <a class="btn btn-primary btn-block px-3 py-2" href="{{ route('pessoa.create') }}"> <i
                        class="fas fa-plus me-1"></i> Criar</a>
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
                        <th>CPF</th>
                        <th>NOME</th>
                        <th>TELEFONE</th>
                        <th>OPÇÕES</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pessoas as $pessoa)
                        <tr>
                            <td>{{ preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $pessoa->cpf) }}</td>
                            <td>{{ $pessoa->nome }}</td>
                            <td>{{ preg_replace('/(\d{2})(\d{4,5})(\d{4})/', '($1) $2-$3', $pessoa->telefone) }}</td>
                            <td>
                                <a href="#" title="Visualizar" class="text-primary me-2"
                                   data-bs-toggle="modal" data-bs-target="#modal"
                                   data-id="{{ $pessoa->id }}"
                                   style="text-decoration: none">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('pessoa.edit', $pessoa->id)  }}" title="Atualizar"
                                   class="text-success me-2"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('pessoa.destroy', $pessoa->id) }}"
                                   class="text-danger" onclick="return confirm('Tem certeza que deseja excluir esta pessoa?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Detalhes</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <div class="modal-infos col-9"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#modal').on('show.bs.modal', function (event) {
            const botao = event.relatedTarget;
            const id = botao.getAttribute('data-id');
            var modal = $(this);

            $.ajax({
                url: "{{ route('pessoa.show', ['id' => '__ID__']) }}".replace('__ID__', id),
                method: 'GET',
                success: function (data) {

                    const cpf = formatarCPF(data.pessoa.cpf);
                    const telefone = formatarTelefone(data.pessoa.telefone);
                    const criado_em = formatarData(data.pessoa.created_at);
                    const atualizado_em = formatarData(data.pessoa.updated_at);

                    modal.find('.modal-infos').html(`
                        <div class="row mb-3">
                            <div class="col-12">
                                <b>Nome:</b> ${data.pessoa.nome}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <b>CPF:</b> ${cpf}
                            </div>
                            <div class="col-6">
                                <b>Telefone:</b> ${telefone}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <b>Endereço:</b> ${data.pessoa.endereco}
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-6">
                                <b>Criado em:</b> ${criado_em}
                            </div>
                            <div class="col-6">
                                <b>Atualizado em:</b> ${atualizado_em}
                            </div>
                        </div>
                    `);
                },
                error: function (error) {
                    modal.find('.modal-infos').html('<p>Ocorreu um erro ao buscar os dados.</p>');
                    console.error('Error:', error);
                }
            });
        });
    </script>
</x-layoutBase>
