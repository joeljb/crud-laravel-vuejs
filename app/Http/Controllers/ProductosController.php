<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProducto;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Producto;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function index()
      {
         return view('administrador.productos');
      }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(StoreProducto $request)
   {
      if(!\request()->ajax())  return abort(401);
      try{
         $producto = new Producto();

         $producto->nombre_producto = $request->input('nombre_producto');
         $producto->descripcion_producto = $request->input('descripcion_producto');
         $producto->categoria_id = $request->input('categoria_id');
         $producto->imagen = $request->input('imagen');
         $producto->precio = $request->input('precio');
         $producto->descuento = $request->input('descuento');

         DB::transaction(function() use ($producto){
            $producto->save();
         });

         return ["success" => true, "data"=>"Producto Creada"];

      }catch (\Exception $e){
         return abort(401,$e);
      }
   }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProducto $request, $id)
    {
       if(!\request()->ajax())  return abort(401);
       
         try{
            $producto = Producto::find($id);
            if($producto){
               $producto->nombre_producto = $request->input('nombre_producto');
               $producto->precio = $request->input('precio');
               $producto->descuento = $request->input('descuento');
               $producto->imagen = $request->input('imagen');
               $producto->descripcion_producto = $request->input('descripcion_producto');
               $producto->categoria_id = $request->input('categoria_id');
      
               DB::transaction(function() use ($producto){
                  $producto->save();
               });

               return ["success" => true, "data"=>"Producto Actualizado"];
            }else{
               return ["success" => false, "error"=>"Id del producto no encontrado"];
            }

         }catch (\Exception $e){
               return abort(401,$e);
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      public function destroy($id)
      {
         if(!\request()->ajax())  return abort(401);

         try{

            $producto = Producto::find($id);

            if($producto){
               $producto->delete();
               return ["success" => true, "data"=>"Producto Eliminado"];
            }else{
               return ["success" => false, "error"=>"Id del producto no encontrado"];
            }

         }catch (\Exception $e){
               return abort(401,$e);
         }
      }
   public function traer(Request $request)
   {
      if(!\request()->ajax())  return abort(401);
      $buscar = $request->buscar;

      if($buscar == ''){
         $productos = Producto::with('categoria')->orderBy('id','DESC')->paginate(10);
      }else{
         $productos = Producto::with('categoria')->where('nombre_producto','LIKE','%' . $buscar . '%')
         ->orderBy('id','DESC')
         ->paginate(10);
      }

      return [
         'pagination' =>[
            'total' => $productos->total(),
            'current_page' => $productos->currentPage(),
            'per_page' => $productos->perPage(),
            'last_page' => $productos->lastPage(),
            'from' => $productos->firstItem(),
            'to' => $productos->lastItem()
         ],
         'productos' => $productos
      ];
   }
}
