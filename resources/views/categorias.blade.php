@extends('layout.app', ['current'=>'categorias'])

@section('body')

<div class="card border">
    <div class="card-body">
    <h5 class="card-title">Cadastro de categorias</h5>
    {{-- if tudo certo, faz --}}
    @if (count($cats) > 0)
        <table class="table table-ordered table-hover">
            <thead>
                <tr>
                    <th>
                        Código
                    </th>
                    <th>
                        Nome Categoria
                    </th>
                    <th>
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody>
        @foreach ($cats as $cat)
                    <tr>
                        <td>
                            {{$cat->id}}
                        </td>
                        <td>
                            {{$cat->name}}
                        </td>
                        <td>
                          <a href="categorias/edit/{{$cat->id}}" class="btn btn-sm btn-primary">Editar</a>
                          <a href="categorias/delete/{{$cat->id}}" class="btn btn-sm btn-danger">Apagar</a>
                        </td>
                    </tr>
        @endforeach
            </tbody>
        </table>
    @endif
    </div>
        <div class="card-footer">
            <a href="/categorias/new" class="btn btn-sm btn-primary" role="button">Nova Categoria</a>
        </div>
</div>

@endsection