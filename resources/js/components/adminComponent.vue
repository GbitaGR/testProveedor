<template>
<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <!-- <form id="form"> -->
                <label for="formFile" class="form-label">Archivo csv</label>
                <input type="file" id="file" ref="myFiles" class="form-control"
                @change="previewFiles" accept=".csv">
                <!-- <button type="submit">Submit</button> -->
            <!-- </form> -->
        </div>
    </div>
    <div class="col-md-12">



        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre proveedor</th>
                        <th scope="col">RFC</th>
                        <th scope="col">Email</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="!arrayListado.length">
                        <td colspan="6">No hay proveedores que mostrar</td>
                    </tr>
                    <tr v-for="proveedor in arrayListado" :key="proveedor.id">
                        <td v-text="proveedor.consecutivo"></td>
                        <td  v-text="proveedor.nombre"></td>
                        <td  v-text="proveedor.rfc"></td>
                        <td  v-text="proveedor.email"></td>
                        <td  v-if="proveedor.estatus == 1"><span>Sin registro</span></td>
                        <td  v-else-if="proveedor.estatus == 2" ><span class="alert alert-success">Registrado</span></td>
                        <td  v-else ><span class="alert alert-danger">Rechazado</span></td>
                        <td>
                            <button :disabled="proveedor.estatus != 1" type="button" class="btn btn-outline-dark p-1" data-toggle="tooltip" data-placement="top" title="Registrar" @click="addProveedor(proveedor.id)"><i class="fas fa-edit fa-lg pt-1" ></i></button>
                            <button :disabled="proveedor.estatus != 1" type="button" class="btn btn-outline-danger p-1" data-toggle="tooltip" data-placement="top" title="Eliminar" @click="deleteProveedor(proveedor.id)"><i class="fas fa-trash-alt fa-lg pt-1" ></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
    
</template>

<script>
    import Swal from 'sweetalert2';
    import 'animate.css';
    import VueToastr from "vue-toastr";
    export default {
        data(){
            return {     
                arrayListado : [],
                contador:0,
                files: '',
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.getListado()
            
            // Swal.fire({
            // title: 'Error!',
            // text: 'Do you want to continue',
            // icon: 'error',
            // confirmButtonText: 'Cool'
            // })
            },
        methods:{
            getListado(){
                let me =this;
                let url ='getListado';
                axios.get(url).then(function (response) {
                    me.arrayListado = response.data.proveedores;
                    console.log(response);
                    console.log(me.arrayListado);
                }).catch(function (error) {
                });
            },
            addProveedor(id){
                console.log("para guardar",id);
                let me=this
                let url = 'store-proveedor'
                // let data = {
                //     nombre : value[0],
                //     rfc    : value[1],
                //     email  : value[2],
                //     estatus : value[3]
                // }
                Swal.fire({
                    icon: 'warning',
                    title: 'Se dará acceso a este proveedor. Continuar?',
                    showDenyButton: true,
                    // showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    denyButtonText: 'Cancelar',
                    }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        axios.post(url,{idProv:id}).then(response=>{
                            me.getListado()
                            
                            me.$toastr.Add({
                                    name: "aceptProv",
                                    title: "Proveedor aceptado",
                                    msg: "El proveedor fué aceptado",
                                    position: "toast-top-right",
                                    type: "success",
                                    timeout: 5000,
                                    progressbar: true,
                            });
                            Swal.fire({
                                type:'success',
                                title: 'Guardado',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                }
                            })
                         }).catch(error =>{
                             console.log(error);
                            Swal.fire({
                                title: 'Un error ha ocurrido',
                                text: 'No se pudo guardar el registro',
                                type: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                            me.getListado()
                        });

                        
                    } else if (result.isDenied) {
                          Swal.fire({
                                type:'info',
                                title: 'Cancelado',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                }
                            })
                    }
                    })

            },
            deleteProveedor(id){
                console.log("Que hace?",id);
                let me=this
                let url = 'delete-proveedor'   
                // let data = {
                //     nombre : value[0],
                //     rfc    : value[1],
                //     email  : value[2],
                //     estatus : value[3]
                // }
                 Swal.fire({
                    icon: 'warning',
                    title: 'Se rechazará el acceso al proveedor. Continuar?',
                    showDenyButton: true,
                    // showCancelButton: true,
                    confirmButtonText: 'Continuar',
                    denyButtonText: 'Cancelar',
                    }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        axios.post(url,{idProv:id}).then(response=>{
                            me.getListado()
                            this.$toastr.Add({
                                    name: "aceptProv",
                                    title: "Proveedor rechazado",
                                    msg: "El proveedor fué rechazado",
                                    position: "toast-top-right",
                                    type: "info",
                                    timeout: 5000,
                                    style:{size:'2rem'},
                                    progressbar: true,
                            });
                            Swal.fire({
                                type:'success',
                                title: 'Rechazado',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                }
                            })
                         }).catch(error =>{
                             console.log(error);
                            Swal.fire({
                                title: 'Un error ha ocurrido',
                                text: 'No se pudo guardar el registro',
                                type: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                            me.getListado()
                        });

                        
                    } else if (result.isDenied) {
                          Swal.fire({
                                type:'info',
                                title: 'Cancelado',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                }
                            })
                    }
                    })
            },
            previewFiles() {
                let me = this
                me.files = this.$refs.myFiles.files[0]
                let formData = new FormData();
                let url ='cargarFile';
                formData.append('file', me.files);
                console.log("serializar form",formData);

                 Swal.fire({
                    icon: 'warning',
                    title: 'Los datos se guardaran automaticamente. Continuar?',
                    showDenyButton: true,
                    // showCancelButton: true,
                    confirmButtonText: 'Continuar',
                    denyButtonText: 'Cancelar',
                    }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                          axios.post(url,
                            formData, {
                                headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                        ).then(function (response) {
                            console.log(response);
                            if(response.data.totalNuevos > 0){
                                me.$toastr.Add({
                                       name: "aceptProv",
                                       title: "Nuevo registro",
                                       msg: "Se registraron "+response.data.totalNuevos+" proveedores",
                                       position: "toast-top-right",
                                       type: "info",
                                       timeout: 5000,
                                       style:{size:'2rem'},
                                       progressbar: true,
                               });
                            }
                            me.files = ''
                            me.getListado()
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.isDenied) {
                        me.files = ''
                          Swal.fire({
                                type:'info',
                                title: 'Cancelado',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                }
                            })
                    }
                    })

              
                // this.files = this.$refs.myFiles.files
                // console.log(this.files);
                // this.getListado(this.files[0])
            }
        }
    }
</script>
