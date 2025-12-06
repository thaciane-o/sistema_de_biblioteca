<x-layoutBase>
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-6">
                <h1 class="mt-4">Livro</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Página inicial</a></li>
                    <li class="breadcrumb-item active">Cadastros</li>
                    <li class="breadcrumb-item active">Livro</li>
                </ol>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-end mb-4">
                <a class="btn btn-primary btn-block px-3 py-2" href="{{ route('livro.create') }}"> <i
                        class="fas fa-plus me-1"></i> Criar</a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Dados dos livros
            </div>
            <div class="card-body">
                <table id="datatablesSimple" style="table-layout: fixed; width: 100%;">
                    <thead>
                    <tr>
                        <th>ISBN</th>
                        <th>TÍTULO</th>
                        <th>EDIÇÃO</th>
                        <th>OPÇÕES</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($livros as $livro)
                        <tr>
                            <td>{{ preg_replace('/(\d{3})(\d{9})/', '$1-$2', $livro->isbn) }}</td>
                            <td>{{ $livro->titulo }}</td>
                            <td>{{ $livro->edicao }}</td>
                            <td>
                                <a href="#" title="Visualizar" class="text-primary me-2"
                                   data-bs-toggle="modal" data-bs-target="#modal"
                                   data-id="{{ $livro->id }}"
                                   style="text-decoration: none">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('livro.edit', $livro->id)  }}" title="Atualizar"
                                   class="text-success me-2"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('livro.destroy', $livro->id) }}"
                                   class="text-danger" onclick="return confirm('Tem certeza que deseja excluir este livro?')">
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
                url: "{{ route('livro.show', ['id' => '__ID__']) }}".replace('__ID__', id),
                method: 'GET',
                success: function (data) {
                    const isbn = formatarISBN(data.livro.isbn);
                    const data_publicacao = formatarData(data.livro.dataPublicacao);
                    const criado_em = formatarData(data.livro.created_at);
                    const atualizado_em = formatarData(data.livro.updated_at);
                    const valor = Number(data.livro.valorEmprestimo).toFixed(2).replace('.', ',');
                    const editoras = data.livro.editoras != null ? data.livro.editoras : "<i>Sem editora</i>";

                    modal.find('.modal-infos').html(`
                        <div class="row mb-3">
                            <div class="col-12">
                                <b>Título:</b> ${data.livro.titulo}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <b>Autor(es):</b> ${data.livro.autores}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <b>Editora(s):</b> ${editoras}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <b>ISBN:</b> ${isbn}
                            </div>
                            <div class="col-6">
                                <b>Edição:</b> ${data.livro.edicao}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <b>Data de publicação:</b> ${data_publicacao}
                            </div>
                            <div class="col-6">
                                <b>Valor empréstimo:</b> R$ ${valor}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <b>Quantidade em estoque:</b> ${data.livro.qtdEstoque}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <b>Descrição:</b> ${data.livro.descricao ?? "<i>Sem descrição</i>"}
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
