<x-layoutBase>
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-6">
                <h1 class="mt-4">Empréstimo</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Página inicial</a></li>
                    <li class="breadcrumb-item">Cadastros</li>
                    <li class="breadcrumb-item active">Empréstimo</li>
                </ol>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-end mb-4">
                <a class="btn btn-primary btn-block px-3 py-2" href="{{ route('emprestimo.create') }}"> <i
                        class="fas fa-plus me-1"></i> Criar</a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Dados dos empréstimos
            </div>
            <div class="card-body">
                <table id="datatablesSimple" style="table-layout: fixed; width: 100%;">
                    <thead>
                    <tr>
                        <th>LIVRO</th>
                        <th>RESPONSÁVEL</th>
                        <th>CLIENTE</th>
                        <th>DATA DO EMPRÉSTIMO</th>
                        <th>DATA DA DEVOLUÇÃO</th>
                        <th>RENOVAÇÕES</th>
                        <th>OPÇÕES</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($emprestimos as $emprestimo)
                        <tr>
                            <td>{{ $emprestimo->titulo }}</td>
                            <td>{{ $emprestimo->funcionario_nome }}</td>
                            <td>{{ $emprestimo->cliente_nome }}</td>
                            <td>{{ date('d/m/Y', strtotime($emprestimo->dataInicio)) }}</td>
                            <td>{{ date('d/m/Y', strtotime($emprestimo->dataFimEsperado)) }}</td>
                            <td>{{ $emprestimo->renovacoes }}</td>
                            <td>
                                <a href="#" title="Visualizar" class="text-primary me-2"
                                   data-bs-toggle="modal" data-bs-target="#modal"
                                   data-id="{{ $emprestimo->id }}"
                                   style="text-decoration: none">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" title="Renovar" class="text-secondary me-2"
                                   data-bs-toggle="modal" data-bs-target="#modal2"
                                   data-id="{{ $emprestimo->id }}"
                                   style="text-decoration: none">
                                    <i class="fas fa-refresh"></i>
                                </a>
                                <a href="{{ route('emprestimo.edit', $emprestimo->id)  }}" title="Atualizar"
                                   class="text-success me-2"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('emprestimo.destroy', $emprestimo->id) }}"
                                   class="text-danger" onclick="return confirm('Tem certeza que deseja excluir este empréstimo?')">
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
        <div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Renovar</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <form method="post" id="formRenovar" action="{{ route('emprestimo.renovar') }}">
                                @csrf
                                <input type="hidden" id="renovarEmprestimoId" name="emprestimo_id">
                                <div class="modal-infos col-12"></div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="formRenovar" class="btn btn-primary">Enviar</button>
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
                url: "{{ route('emprestimo.show', ['id' => '__ID__']) }}".replace('__ID__', id),
                method: 'GET',
                success: function (data) {

                    const criado_em = formatarData(data.emprestimo.created_at);
                    const atualizado_em = formatarData(data.emprestimo.updated_at);
                    const dataEmprestimo = formatarData(data.emprestimo.dataInicio);
                    const dataDevolucao = formatarData(data.emprestimo.dataFimEsperado);
                    const valor = Number(data.emprestimo.valorPraticado).toFixed(2).replace('.', ',');
                    let dataDevolvido = null;

                    if (data.emprestimo.dataFimReal) {
                        dataDevolvido = formatarData(data.emprestimo.dataFimReal);
                    } else {
                        dataDevolvido = "Livro não devolvido"
                    }

                    modal.find('.modal-infos').html(`
                        <div class="row mb-3">
                            <div class="col-12">
                                <b>Valor:</b> R$ ${valor}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <b>Data do empréstimo:</b> ${dataEmprestimo}
                            </div>
                            <div class="col-6">
                                <b>Data da devolução:</b> ${dataDevolucao}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <b>Data devolvida:</b> ${dataDevolvido}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <b>Renovações:</b> ${data.emprestimo.renovacoes}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <b>Livro:</b> ${data.emprestimo.titulo}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <b>Responsável(is):</b> ${data.emprestimo.funcionario_nome}
                            </div>
                            <div class="col-6">
                                <b>Cliente:</b> ${data.emprestimo.cliente_nome}
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
        $('#modal2').on('show.bs.modal', function (event) {
            const botao = event.relatedTarget;
            const id = botao.getAttribute('data-id');
            var modal = $(this);

            $.ajax({
                url: "{{ route('emprestimo.dadosRenovacao', ['id' => '__ID__']) }}".replace('__ID__', id),
                method: 'GET',
                success: function (data) {

                    $('#renovarEmprestimoId').val(id);

                    let opcoes = '<option selected>Selecione um responsável...</option>';

                    data.funcionarios.forEach(function(funcionario) {
                        opcoes += `<option value="${funcionario.id}">${funcionario.nome}</option>`;
                    });

                    modal.find('.modal-infos').html(`
                        <div class="row">
                            <div class="col-md-12">
                                <div class="select2-floating mb-3 mb-md-0">
                                    <span class="select2-label">
                                        Responsável <i class="fa fa-circle icon-required"></i>
                                    </span>
                                    <select class="form-select select2" id="inputFuncionario" name="responsavel_id">
                                        ${opcoes}
                                    </select>
                                </div>
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
