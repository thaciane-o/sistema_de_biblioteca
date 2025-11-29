<x-layoutBase>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Funcionário</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Página inicial</a></li>
            <li class="breadcrumb-item ">Cadastros</li>
            <li class="breadcrumb-item ">Funcionário</li>
            <li class="breadcrumb-item active">Editar</li>
        </ol>
        <div class="row justify-content-center">
            <div class="col-lg-8 m-5">
                <form method="post" action="{{ route('funcionario.update', $funcionario->id) }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control required" id="inputMatricula" type="text"
                               placeholder="Matrícula do funcionário" name="matricula" required
                               value="{{ $funcionario->matricula }}"
                        />
                        <label for="inputMatricula">
                            Matrícula <i class="fa fa-circle icon-required"></i>
                        </label>
                    </div>
                    <div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="inputDataAdmissao" type="date"
                                           placeholder="DD/MM/AAAA" name="dataAdmissao" required
                                           value="{{ $funcionario->dataAdmissao }}"
                                    />
                                    <label for="inputDataAdmissao">
                                        Data de admissão <i class="fa fa-circle icon-required"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="inputDataDemissao" type="date"
                                           placeholder="DD/MM/AAAA" name="dataDemissao"
                                           value="{{ $funcionario->dataDemissao }}"
                                    />
                                    <label for="inputDataDemissao">
                                        Data de demissão
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="select2-floating mb-3 mb-md-0">
                                    <span class="select2-label">
                                        Pessoa <i class="fa fa-circle icon-required"></i>
                                    </span>
                                <select class="form-select select2" id="inputPessoa" name="pessoa_id">
                                    <option>Selecione uma pessoa...</option>
                                    @foreach($pessoas as $pessoa)
                                        <option
                                            value="{{ $pessoa->id }}" selected
                                        >
                                            {{$pessoa->nome}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 mb-0">
                            <div class="col-12 text-end">
                                <a class="btn btn-primary btn-block" href="{{ route('funcionario.index') }}"> <i class="fas fa-reply me-1"></i>
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
