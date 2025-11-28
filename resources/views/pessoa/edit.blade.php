<x-layoutBase>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Pessoa</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Página inicial</a></li>
            <li class="breadcrumb-item active">Cadastros</li>
            <li class="breadcrumb-item active">Pessoa</li>
            <li class="breadcrumb-item active">Editar</li>
        </ol>
        <div class="row justify-content-center">
            <div class="col-lg-8 m-5">
                <form method="post" action="{{ route('pessoa.update', $pessoa->id) }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control required" id="inputNome" type="text"
                               placeholder="Nome Sobrenome" name="nome" required
                               value="{{ $pessoa->nome }}"
                        />
                        <label for="inputNome">
                            Nome <i class="fa fa-circle icon-required"></i>
                        </label>
                    </div>
                    <div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 mb-md-0">
                                    <input class="form-control" id="inputCPF" type="text"
                                           placeholder="123.456.789-00" name="cpf" required
                                           value="{{ $pessoa->cpf }}"
                                    />
                                    <label for="inputCPF">
                                        CPF <i class="fa fa-circle icon-required"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input class="form-control" id="inputTelefone" type="tel"
                                           placeholder="(12) 34567-8900" name="telefone" required
                                           value="{{ $pessoa->telefone }}"
                                    />
                                    <label for="inputTelefone">
                                        Telefone <i class="fa fa-circle icon-required"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputEndereco" type="text"
                               placeholder="Rua X, Bairro Y, Núm. Z" name="endereco" required
                               value="{{ $pessoa->endereco }}"
                        />
                        <label for="inputEndereco">
                            Endereço <i class="fa fa-circle icon-required"></i>
                        </label>
                    </div>
                    <div class="mt-4 mb-0">
                        <div class="col-12 text-end">
                            <a class="btn btn-primary btn-block" href="{{ route('pessoa.index') }}"> <i class="fas fa-reply me-1"></i>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#inputCPF').mask("000.000.000-00");
            $('#inputTelefone').mask('(00) 00000-0000');

            $('form').on('submit', function () {
                $('#inputCPF').val($('#inputCPF').cleanVal());
                $('#inputTelefone').val($('#inputTelefone').cleanVal());
            });
        });

    </script>
</x-layoutBase>
