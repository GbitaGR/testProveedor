<template>
    <div class="card">
        <div class="card-header">
            <h1>Listado de Proveedores</h1>
        </div>
        <div class="card-body">
            <div class="col-md-12 p-0">
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
                                <td  v-if="proveedor[3] == 1">Sin registro</td>
                                <td  v-else-if="proveedor[3] == 2" >Registrado</td>
                                <td  v-else >Rechazado</td>
                                <td>
                                    <button v-if="proveedor" type="button" class="btn btn-outline-dark p-1" data-toggle="tooltip" data-placement="top" title="Registrar" @click="addProveedor(proveedor)"><i class="fas fa-edit fa-lg pt-1" ></i></button>
                                    <button v-if="proveedor" type="button" class="btn btn-outline-danger p-1" data-toggle="tooltip" data-placement="top" title="Eliminar" @click="deleteProveedor(vehiculo.id)"><i class="fas fa-trash-alt fa-lg pt-1" ></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import swal from 'sweetalert2';
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
            }
        }
    }
</script>
