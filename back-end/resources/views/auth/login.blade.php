@extends('layouts.app')

@section('title', 'Login - TabInfo')

@section('content')
<div class="card">
    <h1>Bem-vindo de volta</h1>
    <p>Entre com suas credenciais para acessar o sistema</p>

    @if ($errors->any())
        <div class="alert alert-error">
            <strong>Erro!</strong> {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf

        <div class="form-group">
            <label for="email">E-mail</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
            >
        </div>

        <div class="form-group">
            <label for="password">Senha</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Lembrar-me</label>
            </div>
        </div>

        <button type="submit" class="btn">Entrar</button>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <p style="color: #666; margin-bottom: 10px;">Não tem uma conta?</p>
        <a href="{{ route('register') }}" style="color: #667eea; text-decoration: none; font-weight: 500;">
            Criar conta aqui
        </a>
    </div>
</div>
@endsection
