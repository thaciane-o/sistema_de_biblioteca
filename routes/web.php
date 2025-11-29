<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PessoaController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\EditoraController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FuncionarioController;

// Página inicial
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rotas de cadastro
Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');
Route::post('/register', Register::class)
    ->middleware('guest');

// Rotas de login
Route::view('/', 'auth.login')
    ->middleware('guest')
    ->name('login');
Route::post('/login', Login::class)
    ->middleware('guest');

// Rotas de logout
Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');

// Pessoa
Route::get('/pessoa', [PessoaController::class, 'index'])->name('pessoa.index');
Route::get('/pessoa/create', [PessoaController::class, 'create'])->name('pessoa.create');
Route::post('/pessoa/create', [PessoaController::class, 'store'])->name('pessoa.store');
Route::get('/pessoa/edit/{id}', [PessoaController::class, 'edit'])->name('pessoa.edit');
Route::post('/pessoa/edit/{id}', [PessoaController::class, 'update'])->name('pessoa.update');
Route::get('/pessoa/destroy/{id}', [PessoaController::class, 'destroy'])->name('pessoa.destroy');
Route::get('/pessoa/show/{id}', [PessoaController::class, 'show'])->name('pessoa.show');

// Autor
Route::get('/autor', [AutorController::class, 'index'])->name('autor.index');
Route::get('/autor/create', [AutorController::class, 'create'])->name('autor.create');
Route::post('/autor/create', [AutorController::class, 'store'])->name('autor.store');
Route::get('/autor/edit/{id}', [AutorController::class, 'edit'])->name('autor.edit');
Route::post('/autor/edit/{id}', [AutorController::class, 'update'])->name('autor.update');
Route::get('/autor/destroy/{id}', [AutorController::class, 'destroy'])->name('autor.destroy');
Route::get('/autor/show/{id}', [AutorController::class, 'show'])->name('autor.show');

// Editora
Route::get('/editora', [EditoraController::class, 'index'])->name('editora.index');
Route::get('/editora/create', [EditoraController::class, 'create'])->name('editora.create');
Route::post('/editora/create', [EditoraController::class, 'store'])->name('editora.store');
Route::get('/editora/edit/{id}', [EditoraController::class, 'edit'])->name('editora.edit');
Route::post('/editora/edit/{id}', [EditoraController::class, 'update'])->name('editora.update');
Route::get('/editora/destroy/{id}', [EditoraController::class, 'destroy'])->name('editora.destroy');
Route::get('/editora/show/{id}', [EditoraController::class, 'show'])->name('editora.show');

// Livro
Route::get('/livro', [LivroController::class, 'index'])->name('livro.index');
Route::get('/livro/create', [LivroController::class, 'create'])->name('livro.create');
Route::post('/livro/create', [LivroController::class, 'store'])->name('livro.store');
Route::get('/livro/edit/{id}', [LivroController::class, 'edit'])->name('livro.edit');
Route::post('/livro/edit/{id}', [LivroController::class, 'update'])->name('livro.update');
Route::get('/livro/destroy/{id}', [LivroController::class, 'destroy'])->name('livro.destroy');
Route::get('/livro/show/{id}', [LivroController::class, 'show'])->name('livro.show');

// Cliente
Route::get('/cliente', [ClienteController::class, 'index'])->name('cliente.index');
Route::get('/cliente/create', [ClienteController::class, 'create'])->name('cliente.create');
Route::post('/cliente/create', [ClienteController::class, 'store'])->name('cliente.store');
Route::get('/cliente/edit/{id}', [ClienteController::class, 'edit'])->name('cliente.edit');
Route::post('/cliente/edit/{id}', [ClienteController::class, 'update'])->name('cliente.update');
Route::get('/cliente/destroy/{id}', [ClienteController::class, 'destroy'])->name('cliente.destroy');
Route::get('/cliente/show/{id}', [ClienteController::class, 'show'])->name('cliente.show');

// Funcionário
Route::get('/funcionario', [FuncionarioController::class, 'index'])->name('funcionario.index');
Route::get('/funcionario/create', [FuncionarioController::class, 'create'])->name('funcionario.create');
Route::post('/funcionario/create', [FuncionarioController::class, 'store'])->name('funcionario.store');
Route::get('/funcionario/edit/{id}', [FuncionarioController::class, 'edit'])->name('funcionario.edit');
Route::post('/funcionario/edit/{id}', [FuncionarioController::class, 'update'])->name('funcionario.update');
Route::get('/funcionario/destroy/{id}', [FuncionarioController::class, 'destroy'])->name('funcionario.destroy');
Route::get('/funcionario/show/{id}', [FuncionarioController::class, 'show'])->name('funcionario.show');
