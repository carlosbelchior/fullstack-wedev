@extends('base.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Gerenciar pedido
                </div>

                <div class="card-body">
                    <form method="POST">
                        @csrf

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Nome</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="nome" required autocomplete="false" autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">CPF</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="cpf" required autocomplete="false" autofocus>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">E-mail</label>
                            <div class="col-md-4">
                                <input type="email" class="form-control" name="email" required autocomplete="false" autofocus>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
