<template>
<div class="p-2 bd-highlight">
    <h2 class="abs-center">¡Hola <span>{{name}}</span>!</h2> 
    <p> Te damos la bienvenida a la vista principal de tu portal. </p>

</div>
</template>
<script>
    import Swal from 'sweetalert2';
    export default {
        data(){
            return { 
                nameProv : this.name 
            }
        },
        props:{
            name:{default:''},
        },
        mounted() {
            if(this.nameProv!=''){
                Swal.fire(
                'Bienvenido!',
                this.nameProv,
                'success'
                )
                this.nameProv = ''
            }
                        // this.$toastr.s("SUCCESS MESSAGE", "Success Toast Title");
            // console.log("Deberia mostrar el nombre",this.name);
        }
    }
</script>