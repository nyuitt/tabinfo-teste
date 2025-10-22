@extends('layouts.app')

@section('title', 'Dashboard - TabInfo')

@section('content')
<div class="card">
    <div class="dashboard-header">
        <h1>Dashboard</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary">Sair</button>
        </form>
    </div>

    <div class="user-info">
        <h2>Informações do Usuário</h2>
        <p><strong>Nome:</strong> {{ auth()->user()->name }}</p>
        <p><strong>E-mail:</strong> {{ auth()->user()->email }}</p>
        <p>
            <strong>Tipo:</strong>
            @if(auth()->user()->is_admin)
                <span class="badge">Administrador</span>
            @else
                <span class="badge" style="background: #6c757d;">Usuário</span>
            @endif
        </p>
    </div>

    <div style="color: #666; text-align: center; margin-top: 30px;">
        <p>Bem-vindo ao sistema TabInfo!</p>
        <p>Use o aplicativo mobile para gerenciar usuários e acessar funcionalidades completas.</p>
    </div>
</div>
@endsection
