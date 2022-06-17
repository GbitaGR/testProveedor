<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;
use App\Models\Proveedor;
use App\User;
use Spatie\Permission\Models\Role;

class AdministradorController extends Controller
{
    public function index(){
        return view('administrador');
    }

    public function cargarListado(){
        $proveedores = array();
        $contador = 1;
        if (($open = fopen(storage_path() . "/proveedores.csv", "r")) !== FALSE) {

            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                if($data[0]!='nombre' && $data[1]!='rfc' && $data[2]!='email'){
                    $proveedor = Proveedor::where('rfc',$data[1])->first();
                    // dd($data[1],$proveedor);
                    $ac_estatus =  ($proveedor) ? $proveedor->estatus:1;
                    $data[3]=$ac_estatus;
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

    public function store(Request $request){
        // dd($request->all());
        try {
            DB::beginTransaction();
            $data = $request->all();

            //Creando proveedor
            $proveedor = new Proveedor();
            $proveedor->nombre  =   $data['nombre'];
            $proveedor->rfc     =   $data['rfc'];
            $proveedor->email   =   $data['email'];
            $proveedor->estatus =   2; //Registrado
            $proveedor->save();

            //Creando usuario para proveedor
            $user   = new User();
            $user->id_proveedor =   $proveedor->id;
            $user->name         =   $proveedor->nombre;
            $user->email        =   $proveedor->email;
            $user->password     =    bcrypt((strtolower(str_replace(' ','',$proveedor->nombre))));
            $user->save();

            //Agregar rol Proveedor al usuario
            $rol = Role::find(2);
            $user->roles()->attach($rol);
            
            DB::commit();
            return response()->json(['message'=>'El proveedor se registro correctamente'],200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::error($th);
            return response()->json([
                'message'=>$th->getMessage()
              ],400);
        }
    }

    public function delete(Request $request){
        try {
            DB::beginTransaction();
            $data = $request->all();

            //Creando proveedor
            $proveedor = new Proveedor();
            $proveedor->nombre  =   $data['nombre'];
            $proveedor->rfc     =   $data['rfc'];
            $proveedor->email   =   $data['email'];
            $proveedor->estatus =   3; //Registrado
            $proveedor->save();

            
            DB::commit();
            return response()->json(['message'=>'El proveedor se ha rechazado'],200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::error($th);
            return response()->json([
                'message'=>$th->getMessage()
              ],400);
        }
    }
}
