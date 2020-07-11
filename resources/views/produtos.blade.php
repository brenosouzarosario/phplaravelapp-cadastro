@extends('layout.app', ['current'=>'produtos'])

@section('body')
<div class="card border">
    <div class="card-body">
    <h5 class="card-title">Cadastro de produtos</h5>
    {{-- if tudo certo, faz --}}
        <table class="table table-ordered table-hover" id="tabelaProdutos">
            <thead>
                <tr>
                    <th>
                        Código
                    </th>
                    <th>
                        Nome produto
                    </th>
                    <th>
                        Quantidade
                    </th>
                    <th>
                        Preço
                    </th>
                    <th>
                        Categoria
                    </th>
                    <th>
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
        <div class="card-footer">
            <button class="btn btn-sm btn-primary" role="button" onclick="novoProduto();">Nova produto</button>
        </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="dlgProdutos">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="formProduto">
                <div class="modal-header">
                    <h5 class="modal-title">Novo produto</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="id">
                    <div class="form-group">
                        <label for="nomeProduto" class="control-label">Nome do produto</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="nomeProduto" placeholder="Nome do produto">
                        </div>
                </div>
                <div class="form-group">
                    <label for="quantidadeProduto" class="control-label">Quantidade do produto</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="quantidadeProduto" placeholder="Quantidade do produto">
                    </div>
            </div>
            <div class="form-group">
                <label for="precoProduto" class="control-label">Preço do produto</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="precoProduto" placeholder="Preço do produto">
                </div>
        </div>
        <div class="form-group">
            <label for="categoriaProduto" class="control-label">Categoria do produto</label>
            <div class="input-group">
                <select class="form-control" id="categoriaProduto">

                </select>
            </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
        <button type="cancel" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('javascript')
 <script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });

    function novoProduto() {
        $('#id').val('');
        $('#nomeProduto').val('');
        $('#quantidadeProduto').val('');
        $('#precoProduto').val('');

        $('#dlgProdutos').modal('show')
    }

    function carregarCategoria () {
        $.getJSON('/api/categorias', (data) => {
            for (let i = 0; i < data.length; i++) {
                const opcao = '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                $('#categoriaProduto').append(opcao);
            }
        });
    }

    function montarLinha (p) {
        let linha = '<tr>' +
                    '<td>' + p.id + '</td>' +
                    '<td>' + p.name + '</td>' +
                    '<td>' + p.stock + '</td>' +
                    '<td>' + p.price + '</td>' +
                    '<td>' + p.categoria_id + '</td>' +
                    '<td>' + 
                        '<button class="btn btn-sm btn-primary" onclick="editar('+p.id+')"> Editar </button>' +
                        '<button class="btn btn-sm btn-danger" onclick="remover('+p.id+')"> Apagar </button>' +
                    '</td>' +
                    '</tr>';

                    return linha;
    }

    function editar(id) {
        $.getJSON('/api/produtos/'+id, (data) => {
        $('#id').val(data.id);
        $('#nomeProduto').val(data.name);
        $('#quantidadeProduto').val(data.stock);
        $('#precoProduto').val(data.price);
        $('#categoriaProduto').val(data.categoria_id);
        $('#dlgProdutos').modal('show')
        });
    }

    function remover(id) {
        $.ajax({
            type: 'delete',
            url: "/api/produtos/" + id,
            context: this,
            success: () => {
                const linhas = $('#tabelaProdutos>tbody>tr');
                const e = linhas.filter(function (i, elemento) {
                    return elemento.cells[0].textContent == id;
                });
                if (e) {
                    e.remove();
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function carregarProdutos () {
        $.getJSON('/api/produtos', (produtos) => { for (let i = 0; i < produtos.length; i++) {
            const linha = montarLinha(produtos[i]);

            $('#tabelaProdutos>tbody').append(linha);
        } 
    });
    }
    function criarProduto () {
        const prod = {
        nome : $('#nomeProduto').val(), 
        preco: $('#precoProduto').val(), 
        estoque: $('#quantidadeProduto').val(), 
        categoria_id: $('#categoriaProduto').val()
        }
        $.post("/api/produtos", prod, function(data){
            const produto = JSON.parse(data);

            const linha = montarLinha(produto);

            $('#tabelaProdutos>tbody').append(linha);
        });
    }

    function salvarProduto() {
        const prod = {
        id: $('#id').val(),
        nome : $('#nomeProduto').val(), 
        preco: $('#precoProduto').val(), 
        estoque: $('#quantidadeProduto').val(), 
        categoria_id: $('#categoriaProduto').val()
        }

        $.ajax({
            type: 'PUT',
            url: "/api/produtos/" + prod.id,
            context: this,
            data: prod,
            success: function (data) {
                const prod = JSON.parse(data);
                const linhas = $('#tabelaProdutos>tbody>tr');
                const e = linhas.filter(function (i, e) {
                    return (e.cells[0].textContent == prod.id);
                });
                if (e) {
                    e[0].cells[0].textContent = prod.id;
                    e[0].cells[1].textContent = prod.name;
                    e[0].cells[2].textContent = prod.stock;
                    e[0].cells[3].textContent = prod.price;
                    e[0].cells[4].textContent = prod.categoria_id;
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    $('#formProduto').submit((event)=> {
        event.preventDefault();
        if($('#id').val() != '') {
            salvarProduto();
        }
        else {
            criarProduto();
        }
        $('#dlgProdutos').modal('hide');
    });

    $(function() {
        carregarCategoria();
        carregarProdutos();
    })

</script>  
@endsection