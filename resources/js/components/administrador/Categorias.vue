<template>

<div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Categorias</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Categorias</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lista de categorias</h3>
              </div>
               <div class="container" style="font-family: 'Questrial', sans-serif;">
                  <div class="row">
                     <div class="col-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                        <input type="text" class="form-control" id="" placeholder="Busqueda..."
                        @keyup="traerProductos(1,buscar)" 
                        v-model="buscar">
                     </div>
                     <div class="col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 text-right">
                     <button type="button" style="background-color: #5DADE2;" class="btn btn-sm text-white" @click="abrirModal('Crear Categoria')"><img src="/images/mas.png" width="14px" alt=""> Crear Caterogia
                     </button>
                     </div>
                  </div>
               </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>                  
                     <tr>
                        <th style="width: 10px">#</th>
                        <th>Categoria</th>
                        <th>Descripcion</th>
                        <th style="width: 40px">Acciones</th>
                     </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(categoria, index) in arrayCategorias">
                      <td v-text="index+1"></td>
                      <td v-text="categoria.nombre_categoria"></td>
                      <td v-text="categoria.descripcion_categoria"></td>
                      <td>
                        <div class="btn-group" role="group">
                           
                           <i class="fa fa-pencil-alt text-success" @click.prevent="abrirModal('Actualizar Categoria',categoria)"></i>
                           <i class="fa fa-trash text-red"  @click.prevent="elimnarCategoria(categoria.id)"></i>

                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item" v-if="pagination.current_page > 1">
                     <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar)">&laquo;</a>
                  </li>
                  <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                     <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar)" v-text="page"></a>
                  </li>
                  <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                     <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar)">&raquo;</a>
                  </li>
                  
                </ul>
              </div>
            </div>
            <!-- /.card -->

          <!-- /.col -->
            </div>
         </div>
      </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

    <div class="modal fade" :class="{'mostrar_modal': mostrarModal}" aria-labelledby="exampleModalCenterTitle">
         <div class="modal-dialog modal-lg mt-5" role="document">
            <div class="modal-content">
            <div class="modal-header p-3">
               <h5 class="modal-title" id="exampleModalCenterTitle" v-text="titulo"></h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cerrarModal">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6  col-xl-6">
                     <label>Categoria</label>
                     <input 
                        type="text" 
                        name="nombre_categoria" 
                        ref="nombre_categoria" 
                        class="form-control" 
                        v-model="nombre_categoria" 
                        placeholder="Ingresar Categoria" 
                        v-validate="{ required: true}" 
                        :class="vnombre_categoria?{ 'is-invalid': errors.has('nombre_categoria'), 'is-valid': !errors.has('nombre_categoria')}:null" required @keyup="verificar('nombre_categoria','descripcion_cateogira')">
                  </div>
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6  col-xl-6">
                     <label>Descripción</label>
                     <input 
                        type="text" 
                        name="descripcion_categoria" 
                        ref="descripcion_categoria" 
                        class="form-control" 
                        v-model="descripcion_categoria" 
                        placeholder="Ingresar Categoria" 
                        v-validate="{ required: true}" 
                        :class="vdescripcion_categoria?{ 'is-invalid': errors.has('descripcion_categoria'), 'is-valid': !errors.has('descripcion_categoria')}:null" required @keyup="verificar('descripcion_categoria','descripcion_cateogira')">
                  </div>
               </div>

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" 
                  @click="cerrarModal"> Cerrar
               </button>
               
               <button type="button" class="btn btn-sm btn-success"
                  @click="guardarCategoria"
               >Crear
               </button>
            </div>
            </div>
         </div>
      </div>
  </div>
</template>

