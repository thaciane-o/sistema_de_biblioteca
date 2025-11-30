<x-layout>
    <x-slot:title>
        Sign In
    </x-slot:title>

    <div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 16rem);">
        <div class="card shadow-sm" style="width: 28rem;">
            <div class="card-body">

                <h4 class="text-center mb-4 fw-bold">Bem-vindo(a)</h4>

                <form method="POST" action="/login">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="email@exemplo.com"
                               value="{{ old('email') }}"
                               required
                               autofocus>
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

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Lembrar de mim
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Entrar
                    </button>
                </form>

                <div class="text-center my-3">
                    <span class="text-muted">OU</span>
                </div>

                <p class="text-center">
                    Não tem uma conta?
                    <a href="/register" class="link-primary text-decoration-none">Registrar</a>
                </p>

            </div>
        </div>
    </div>
</x-layout>
