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
                     <button type="button" style="background-color: #5DADE2;" class="btn btn-sm text-white" @click="abrirModal('Nuevo Producto')"><img src="/img/mas.png" width="14px" alt=""> Registrar Producto
                     </button>
                     </div>
                  </div>
            {{arrayProductos}}
               </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nombre Producto</th>
                      <th>Categoria</th>
                      <th>Precio</th>
                      <th>Descuento</th>
                      <th>Descripcion</th>
                      <th style="width: 40px">Label</th>
                    </tr>
                  </thead>
                  <tbody>

                     
                    <tr v-for="(producto, index) in arrayProductos">
                      <td v-text="index+1"></td>
                      <td v-text="producto.nombre_producto"></td>
                      <td v-text="producto.categoria.nombre_categoria"></td>
                      <td v-text="producto.precio"></td>
                      <td v-text="producto.descuento"></td>
                      <td v-text="producto.Descripcion"></td>
                      <td>
                        <div class="progress progress-xs">
                          <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
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
  </div>
</template>

<script>
   export default {
      name: "productos",
      created(){
         this.traerProductos(1,this.buscar);
         
      },
      mounted(){
      },
      data(){
         return{
            buscar:'',
            arrayProductos:[],


            id_usuario:'',
            firmar:false,
            mostrarFirmas:false,
            firmas:{},
            sigStyle: { 
               'border': '4px solid #444',
               'border-radius': '15px',
               'background-color': '#fafafa'
            },
            arrayUsuarios:[],
            pagination: {
               'total' : 0,
               'current_page' : 0,
               'per_page' : 0,
               'last_page' : 0,
               'from' : 0,
               'to' : 0
            },
            offset: 3,
            nombreSede: '',
            vNombreSede:false,
            direccion: '',
            
            vDireccion:false,
            telefono: '',
            vTelefono:false,
            mostrarUsuario:false,
            titulo:'',
            id_sede:'',
            tipo_documento:'',
            dni:'',
            buscandoUsuario:false,
            value:'',
            disabledBuscar:true,
            registrandoUsuario:false,
            buscandoUsuario:false,
            mostrarDni:false,
            mostrarCampos:false,
            sedes:'',
            usuarios:{
               type:'',
               dni:'',
               nombre:'',
               apellidos:'',
               telefono_movil:'',
               sedes:'',
               email:'',
               usuario:'',
               password:'',
               confir_password:'',
               genero:'',
               tipo:'',
               especialidad:'',
               colegiatura: '',
               
            },
            vespecialidad:false,
            vcolegiatura:false,
            vnombre:false,
            vapellidos:false,
            vtelefono_movil:false,
            vemail:false,
            vsedes:false,
            vtipo:false,
            vusuario:false,
            vpassword:false,
            vconfir_password:false,
            vgenero:false,

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
            this.mostrarUsuario=true

            if (titulo=='Nuevo Usuario') {
               this.id_sede = "";
               this.nombreSede = "";
               this.direccion = "";
               this.telefono = "";

               setTimeout(function(){
                  console.log(_this.$refs)
                  _this.$refs.tipo_documento.focus();
               },500)

            }else{
               this.nombreSede = item.nombre_sede;
               this.direccion = item.direccion_sede;
               this.telefono = item.telefono_sede;
               this.id_sede = item.id;
            }
            
         },
         cerrarModal(){
            this.titulo = "";
            this.nombreSede = "";
            this.direccion = "";
            this.telefono = "";
            this.id_sede = "";
            this.mostrarUsuario=false
            this.usuarios = {
               type:'',
               dni:'',
               nombre:'',
               apellidos:'',
               telefono_movil:'',
               sedes:'',
               email:'',
               usuario:'',
               password:'',
               confir_password:'',
               genero:'',
               tipo:'',
               especialidad:'',
               colegiatura: '',
               
            }
            this.vespecialidad=false
            this.vcolegiatura=false
            this.vnombre=false
            this.vapellidos=false
            this.vtelefono_movil=false
            this.vemail=false
            this.vsedes=false
            this.vtipo=false
            this.vusuario=false
            this.vpassword=false
            this.vconfir_password=false
            this.vgenero=false
            this.mostrarDni =false
            this.mostrarCampos =false

         },
         guardarUsuario(){
            var _this = this;

            this.$validator.validate().then(function(valid){
               _this.vespecialidad=true;
               _this.vcolegiatura=true;
               _this.vnombre=true;
               _this.vapellidos=true;
               _this.vtelefono_movil=true;
               _this.vemail=true;
               _this.vsedes=true;
               _this.vtipo=true;
               _this.vusuario=true;
               _this.vpassword=true;
               _this.vconfir_password=true;
               if (valid){
                  var formData = new FormData();
                  console.log(_this.$refs.foto.files)
                  if (_this.$refs.foto.files) {
                     formData.append('foto', _this.$refs.foto.files[0]);
                  }else{
                     formData.append('foto', _this.$refs.foto.files);
                  }
                  formData.append('datos', JSON.stringify(_this.usuarios))
                  formData.append('id_usuario', _this.id_usuario)
                  alert(_this.id_usuario)
                  if (_this.id_usuario) {
                     var url = '/ajax/usuarios/editar_usuarios';
                  }else{
                     var url = '/ajax/usuarios/crear_usuarios';
                  }
                  axios.post(
                     url,
                     formData,
                     {
                        headers: {
                           'Content-Type': 'multipart/form-data'
                           }
                        }
                     ).then(function (response) {
                     console.log(response.data)
                     if(!response.data.success){
                        alert(response.data.error);
                     }else{
                        _this.cerrarModal();
                        _this.traerUsuarios(1,'');
                        _this.usuarios={
                              type:'',
                              dni:'',
                              nombre:'',
                              apellidos:'',
                              telefono_movil:'',
                              sedes:'',
                              email:'',
                              usuario:'',
                              password:'',
                              confir_password:'',
                              genero:'',
                              tipo:'',
                              especialidad:'',
                              colegiatura: '',
                              
                           }
                           _this.vespecialidad=false;
                           _this.vcolegiatura=false;
                           _this.vnombre=false;
                           _this.vapellidos=false;
                           _this.vtelefono_movil=false;
                           _this.vemail=false;
                           _this.vsedes=false;
                           _this.vtipo=false;
                           _this.vusuario=false;
                           _this.vpassword=false;
                           _this.vconfir_password=false;
                           _this.vgenero=false;
                           _this.mostrarDni =false
                           _this.mostrarCampos =false

                        alert("Usuario creado")
                     }

                  }).catch(function (error) {
                     _this.registrandoPaciente = false;
                     _this.disabledRegistrando = true;
                     alert("Ah ocurrido un error.");
                  });
               }
            })

           
         },
         buscarUsuario:function(){
            var _this = this

            this.usuarios.nombre = "";
            this.usuarios.apellidos = "";
            this.usuarios.telefono_movil = "";
            this.usuarios.direccion = "";

            this.buscandoUsuarios = true;
            this.disabledBuscar = true;
            var url = `/usuarios/ver/dni/${this.usuarios.dni}`;
            var urlConsulta = `/SunatPHP/consulta.php`;
            axios.get(url).then(function (response) {
               var data = response.data;
               if(data.dni){
                  alert('Este DNI ya se encuentra registrado!');
                  _this.buscandoUsuario = false;
                  _this.disabledBuscar = false;
                  return;
               }
               if (_this.usuarios.dni.length==11) {
                  $.ajax({
                     type:"POST",
                     url:'/SunatPHP/consulta.php',
                     dataType:"json",
                     data:{nruc:_this.usuarios.dni.trim()},
                     success:function(respuesta){
                        _this.mostrarCampos = true;
                        if(respuesta.success==true){
                           
                           var arrNombre = respuesta.result.RazonSocial.split(" ");
                           var nombres = ""; var apellidos = "";

                           for (var i = 0; i < arrNombre.length; i++) {
                              if(i<=1){
                                 apellidos += ' '+arrNombre[i];
                              }else{
                                 nombres += ' '+arrNombre[i];
                              }
                           }

                           for (var item in respuesta){
                              var rasonsocial=respuesta[item].RazonSocial;
                              var telefonos=respuesta[item].Telefono;
                              var adress=respuesta[item].Direccion;
                              var state=respuesta[item].Estado;
                           }

                           _this.usuarios.nombre = nombres;
                           _this.usuarios.apellidos = apellidos;
                           _this.usuarios.usuario = telefonos;
                           
                           _this.buscandoUsuario = false;
                           _this.disabledBuscar = false;

                           _this.vnombre=true
                           _this.vapellidos=true
                           _this.vtelefono_movil=true
                           _this.vusuario=true

                           _this.$validator.validate("nombre");
                           _this.$validator.validate("apellidos");
                           _this.$validator.validate("telefono_movil");
                           _this.$validator.validate("usuario");
                           _this.$refs.usuario.focus();
                           return;
                        }
                        
                        _this.buscandoUsuario = false;
                        _this.disabledBuscar = false;
                        _this.vnombre=true;
                        _this.$validator.validate("nombre");
                        _this.$refs.nombre.focus();

                     }
                  })
               }
               if (_this.usuarios.dni.length==8) {
                  $.ajax({
                     type:"POST",
                     url:'/ReniecPHP/example/consulta.php',
                     dataType:"json",
                     data:{ndni:_this.usuarios.dni.trim()},
                     success:function(respuesta){
                        _this.mostrarCampos = true;
                        if(respuesta.success==true){

                           console.log(respuesta)
                           if(respuesta.source=='reniec'){
                              var nombres = respuesta.result.Nombres;
                              var apellidos = respuesta.result.apellidos;
                           }
                           if(respuesta.source=='essalud'){
                              var nombres = respuesta.result.Nombres;
                              var apellidos = respuesta.result.ApellidoPaterno +" "+ respuesta.result.ApellidoMaterno;
                           }
                           if (nombres.trim()!='' || apellidos.trim()!=''){
                              _this.usuarios.nombre = nombres;
                              _this.usuarios.apellidos = apellidos;
                              _this.buscandoUsuario = false;
                              _this.disabledBuscar = false;

                              _this.vnombre=true
                              _this.vapellidos=true
                              _this.vfecha_nacimiento=true

                              setTimeout(function(){
                                 _this.$validator.validate("nombre");
                                 _this.$validator.validate("apellidos");
                                 _this.$validator.validate("telefono_movil");
                                 _this.$refs.telefono_movil.focus();
                              },100)
                              return;   
                           }else{
                              _this.buscandoUsuario = false;
                              _this.disabledBuscar = false;
                              _this.vnombre=true;
                              setTimeout(function(){
                                 _this.$validator.validate("nombre");
                                 _this.$refs.nombre.focus();
                              },100)
                           }                     
                        }
                     }
                  })
               }
            }).catch(function (error) {
               _this.buscandoUsuario = false;
               _this.disabledBuscar = false;
               alert("Ah ocurrido un error.");
            });
         },
         verificarDni(){
            var _this= this
            this.$validator.validate('dni').then(function(valid){
               if (valid) {
                  _this.disabledBuscar=false;
                  if (_this.usuarios.type!='dni') {
                     _this.mostrarCampos=true;
                     setTimeout(function(){
                        _this.vnombre=true
                        _this.$refs.nombre.focus();
                        _this.$validator.validate("nombre");
                     },100);
                     
                  }else{
                     _this.buscarUsuario()
                  }
               }else{
                  _this.disabledBuscar=true;
               }
            })
         },
         mostrarCampoDni(){
            var _this= this
            if (this.usuarios.type==''){
               this.mostrarDni=false;
            }else{
               this.mostrarDni=true;
            }
            setTimeout(function(){
               _this.verificarDni();
               _this.$refs.dni.focus();
            },100);
         },
         limpiarFirma() {
            this.$refs.signaturePad.clearSignature()
            console.log(this.$refs.signaturePad)
            //this.$refs.signaturePad.clear();
         },
         firmarMostrar(id,titulo){
            this.mostrarFirmas=true         },
         cerrarFirma(){
            this.mostrarFirmas=false;
            this.$refs.signaturePad.clearSignature();
         },
         guardarFirma() { 
            // console.log(this.$refs.signaturePad);
            var _this = this
            const { isEmpty, data } = this.$refs.signaturePad.saveSignature();
            console.log(isEmpty);
            console.log(data);

            if (!isEmpty) {
               var firmas = this.firmas
                  firmas[this.id_consentimiento] = {
                  firma: data
               }
               const base64 = data
               fetch(base64)
               .then(res => res.blob())
               .then(blob => {
                  const formData = new FormData();
                  const file = new File([blob], "firma_"+this.id_consentimiento+"_"+this.id_paciente+".jpeg");
                  formData.append('firma', file);
                  var url = "/usuario/subir/imagen-firma/";

                  axios.post(
                     url,
                     formData,
                     {
                        headers: {
                           'Content-Type': 'multipart/form-data'
                           }
                        }
                     ).then(function (response){
                     console.log("response")
                     console.log(response)
                     console.log("response")
                     if(response.data.success){
                        _this.cerrarFirma();
                     }else{
                        alert(response.data.error)
                     }
                  }).catch(function (error) {
                     console.log(error);
                     alert("Ah ocurrido un error.");
                  });
               })

            }else{
               alert("La firma no puede estar vacia")
            }
         },
         verImg(item){
            if (item.logo) {
               return "/imagenes/imagenesUsuarios/"+item.logo
            }

            if (item.genero=='masculino') {
               return "/img/medico1.png"
            }else{
               return "/img/medico2.png"
            }
         },
         cambiarEstado(estado,item,index){
            var url = "/usuario/cambiarEstado";
            var _this = this
            var data = {
               id: item.id,
               estado:estado,
            }
            axios.post(url,data).then(function (response){
               console.log(response);
               if (response.data.success) {
                  var users = _this.arrayUsuarios;
                  console.log(users);
                  users[index].active = estado
                  console.log(users);
                  _this.arrayUsuarios = users
               }

            }).catch(function (error) {
               console.log(error);
               alert("Ah ocurrido un error.");
            });
         },
         EditarUsuario(item){
            console.log(item)
            this.mostrarUsuario=true
            this.id_usuario=item.id
            this.usuarios = {
               dni:item.dni,
               nombre:item.name,
               telefono_movil:item.telefono,
               sedes:item.sede_id,
               email:item.email,
               usuario:item.username,
               genero:item.genero,
               colegiatura:item.colegiatura,
               especialidad:item.especialidad,
               tipo:item.cop
            }
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
   .mostrar_usuarios{
      display: list-item !important;
      opacity: 1 !important;
      /*position: absolute !important;*/
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
   .mostrar_firma{
      display: list-item !important;
      opacity: 1 !important;
      /*position: absolute !important;*/
      background-color: #3c29297a !important;
      overflow-x: hidden;
      overflow-y: auto;
      z-index: 1072;
   }
</style>

