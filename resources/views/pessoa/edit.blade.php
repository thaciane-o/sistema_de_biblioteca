<x-layoutBase>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 m-5">
                <form method="post" action="{{ route('pessoa.update', $pessoa->id) }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputNome" type="text"
                               placeholder="Nome Sobrenome" name="nome" value="{{ $pessoa->nome }}"/>
                        <label for="inputNome">Nome</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputCPF" type="text"
                               placeholder="123.456.789-00" name="cpf" value="{{ $pessoa->cpf }}"/>
                        <label for="inputCPF">CPF</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputTelefone" type="tel"
                               placeholder="(12) 34567-8900" name="telefone" value="{{ $pessoa->telefone }}"/>
                        <label for="inputTelefone">Telefone</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputEndereco" type="text"
                               placeholder="Rua X, Bairro Y, Núm. Z" name="endereco" value="{{ $pessoa->endereco }}"/>
                        <label for="inputEndereco">Endereço</label>
                    </div>
                    <div class="mt-4 mb-0">
                        <div class="d-grid">
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
