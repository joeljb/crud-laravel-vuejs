<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function index()
      {
         return view('administrador.categorias');
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
   public function store(Request $request)
   {
      if(!\request()->ajax())  return abort(401);
         $validator =  Validator::make($request->all(), [
            'nombre_categoria' => 'required',
            'descripcion_categoria' => 'required'
         ]);

         if($validator->fails()){
            return response(['errors' => $validator->errors()],422);
         }
        try{
            $categoria = new Categoria();

            $categoria->nombre_categoria = $request->input('nombre_categoria');
            $categoria->descripcion_categoria = $request->input('descripcion_categoria');
   
            DB::transaction(function() use ($categoria){
               $categoria->save();
            });

            return ["success" => true, "data"=>"Categoria Creada"];

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
    public function update(Request $request, $id)
    {
       if(!\request()->ajax())  return abort(401);
         $validator =  Validator::make($request->all(), [
            'nombre_categoria' => 'required',
            'descripcion_categoria' => 'required'
         ]);

         if($validator->fails()){
            return response(['errors' => $validator->errors()],422);
         }

         try{
            $categoria = Categoria::find($id);
            if($categoria){
               $categoria->nombre_categoria = $request->input('nombre_categoria');
               $categoria->descripcion_categoria = $request->input('descripcion_categoria');
      
               DB::transaction(function() use ($categoria){
                  $categoria->save();
               });

               return ["success" => true, "data"=>"Categoria Actualizada"];
            }else{
               return ["success" => false, "error"=>"Id de la categoria no encontrada"];
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

            $categoria = Categoria::find($id);

            if($categoria){
               $categoria->delete();
               return ["success" => true, "data"=>"Categoria Eliminada"];
            }else{
               return ["success" => false, "error"=>"Id de la categoria no encontrada"];
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
         $categorias = Categoria::orderBy('id','DESC')->paginate(5);
      }else{
         $categorias = Categoria::where('nombre_categoria','LIKE','%' . $buscar . '%')
         ->orderBy('id','DESC')
         ->paginate(5);
      }

      return [
         'pagination' =>[
            'total' => $categorias->total(),
            'current_page' => $categorias->currentPage(),
            'per_page' => $categorias->perPage(),
            'last_page' => $categorias->lastPage(),
            'from' => $categorias->firstItem(),
            'to' => $categorias->lastItem()
         ],
         'categorias' => $categorias
      ];
   }
}
