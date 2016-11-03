<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;
use sisVentas\Articulo;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use sisVentas\Http\Requests\ArticuloFormRequest;
use DB;

class ArticuloController extends Controller
{
  public function __construct()
  {

  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
      /*Recibo parametros tipo request*/
      if ($request) {
          /*Realizar búsquedas por categorias quitando espacios*/
          $query = trim($request->get('searchText'));
          $articulos = DB::table('articulo as a')
              ->join('categoria as c', 'a.idcategoria', '=', 'c.idcategoria')
              ->select('a.idarticulo', 'a.nombre', 'a.codigo', 'a.stock', 'c.nombre as categoria', 'a.descripcion', 'a.imagen', 'a.estado')
              ->where('a.nombre', 'LIKE', '%' . $query . '%')
              ->orwhere('a.codigo', 'LIKE', '%' . $query . '%')
              ->orderBy('idarticulo', 'desc')
              ->paginate(7);

          return view('almacen.articulo.index', ["articulos" => $articulos, "searchText" => $query]);
      }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      //enviar listado de categorías
      $categorias = DB::table('categoria')->where('condicion', '=', '1')->get();
      return view("almacen.articulo.create", ["categorias" => $categorias]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(ArticuloFormRequest $request)
  {
      $articulo = new Articulo;
      $articulo->idcategoria = $request->get('idcategoria');
      $articulo->codigo = $request->get('codigo');
      $articulo->nombre = $request->get('nombre');
      $articulo->stock = $request->get('stock');
      $articulo->descripcion = $request->get('descripcion');
      $articulo->estado = 'Activo';

      /* Validar y subir la imagen*/
      if (Input::hasFile('imagen')) {
          $file = Input::file('imagen');
          $file->move(public_path() . '/imagenes/articulos/', $file->getClientOriginalName());
          $articulo->imagen = $file->getClientOriginalName();
      }

      $articulo->save();
      return Redirect::to('almacen/articulo');
  }

  /**
   * Display the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      /*Llamar a la categoría con el id necesario*/
      return view('almacen.articulo.show', ['articulo' => Articulo::findOrFail($id)]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      $articulo = Articulo::findOrFail($id);
      $categorias = DB::table('categoria')->where('condicion', '=', '1')->get();
      return view('almacen.articulo.edit', ["articulo" => $articulo, "categorias" => $categorias]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function update(ArticuloFormRequest $request, $id)
  {
      $articulo = Articulo::findOrFail($id);
      $articulo->idcategoria = $request->get('idcategoria');
      $articulo->codigo = $request->get('codigo');
      $articulo->nombre = $request->get('nombre');
      $articulo->stock = $request->get('stock');
      $articulo->descripcion = $request->get('descripcion');

      /* Validar y subir la imagen*/
      if (Input::hasFile('imagen')) {
          $file = Input::file('imagen');
          $file->move(public_path() . '/imagenes/articulos/', $file->getClientOriginalName());
          $articulo->imagen = $file->getClientOriginalName();
      }
      $articulo->update();

      return Redirect::to('almacen/articulo');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      $articulo = Articulo::findOrFail($id);
      $articulo->estado = 'Inactivo';
      $articulo->update();
      return Redirect::to('almacen/articulo');
  }
}
