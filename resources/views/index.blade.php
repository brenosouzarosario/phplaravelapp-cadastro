@extends('layout.app', ['current'=>'home'])

@section('body')

<div class="jumbotron bg-light border border-secundary">
    <div class="row">
        <div class="card-deck">
            <div class="card border border-primary">
                <div class="card-body">
                    <h5 class="card-title">
                        Cadastro
                    </h5>
                    <p class="card-tex">
                        Cadastro de produtos
                    </p>
                    <a href="/produtos" class="btn btn-primary">
                        Cadastre aqui
                    </a>
                </div>
            </div>
            <div class="card border border-primary">
                <div class="card-body">
                    <h5 class="card-title">
                        Cadastro
                    </h5>
                    <p class="card-tex">
                        Cadastro de categorias
                    </p>
                    <a href="/categorias" class="btn btn-primary">
                        Cadastre aqui
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection