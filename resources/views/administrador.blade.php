


@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Listado de Proveedores</h2>
                </div>

                <div class="card-body">
                    <div id="app" class="content">
                        <admin-component></admin-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
