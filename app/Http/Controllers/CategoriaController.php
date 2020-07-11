<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\categoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Tela Listagem todos itens
    public function index()
    {
        $cats = Categoria::all();

        return view('categorias', compact('cats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Tela Criação
    public function create()
    {
        return view('novacategoria');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //Salvar Banco de Dados
    public function store(Request $request)
    {
        $cat = new Categoria();
        $cat->name = $request->input('nomeCategoria');
        $cat->save();
        return redirect('/categorias');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Retorna do banco apenas um item para update
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Busca no banco de dados pelo ID
    public function edit($id)
    {
        $cat = Categoria::find($id);
        if(isset($cat)){
            return view('editarcategoria', compact('cat'));
        }
        return redirect('/categorias');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Recebe o ID do post no form de edit e a request
    public function update(Request $request, $id)
    {
        $cat = Categoria::find($id);
        if(isset($cat)){
            $cat->name = $request->input('nomeCategoria');
            $cat->save();
        }
        return redirect('/categorias');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Exclusão no banco de dados
    public function destroy($id)
    {
        $cat = Categoria::find($id);
        if(isset($cat)) {
            $cat->delete();
        }
        return redirect('/categorias');
    }

    public function indexJson()
    {
        $cats = Categoria::all();

        return json_encode($cats);
    }
}
