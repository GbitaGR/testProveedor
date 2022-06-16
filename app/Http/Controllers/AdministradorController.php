<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function cargarListado(){
        $proveedores = array();
        $contador = 1;
        if (($open = fopen(storage_path() . "/proveedores.csv", "r")) !== FALSE) {

            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                if($data[0]!='nombre' && $data[1]!='rfc' && $data[2]!='email'){
                    array_push($data, $contador);
                    array_push($proveedores, $data);
                    $contador +=1;
                }
                // $proveedores = $data;
            }

            fclose($open);
        }
        // dd($proveedores);
        // $json_prov = json_encode($proveedores);
        // $json_prov = json_encode($proveedores, JSON_PRETTY_PRINT);
        // dd( $json_prov); 
        return response()->json(['proveedores'=>$proveedores],200);
    }
}
