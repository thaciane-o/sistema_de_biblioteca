<x-layoutBase>
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-6">
                <h1 class="mt-4">Funcionário</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Página inicial</a></li>
                    <li class="breadcrumb-item">Cadastros</li>
                    <li class="breadcrumb-item active">Funcionário</li>
                </ol>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-end mb-4">
                <a class="btn btn-primary btn-block px-3 py-2" href="{{ route('funcionario.create') }}"> <i
                        class="fas fa-plus me-1"></i> Criar</a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Dados dos funcionários
            </div>
            <div class="card-body">
                <table id="datatablesSimple" style="table-layout: fixed; width: 100%;">
                    <thead>
                    <tr>
                        <th>MATRÍCULA</th>
                        <th>NOME</th>
                        <th>CPF</th>
                        <th>STATUS</th>
                        <th>OPÇÕES</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($funcionarios as $funcionario)
                        <tr>
                            <td>{{ $funcionario->matricula }}</td>
                            <td>{{ $funcionario->nome }}</td>
                            <td>{{ preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $funcionario->cpf) }}</td>
                            <td>{{ $funcionario->dataDemissao == null ? "Em atividade" : "Demitido" }}</td>
                            <td>
                                <a href="#" title="Visualizar" class="text-primary me-2"
                                   data-bs-toggle="modal" data-bs-target="#modal"
                                   data-id="{{ $funcionario->id }}"
                                   style="text-decoration: none">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('funcionario.edit', $funcionario->id)  }}" title="Atualizar"
                                   class="text-success me-2"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('funcionario.destroy', $funcionario->id) }}"
                                   class="text-danger" onclick="return confirm('Tem certeza que deseja excluir este funcionário?')">
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
                url: "{{ route('funcionario.show', ['id' => '__ID__']) }}".replace('__ID__', id),
                method: 'GET',
                success: function (data) {

                    const criado_em = formatarData(data.funcionario.created_at);
                    const atualizado_em = formatarData(data.funcionario.updated_at);
                    const dataAdmissao = formatarData(data.funcionario.dataAdmissao);
                    const cpf = formatarCPF(data.pessoa.cpf);
                    const telefone = formatarTelefone(data.pessoa.telefone);
                    let dataDemissao = null;

                    if (data.funcionario.dataDemissao) {
                        dataDemissao = formatarData(data.funcionario.dataDemissao);
                    } else {
                        dataDemissao = "Em atividade"
                    }

                    modal.find('.modal-infos').html(`
                        <div class="row mb-3">
                            <div class="col-12">
                                <b>Matrícula:</b> ${data.funcionario.matricula}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <b>Data de admissão:</b> ${dataAdmissao}
                            </div>
                            <div class="col-6">
                                <b>Data de demissão:</b> ${dataDemissao}
                            </div>
                        </div>
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
