<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PessoaController;
use Illuminate\Support\Facades\Route;

// Página inicial
Route::get('/home', [HomeController::class, 'index']);

// Registration routes
Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');
Route::post('/register', Register::class)
    ->middleware('guest');

// Login routes
Route::view('/', 'auth.login')
    ->middleware('guest')
    ->name('login');
Route::post('/login', Login::class)
    ->middleware('guest');

// Logout route
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
