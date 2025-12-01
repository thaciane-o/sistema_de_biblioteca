<x-layout>
    <x-slot:title>
        Register
    </x-slot:title>

    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-sm" style="width: 28rem;">
            <div class="card-body">

                <h4 class="text-center mb-4 fw-bold">Criar conta</h4>

                <form method="POST" action="/register">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="John Doe"
                               required>
                        <label for="name">Nome</label>

                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="email@exemplo.com"
                               required>
                        <label for="email">Email</label>

                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••"
                               required>
                        <label for="password">Senha</label>

                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               placeholder="••••••••"
                               required>
                        <label for="password_confirmation">Confirmar senha</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-2">
                        Registrar
                    </button>
                </form>

                <div class="text-center my-3">
                    <span class="text-muted">OU</span>
                </div>

                <p class="text-center">
                    Já tem uma conta?
                    <a href="/" class="text-decoration-none link-primary">Entrar</a>
                </p>

            </div>
        </div>
    </div>
</x-layout>
