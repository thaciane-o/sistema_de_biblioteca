<x-layoutBase>
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-6">
                <h1 class="mt-4">Status dos empréstimos</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Página inicial</a></li>
                    <li class="breadcrumb-item">Empréstimos</li>
                    <li class="breadcrumb-item active">Status</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Empréstimos próximos da entrega
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" style="table-layout: fixed; width: 100%;">
                            <thead>
                            <tr>
                                <th>DATA DE ENTREGA</th>
                                <th>LIVRO</th>
                                <th>CLIENTE</th>
                                <th>OPÇÕES</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($emprestimosProximos as $emprestimo)
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($emprestimo->dataFimEsperado)) }}</td>
                                    <td>{{ $emprestimo->titulo }}</td>
                                    <td>{{ $emprestimo->nome }}</td>
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
                                        <a href="#" title="Finalizar" class="text-success me-2"
                                           data-bs-toggle="modal" data-bs-target="#modal3"
                                           data-id="{{ $emprestimo->id }}"
                                           style="text-decoration: none">
                                            <i class="fas fa-stamp"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Empréstimos atrasados
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple2" style="table-layout: fixed; width: 100%;">
                            <thead>
                            <tr>
                                <th>DATA DE ENTREGA</th>
                                <th>LIVRO</th>
                                <th>CLIENTE</th>
                                <th>OPÇÕES</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($emprestimosAtrasados as $emprestimo)
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($emprestimo->dataFimEsperado)) }}</td>
                                    <td>{{ $emprestimo->titulo }}</td>
                                    <td>{{ $emprestimo->nome }}</td>
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
                                        <a href="#" title="Finalizar" class="text-success me-2"
                                           data-bs-toggle="modal" data-bs-target="#modal3"
                                           data-id="{{ $emprestimo->id }}"
                                           style="text-decoration: none">
                                            <i class="fas fa-stamp"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
        <div class="modal fade" id="modal3" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Finalizar</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <form method="post" id="formFinalizar" action="{{ route('emprestimo.finalizar') }}">
                                @csrf
                                <input type="hidden" id="finalizarEmprestimoId" name="emprestimo_id">
                                <div class="modal-infos col-12"></div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="formFinalizar" class="btn btn-primary">Enviar</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new simpleDatatables.DataTable("#datatablesSimple", {
                labels: {
                    placeholder: "Buscar...",
                    perPage: "itens por página",
                    noRows: "Nenhum resultado encontrado",
                    info: "Mostrando {start} a {end} de {rows} entradas"
                }
            });


            new simpleDatatables.DataTable("#datatablesSimple2", {
                labels: {
                    placeholder: "Buscar...",
                    perPage: "itens por página",
                    noRows: "Nenhum resultado encontrado",
                    info: "Mostrando {start} a {end} de {rows} entradas"
                }
            });
        });

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
        $('#modal3').on('show.bs.modal', function (event) {
            const botao = event.relatedTarget;
            const id = botao.getAttribute('data-id');
            var modal = $(this);

            $.ajax({
                url: "{{ route('emprestimo.dadosRenovacao', ['id' => '__ID__']) }}".replace('__ID__', id),
                method: 'GET',
                success: function (data) {

                    $('#finalizarEmprestimoId').val(id);

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
                            <div class="col-md-12 mt-3">
                                <span class="select2-label">
                                    Valor a cobrar do cliente: R$ ${data.valorTotal.valor}
                                </span>
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
