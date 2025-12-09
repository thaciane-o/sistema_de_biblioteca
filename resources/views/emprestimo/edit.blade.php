<x-layoutBase>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Empréstimo</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Página inicial</a></li>
            <li class="breadcrumb-item ">Cadastros</li>
            <li class="breadcrumb-item ">Empréstimo</li>
            <li class="breadcrumb-item active">Editar</li>
        </ol>
        <div class="row justify-content-center">
            <div class="col-lg-8 m-5">
                <form method="post" action="{{ route('emprestimo.update', $emprestimo->id) }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control required" id="inputValor" type="text"
                               placeholder="12,34" name="valorPraticado" required
                               value="{{ $emprestimo->valorPraticado }}"
                        />
                        <label for="inputValor">
                            Valor <i class="fa fa-circle icon-required"></i>
                        </label>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="inputDataInicio" type="date"
                                       placeholder="DD/MM/AAAA" name="dataInicio" required
                                       value="{{ $emprestimo->dataInicio }}"
                                />
                                <label for="inputDataInicio">
                                    Data do empréstimo <i class="fa fa-circle icon-required"></i>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="inputDataFimEsperado" type="date"
                                       placeholder="DD/MM/AAAA" name="dataFimEsperado" required
                                       value="{{ $emprestimo->dataFimEsperado }}"
                                />
                                <label for="inputDataFimEsperado">
                                    Data de devolução <i class="fa fa-circle icon-required"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputDataFimReal" type="date"
                               placeholder="DD/MM/AAAA" name="dataFimReal"
                               value="{{ $emprestimo->dataFimReal }}"
                        />
                        <label for="inputDataFimReal">
                            Data devolvida
                        </label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control required" id="inputRenovacoes" type="text"
                               placeholder="Quantidade de renovações" name="renovacoes"
                               value="{{ $emprestimo->renovacoes }}"
                        />
                        <label for="inputRenovacoes">
                            Renovações
                        </label>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="select2-floating mb-3 mb-md-0">
                            <span class="select2-label">
                                Livro <i class="fa fa-circle icon-required"></i>
                            </span>
                            <select class="form-select select2" id="inputLivro" name="livro_id">
                                <option>Selecione um livro...</option>
                                @foreach($livros as $livro)
                                    <option value="{{ $livro->id }}" selected>{{ $livro->titulo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="select2-floating mb-3 mb-md-0">
                            <span class="select2-label">
                                Responsável <i class="fa fa-circle icon-required"></i>
                            </span>
                                <select class="form-select select2" id="inputFuncionario" name="responsaveis_id[]" multiple
                                        data-placeholder="Selecione o(s) responsável(is)">
                                    @foreach($funcionarios as $funcionario)
                                        <option
                                            value="{{ $funcionario->id }}"
                                            {{ in_array($funcionario->id, $responsaveisEmprestimo ?? []) ? 'selected' : '' }}
                                        >
                                        {{ $funcionario->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="select2-floating mb-3 mb-md-0">
                            <span class="select2-label">
                                Cliente <i class="fa fa-circle icon-required"></i>
                            </span>
                                <select class="form-select select2" id="inputCliente" name="cliente_id">
                                    <option>Selecione um cliente...</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}"
                                            @if($cliente->id == $emprestimo->cliente_id) selected @endif>
                                            {{ $cliente->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mb-0">
                        <div class="col-12 text-end">
                            <a class="btn btn-primary btn-block" href="{{ route('emprestimo.index') }}"> <i class="fas fa-reply me-1"></i>
                                Voltar</a>
                            <button type="submit" class="btn btn-primary btn-block">
                                Atualizar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
</x-layoutBase>
