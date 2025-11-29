<x-layoutBase>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Livro</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Página inicial</a></li>
            <li class="breadcrumb-item active">Cadastros</li>
            <li class="breadcrumb-item active">Livro</li>
            <li class="breadcrumb-item active">Criar</li>
        </ol>
        <div class="row justify-content-center">
            <div class="col-lg-8 m-5">
                <form method="post" action="{{ route('livro.store') }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control required" id="inputTitulo" type="text"
                               placeholder="Título" name="titulo" required/>
                        <label for="inputTitulo">
                            Título <i class="fa fa-circle icon-required"></i>
                        </label>
                    </div>
                    <div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="inputISBN" type="text"
                                           placeholder="123-4567890000" name="isbn" required/>
                                    <label for="inputISBN">
                                        ISBN <i class="fa fa-circle icon-required"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="inputEdicao" type="number"
                                           placeholder="1" name="edicao" required/>
                                    <label for="inputEdicao">
                                        Edição <i class="fa fa-circle icon-required"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="select2-floating mb-3 mb-md-0">
                                    <span class="select2-label">
                                        Autor(es) <i class="fa fa-circle icon-required"></i>
                                    </span>
                                    <select class="form-select select2" id="inputAutores" name="autores[]"
                                            data-placeholder="Selecione o(s) autor(es)" multiple>
                                        @foreach($autores as $autor)
                                            <option value="{{ $autor->id }}">{{$autor->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="select2-floating mb-3 mb-md-0">
                                    <span class="select2-label">
                                        Editora(s)
                                    </span>
                                    <select class="form-select select2" id="inputEditoras" name="editoras[]"
                                            data-placeholder="Selecione a(s) editora(s)" multiple>
                                        @foreach($editoras as $editora)
                                            <option value="{{ $editora->id }}">{{$editora->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="inputDataPublicacao" type="date"
                                           placeholder="DD/MM/AAAA" name="dataPublicacao" required value=""/>
                                    <label for="inputDataPublicacao">
                                        Data de publicação <i class="fa fa-circle icon-required"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="inputValorEmprestimo" type="number" step="0.01"
                                           placeholder="12.34" name="valorEmprestimo" required/>
                                    <label for="inputValorEmprestimo">
                                        Valor de empréstimo <i class="fa fa-circle icon-required"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputQtdEstoque" type="number"
                               placeholder="12" name="qtdEstoque" required/>
                        <label for="inputQtdEstoque">
                            Quantidade em estoque <i class="fa fa-circle icon-required"></i>
                        </label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="inputDescricao" name="descricao" rows="6"
                                  placeholder="12"></textarea>
                        <label for="inputDescricao">
                            Descrição
                        </label>
                    </div>
                    <div class="mt-4 mb-0">
                        <div class="col-12 text-end">
                            <a class="btn btn-primary btn-block" href="{{ route('livro.index') }}"> <i
                                    class="fas fa-reply me-1"></i>
                                Voltar</a>
                            <button type="submit" class="btn btn-primary btn-block">
                                Cadastrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#inputISBN').mask("000-0000000000");

            $('form').on('submit', function () {
                $('#inputISBN').val($('#inputISBN').cleanVal());
            });

            $('.select2').select2({
                theme: 'bootstrap-5'
            });
        });

    </script>
</x-layoutBase>
