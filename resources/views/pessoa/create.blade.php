<x-layoutBase>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Pessoa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/home">Página inicial</a></li>
            <li class="breadcrumb-item active">Cadastros</li>
            <li class="breadcrumb-item active">Pessoa</li>
            <li class="breadcrumb-item active">Criar</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-list me-1"></i>
              Dados gerais
            </div>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 m-5">
                        <form method="post" action="{{ route('pessoa.store') }}">
                            @csrf
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputNome" type="text"
                                       placeholder="Nome Sobrenome" name="nome"/>
                                <label for="inputNome">Nome</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputCPF" type="text"
                                       placeholder="123.456.789-00" name="cpf"/>
                                <label for="inputCPF">CPF</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputTelefone" type="tel"
                                       placeholder="(12) 34567-8900" name="telefone"/>
                                <label for="inputTelefone">Telefone</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputEndereco" type="text"
                                       placeholder="Rua X, Bairro Y, Núm. Z" name="endereco"/>
                                <label for="inputEndereco">Endereço</label>
                            </div>
                            <div class="mt-4 mb-0">
                                <div class="col-12 text-end">
                                    <a class="btn btn-primary btn-block" href="/pessoa"> <i class="fas fa-reply me-1"></i> Voltar</a>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        Cadastrar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
