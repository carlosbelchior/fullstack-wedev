@extends('base.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Clientes
                    <a class="btn btn-primary btn-sm" href="{{ route('cliente.gerenciar') }}">+</a>
                </div>

                <div class="card-body" id="listaClientes">
                    <lista-clientes></lista-clientes>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptsVue')
    <script src="{!! asset('js/cliente/lista.js') !!}"></script>
@endsection