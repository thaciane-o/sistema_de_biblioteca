<x-layoutBase>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Cliente</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Página inicial</a></li>
            <li class="breadcrumb-item">Cadastros</li>
            <li class="breadcrumb-item">Cliente</li>
            <li class="breadcrumb-item active">Criar</li>
        </ol>
        <div class="row justify-content-center">
            <div class="col-lg-8 m-5">
                <form method="post" action="{{ route('cliente.store') }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control required" id="inputMatricula" type="text"
                               placeholder="Matrícula do cliente" name="matricula" maxlength="10" required/>
                        <label for="inputMatricula">
                            Matrícula <i class="fa fa-circle icon-required"></i>
                        </label>
                    </div>
                    <div class="col-md-12">
                        <div class="select2-floating mb-3 mb-md-0">
                            <span class="select2-label">
                                Pessoa <i class="fa fa-circle icon-required"></i>
                            </span>
                            <select class="form-select select2" id="inputPessoa" name="pessoa_id">
                                <option selected>Selecione uma pessoa...</option>
                                @foreach($pessoas as $pessoa)
                                    <option value="{{ $pessoa->id }}">{{ $pessoa->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 mb-0">
                        <div class="col-12 text-end">
                            <a class="btn btn-primary btn-block" href="{{ route('cliente.index') }}"> <i class="fas fa-reply me-1"></i>
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
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
</x-layoutBase>
