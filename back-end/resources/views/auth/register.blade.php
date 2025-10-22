@extends('layouts.app')

@section('title', 'Cadastro - TabInfo')

@section('content')
<div class="card">
    <h1>Criar Conta</h1>
    <p>Preencha os dados abaixo para criar sua conta</p>

    @if ($errors->any())
        <div class="alert alert-error">
            <strong>Erro!</strong>
            <ul style="margin: 8px 0 0 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Nome Completo</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                placeholder="Seu nome completo"
            >
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                placeholder="seu@email.com"
            >
        </div>

        <div class="form-group">
            <label for="password">Senha</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                placeholder="Mínimo 8 caracteres"
            >
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar Senha</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
                placeholder="Digite a senha novamente"
            >
        </div>

        <button type="submit" class="btn">Criar Conta</button>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <p style="color: #666; margin-bottom: 10px;">Já tem uma conta?</p>
        <a href="{{ route('login') }}" style="color: #667eea; text-decoration: none; font-weight: 500;">
            Faça login aqui
        </a>
    </div>
</div>
@endsection
