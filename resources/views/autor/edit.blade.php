<x-layoutBase>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Autor</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Página inicial</a></li>
            <li class="breadcrumb-item active">Cadastros</li>
            <li class="breadcrumb-item active">Autor</li>
            <li class="breadcrumb-item active">Editar</li>
        </ol>
        <div class="row justify-content-center">
            <div class="col-lg-8 m-5">
                <form method="post" action="{{ route('autor.update', $autor->id) }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control required" id="inputNome" type="text"
                               placeholder="Nome do autor" name="nome" required
                               value="{{ $autor->nome }}"
                        />
                        <label for="inputNome">
                            Nome do autor <i class="fa fa-circle icon-required"></i>
                        </label>
                    </div>
                    <div class="mt-4 mb-0">
                        <div class="col-12 text-end">
                            <a class="btn btn-primary btn-block" href="{{ route('autor.index') }}"> <i class="fas fa-reply me-1"></i>
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
</x-layoutBase>
