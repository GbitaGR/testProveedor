<template>
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
                                <td colspan="5">No hay proveedores que mostrar</td>
                            </tr>
                            <tr v-for="proveedor in arrayListado" :key="proveedor[1]">
                                <td v-text="proveedor[4]"></td>
                                <td  v-text="proveedor[0]"></td>
                                <td  v-text="proveedor[1]"></td>
                                <td  v-text="proveedor[2]"></td>
                                <td  v-if="proveedor[3] == 1"><span>Sin registro</span></td>
                                <td  v-else-if="proveedor[3] == 2" ><span class="alert alert-success">Registrado</span></td>
                                <td  v-else ><span class="alert alert-danger">Rechazado</span></td>
                                <td>
                                    <button :disabled="proveedor[3] != 1" type="button" class="btn btn-outline-dark p-1" data-toggle="tooltip" data-placement="top" title="Registrar" @click="addProveedor(proveedor)"><i class="fas fa-edit fa-lg pt-1" ></i></button>
                                    <button :disabled="proveedor[3] != 1" type="button" class="btn btn-outline-danger p-1" data-toggle="tooltip" data-placement="top" title="Eliminar" @click="deleteProveedor(proveedor)"><i class="fas fa-trash-alt fa-lg pt-1" ></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
</template>

<script>
    import Swal from 'sweetalert2';
    import 'animate.css';
    export default {
        data(){
            return {     
                arrayListado : [],
                contador:0,
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
                console.log(url);
                axios.get(url).then(function (response) {
                    me.arrayListado = response.data.proveedores;
                    console.log(response);
                    console.log(me.arrayListado);
                }).catch(function (error) {
                });
            },
            addProveedor(value){
                let me=this
                let url = 'store-proveedor'
                let data = {
                    nombre : value[0],
                    rfc    : value[1],
                    email  : value[2],
                    estatus : value[3]
                }
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
                        axios.post(url,data).then(response=>{
                            me.getListado()
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
            deleteProveedor(value){
                let me=this
                let url = 'delete-proveedor'   
                let data = {
                    nombre : value[0],
                    rfc    : value[1],
                    email  : value[2],
                    estatus : value[3]
                }
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
                        axios.post(url,data).then(response=>{
                            me.getListado()
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
            }
        }
    }
</script>
