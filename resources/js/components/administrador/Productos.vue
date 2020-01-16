<template>
   <div>
      <!-- Content Header (Page header) -->
      <section class="content-header">
         <div class="container-fluid">
            <div class="row mb-2">
               <div class="col-sm-6">
                  <h1>Productos</h1>
               </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Productos</li>
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
                  <h3 class="card-title">Lista de productos</h3>
               </div>
                  <div class="container" style="font-family: 'Questrial', sans-serif;">
                     <div class="row">
                        <div class="col-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                           <input type="text" class="form-control" id="" placeholder="Busqueda..."
                           @keyup="traerProductos(1,buscar)" 
                           v-model="buscar">
                        </div>
                        <div class="col-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 text-right">
                        <button type="button" style="background-color: #5DADE2;" class="btn btn-sm text-white" @click="abrirModal('REGISTRAR')"><img src="/images/mas.png" width="14px" alt=""> Crear Producto
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
                           <th>Productos</th>
                           <th>Precio</th>
                           <th>Descuento</th>
                           <th>Descripcion</th>
                           <th style="width: 40px">Acciones</th>
                        </tr>
                     </thead>
                     <tbody>
                     <tr v-for="(producto, index) in arrayProductos">
                        <td v-text="index+1"></td>
                        <td v-text="producto.categoria.nombre_categoriaguardar"></td>
                        <td v-text="producto.nombre_producto"></td>
                        <td v-text="producto.descripcion_producto"></td>
                        <td v-text="producto.precio"></td>
                        <td v-text="producto.descuento"></td>
                        <td v-text="producto.descripcion_producto"></td>
                        <td>
                           <div class="btn-group" role="group">
                              
                              <i class="fa fa-pencil-alt text-success" @click.prevent="abrirModal('ACTUALIZAR',producto)"></i>
                              <i class="fa fa-trash text-red"  @click.prevent="eliminarProducto(producto.id)"></i>
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
                     <select 
                        class="form-control" 
                        v-model="id_categoria" 
                        name="id_categoria" 
                        v-validate="{ required: true}" 
                        :class="vid_categoria?{ 'is-invalid': errors.has('id_categoria'), 'is-valid': !errors.has('categoria')}:null" required @keyup="verificar('id_categoria','nombre_producto')"
                         @change="verificar('id_categoria','nombre_producto')"
                     >
                        <option value="" >Seleccione Categoria...</option>
                        <option v-for="categoria in arrayCategorias" :value="categoria.id" v-text="categoria.nombre_categoria"></option>
                     </select>
                     
                     <div v-if="errors.has('id_categoria')">
                        <span class="help-block text-danger" v-text="errors.first('id_categoria')"></span>
                     </div>
                     <div v-if="errorProducto.id_categoria != null">
                        <div v-for="error in errorProducto.id_categoria">
                           <span class="help-block text-danger" v-text="error"></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6  col-xl-6">
                     <label>Nombre Producto</label>
                     <input 
                        type="text" 
                        name="nombre_producto" 
                        ref="nombre_producto" 
                        class="form-control" 
                        v-model="nombre_producto" 
                        placeholder="Ingresar Nombre Producto" 
                        v-validate="{ required: true}" 
                        :class="vnombre_producto?{ 'is-invalid': errors.has('nombre_producto'), 'is-valid': !errors.has('nombre_producto')}:null" required @keyup="verificar('nombre_producto','descripcion_producto')">
                        <div v-if="errors.has('nombre_producto')">
                           <span class="help-block text-danger" v-text="errors.first('nombre_producto')"></span>
                        </div>
                        <div v-if="errorProducto.nombre_producto != null">
                           <div v-for="error in errorProducto.nombre_producto">
                              <span class="help-block text-danger" v-text="error"></span>
                           </div>
                        </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6  col-xl-6">
                     <label>Nombre Precio</label>
                     <input 
                        type="text" 
                        name="precio" 
                        ref="precio" 
                        class="form-control" 
                        v-model="precio" 
                        placeholder="Ingresar Nombre Producto" 
                        v-validate="{ required: true}" 
                        :class="vprecio?{ 'is-invalid': errors.has('precio'), 'is-valid': !errors.has('precio')}:null" required @keyup="verificar('precio','descripcion_producto')">
                        <div v-if="errors.has('precio')">
                           <span class="help-block text-danger" v-text="errors.first('precio')"></span>
                        </div>
                        <div v-if="errorProducto.precio != null">
                           <div v-for="error in errorProducto.precio">
                              <span class="help-block text-danger" v-text="error"></span>
                           </div>
                        </div>
                  </div>
                   <div class="col-12 col-sm-6 col-md-6 col-lg-6  col-xl-6">
                     <label>Nombre Precio</label>
                     <input 
                        type="text" 
                        name="descuento" 
                        ref="descuento" 
                        class="form-control" 
                        v-model="descuento" 
                        placeholder="Ingresar Nombre Producto" 
                        v-validate="{ required: true}" 
                        :class="vdescuento?{ 'is-invalid': errors.has('descuento'), 'is-valid': !errors.has('descuento')}:null" required @keyup="verificar('descuento','descripcion_producto')">
                        <div v-if="errors.has('descuento')">
                           <span class="help-block text-danger" v-text="errors.first('descuento')"></span>
                        </div>
                        <div v-if="errorProducto.descuento != null">
                           <div v-for="error in errorProducto.descuento">
                              <span class="help-block text-danger" v-text="error"></span>
                           </div>
                        </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6  col-xl-6">
                     <label>Descripción Producto</label>
                     <input 
                        type="text" 
                        name="descripcion_producto" 
                        ref="descripcion_producto" 
                        class="form-control" 
                        v-model="descripcion_producto" 
                        placeholder="Ingresar Descripcion" 
                        v-validate="{ required: true}" 
                        :class="vdescripcion_producto?{ 'is-invalid': errors.has('descripcion_producto'), 'is-valid': !errors.has('descripcion_producto')}:null" required @keyup="verificar('descripcion_producto','descripcion_producto')"
                     >
                        <div v-if="errors.has('descripcion_producto')">
                           <span class="help-block text-danger" v-text="errors.first('descripcion_producto')"></span>
                        </div>
                        <div v-if="errorProducto.descripcion_producto != null">
                           <div v-for="error in errorProducto.descripcion_producto">
                              <span class="help-block text-danger" v-text="error"></span>
                           </div>
                        </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-6 col-lg-6  col-xl-6">
                     <label>Imagen</label>
                     <input 
                        type="text" 
                        name="imagen" 
                        ref="imagen" 
                        class="form-control" 
                        v-model="imagen" 
                        placeholder="Ingresar Descripcion" 
                        v-validate="{ required: true}" 
                        :class="vimagen?{ 'is-invalid': errors.has('imagen'), 'is-valid': !errors.has('imagen')}:null" required @keyup="verificar('imagen','imagen')"
                     >
                        <div v-if="errors.has('imagen')">
                           <span class="help-block text-danger" v-text="errors.first('imagen')"></span>
                        </div>
                        <div v-if="errorProducto.imagen != null">
                           <div v-for="error in errorProducto.imagen">
                              <span class="help-block text-danger" v-text="error"></span>
                           </div>
                        </div>
                  </div>
               </div>

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" 
                  @click="cerrarModal"> Cerrar
               </button>
               
               <button type="button" class="btn btn-sm btn-success"
                  @click="guardarProducto"
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
      name: "productos",
      created(){
         this.traerProductos(1,this.buscar);
         this.traerCategorias();
         
      },
      mounted(){
      },
      data(){
         return{
            buscar:'',
            titulo:'',
            arrayProductos:[],
            arrayCategorias:[],
            mostrarModal:false,
            nombre_producto:'',
            precio:'',
            descuento:'',
            imagen:'',
            descripcion_producto:'',
            vdescripcion_producto:false,
            vnombre_producto:false,
            vid_categoria:false,
            vprecio:false,
            vdescuento:false,
            vimagen:false,
            pagination: {
               'total' : 0,
               'current_page' : 0,
               'per_page' : 0,
               'last_page' : 0,
               'from' : 0,
               'to' : 0
            },
            offset: 3,
            errorProducto:{},
            id_categoria:''
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
         traerProductos(page,buscar){
            let _this = this;
            var url = '/productos/traer/?page=' + page + '&buscar=' + buscar ;
            axios.get(url).then(function (response) {
               var respuesta = response.data;
               _this.arrayProductos = respuesta.productos.data;
               _this.pagination = respuesta.pagination;
            }).catch(function (error) {
               alert("A ocurrido un error.");
            });
         },
         traerCategorias(){
            let _this = this;

            var url = '/categorias/traerCategoria';
            axios.get(url).then(function (response) {
               var respuesta = response.data;
               console.log(respuesta)

               _this.arrayCategorias = respuesta;
            }).catch(function (error) {
               alert("A ocurrido un error.");
            });
         },

         cambiarPagina(page,buscar){
            let me = this;
            //Actualiza la pagina actual
            me.pagination.current_page = page;
            //Enviar la peticion para visualizar la data de esa página
            me.traerProductos(page,buscar);
         },

         verificar(name,sig,t=0){
            console.log(sig)
            var _this = this;
            this.$validator.validate(name).then(function(valid){
               if (valid){
                  _this['v'+sig]=true
                  _this['v'+name]=true
                  _this.$validator.validate(sig);
               }
            })
         },
         abrirModal(accion,item){
            var _this = this
            this.mostrarModal=true;
            if (accion=='REGISTRAR') {
               this.titulo='Crear Producto'
               this.idProducto = "";
               this.id_categoria = "";
               this.nombre_producto = "";
               this.descripcion_producto = "";

               setTimeout(function(){
                  _this.vid_categoria=true;
                  _this.$validator.validate('id_categoria')
                  _this.$refs.id_categoria.focus();
               },500)

            }else{
               console.log
               this.titulo='Actulizar Producto'
               this.idProducto = item.id;
               this.nombre_producto = item.nombre_producto;
               this.descripcion_producto = item.descripcion_producto;
               _this.vnombre_producto=true;
               _this.vdescripcion_producto=true;
               _this.$validator.validate()
            }
            
         },
         cerrarModal(){
            this.idProducto = "";
            this.nombre_producto = "";
            this.descripcion_producto = "";
            this.mostrarModal=false;
            this.titulo = "";

            this.vdescripcion_producto=false
            this.vnombre_producto=false
            this.vid_categoria=false
            this.vprecio=false
            this.vdescuento=false
            this.vimagen=false

         },
         eliminarProducto(id){
            var _this = this;
            if(confirm("Seguro que se puede eliminar el Producto?")){

               axios.delete(`/productos/${id}`)
                  .then(function (response) {
                        
                     if(!response.data.success){
                        alert(response.data.error);
                     }else{
                        alert(response.data.data)
                        _this.traerProductos(1,'');
                     }

                  }).catch(function (error) {
                     alert("A ocurrido un error.");
                  });
            }
         },
         guardarProducto(){
            var _this = this;

            this.$validator.validate().then(function(valid){
               _this.vdescripcion_producto=true
               _this.vnombre_producto=true
               _this.vid_categoria=true
               _this.vprecio=true
               _this.vdescuento=true
               _this.vimagen=true

               _this.registrandoProducto=true;
               _this.disabledRegistrando=true;

               if (valid){
                  let data = {
                     'nombre_producto':_this.nombre_producto,
                     'precio':_this.precio,
                     'descuento':_this.descuento,
                     'imagen':_this.imagen,
                     'descripcion_producto':_this.descripcion_producto,
                     'categoria_id':_this.id_categoria
                  }

                  var url = '/productos';
                  var method = 'POST';//metodo para registrar 

                  if(_this.idProducto){
                     url = `/productos/${_this.idProducto}`;
                     method = 'PUT'; //metodo para actualiar 
                  }

                  axios({
                     method,
                     url,
                     data
                     }).then(function (response) {
                     
                     if(!response.data.success){
                        alert(response.data.error);
                     }else{
                        _this.cerrarModal();
                        _this.traerProductos(1,'');
                        alert(response.data.data)
                     }

                  }).catch(function (error) {
                     _this.registrandoProducto = false;
                     _this.disabledRegistrando = true;
                     _this.errorProducto = error;
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