<script>
   export default {
      name: "categorias",
      created(){
         this.traerCategorias(1,this.buscar);
         
      },
      mounted(){
      },
      data(){
         return{
            buscar:'',
            titulo:'',
            arrayCategorias:[],
            mostrarModal:false,
            idCategoria:'',
            nombre_categoria:'',
            descripcion_categoria:'',
            vdescripcion_categoria:false,
            vnombre_categoria:false,
            pagination: {
               'total' : 0,
               'current_page' : 0,
               'per_page' : 0,
               'last_page' : 0,
               'from' : 0,
               'to' : 0
            },
            offset: 3,
         }
      },
      computed:{
         isActived: function () {
            return this.pagination.current_page;
         },
         pagesNumber: function () {
            if(!this.pagination.to){
               return [];
            }
            var from = this.pagination.current_page - this.offset;
            if(from < 1){
               from = 1;
            }
            var to = from + (this.offset * 2);
            if(to >= this.pagination.last_page){
               to = this.pagination.last_page
            }
            var pagesArray = [];
            while(from <= to){
               pagesArray.push(from);
               from++;
            }
            return pagesArray;
         }
      },
      methods:{
         traerCategorias(page,buscar){
            let _this = this;
            var url = '/categorias/traer/?page=' + page + '&buscar=' + buscar ;
            axios.get(url).then(function (response) {
               var respuesta = response.data;
               _this.arrayCategorias = respuesta.categorias.data;
               _this.pagination = respuesta.pagination;
            }).catch(function (error) {
               alert("A ocurrido un error.");
            });
         },

         cambiarPagina(page,buscar){
            let me = this;
            //Actualiza la pagina actual
            me.pagination.current_page = page;
            //Enviar la peticion para visualizar la data de esa página
            me.traerUsuarios(page,buscar);
         },

         verificar(name,sig,t=0){
            var _this = this;
            this.$validator.validate(name).then(function(valid){
               if (valid){
                  _this['v'+sig]=true
                  _this['v'+name]=true
                  _this.$validator.validate(sig);
               }
            })
         },
         abrirModal(titulo,item){
            console.log(item)
            var _this = this
            this.titulo = titulo;
            this.mostrarModal=true;

            if (titulo=='Nueva Categoria') {
               this.idCategoria = "";
               this.nombreCategoria = "";
               this.descripcionCategoria = "";

               setTimeout(function(){
                  
                  
                  _this.vnombre_categoria=true;
                  _this.$validator.validate('nombre_categoria')
                  _this.$refs.nombre_categoria.focus();
               },500)

            }else{
               this.idCategoria = item.id;
               this.nombreCategoria = item.nombre_categoria;
               this.descripcionCategoria = item.descripcion_categoria;
               _this.vnombre_categoria=true;
               _this.vdescripcion_categoria=true;
            }
            
         },
         cerrarModal(){
            this.idCategoria = "";
            this.nombreCategoria = "";
            this.descripcionCategoria = "";
            this.mostrarModal=false;
            this.titulo = "";
            this.vidCategoria=false
            this.vnombreCategoria=false
            this.vdescripcionCategoria=false
         },
         guardarCategoria(){
            var _this = this;

            this.$validator.validate().then(function(valid){
               _this.vidCategoria=true;
               _this.vnombre_categoria=true;
               _this.vdescripcion_categoria=true;
               _this.registrandoCategoria=true;
               _this.disabledRegistrando=true;
               if (valid){
                  let datos = {
                     'id':_this.idCategoria,
                     'nombre_categoria':_this.nombre_categoria,
                     'descripcion_categoria':_this.descripcion_categoria
                  }
                  axios.post(
                     '/categoria/crear',
                     datos
                     ).then(function (response) {

                     if(!response.data.success){
                        alert(response.data.error);
                     }else{
                        _this.cerrarModal();
                        _this.traerCategorias(1,'');
                        alert(response.data.data)
                     }

                  }).catch(function (error) {
                     _this.registrandoCategoria = false;
                     _this.disabledRegistrando = true;
                     alert("A ocurrido un error.");
                  });
               }
            })
         }

      }
   }
</script>

<style>
   .modal-content{
      width: 100% !important;
      position: absolute !important;
      height: auto;
      margin: auto;
   }
   .mostrar_modal{
      display: list-item !important;
      opacity: 1 !important;
      background-color: #3c29297a !important;
      overflow-x: hidden;
      overflow-y: auto;
      z-index: 1072;
   }  
   .error{
      border-color: #dc3545;
   }
   .error:focus{
      border-color: #dc3545;
      box-shadow:0 0 0 0.2rem rgba(40,167,69,.25);
   }
   .success{
      border-color: #28a745;
   }
   .success:focus{
      border-color: #28a745;
      box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25);
   }

   .form-control.is-invalid, .was-validated .form-control:invalid{
       background-image: none;
   }
   .form-control.is-valid, .was-validated .form-control:valid{
      background-image: none;
   }
   
</style>

