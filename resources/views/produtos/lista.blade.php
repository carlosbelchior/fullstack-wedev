@extends('base.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Produtos
                    <a class="btn btn-primary btn-sm" href="{{ route('cliente.gerenciar') }}">+</a>
                </div>

                <div class="card-body">
                    <lista-clientes></lista-clientes>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
