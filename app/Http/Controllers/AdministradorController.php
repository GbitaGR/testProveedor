<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Log;
use App\Models\Proveedor;
use App\User;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class AdministradorController extends Controller
{
    public function index(){
        return view('administrador');
    }

    public function cargarListado(Request $request){
        // dd($request->all());
        $file = $request->file;
        // dd($file->getPathName());
        $proveedores = array();
        $proveedorData = array();
        // $contador = 1;
        $totalNuevos = 0;

        if (($open = fopen($file->getPathName()/*storage_path() . "/proveedores1.csv"*/, "r")) !== FALSE) {
            // dd("si lo abre");
            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                // dd($data);
                if($data[0]!='nombre' && $data[1]!='rfc' && $data[2]!='email'){
                    $proveedor = Proveedor::where('rfc',$data[1])->first();
                    if(!$proveedor){
                        
                          //Creando proveedor
                        $provNew = new Proveedor();
                        $provNew->nombre  =   $data['0'];
                        $provNew->rfc     =   $data['1'];
                        $provNew->email   =   $data['2'];
                        $provNew->estatus =   1; //Sin validar
                        $provNew->save();

                        // $proveedorData = array(
                        //     'consecutivo' =>   $contador,
                        //     'nombre'      =>   $provNew->nombre,
                        //     'rfc'         =>   $provNew->rfc,
                        //     'email'       =>   $provNew->email,
                        //     'estatus'     =>   $provNew->estatus,
                        //     'id'          =>   $provNew->id,
                        //     'registro'    =>   1       
                        // );

                        $totalNuevos +=1;
                    }
                    // else{

                    //     $proveedorData = array(
                    //         'consecutivo' =>   $contador,
                    //         'nombre'      =>   $proveedor->nombre,
                    //         'rfc'         =>   $proveedor->rfc,
                    //         'email'       =>   $proveedor->email,
                    //         'estatus'     =>   $proveedor->estatus,
                    //         'id'          =>   $proveedor->id,
                    //         'registro'    =>   2  
                    //     );

                    // }

                    // dd($data[1],$proveedor);
                    // $ac_estatus =  ($proveedor) ? $proveedor->estatus:1;
                    // $data[3]=$ac_estatus;
                    // array_push($data, $contador);
                    // array_push($proveedores, $proveedorData);
                    // $contador +=1;
                }
                // $proveedores = $data;
            }

            fclose($open);
            return response()->json(['message' => 'Cargado','totalNuevos'=>$totalNuevos],200);
        } else{
            return response()->json(['message' => 'Hubo un error al cargar el archivo'],400);
        // return response()->json(['proveedores'=>$proveedores,'totalNuevos'=>$totalNuevos],200);
        }
    }

    public function getListado(){
        $proveedores = Proveedor::all();
        $proveedorJson = array();
        $proveedorData = array();
        $contador = 0;
        $today =  Carbon::now();
        $totalNuevos = 0;
        foreach ($proveedores as $data) {
            $contador +=1;
            $proveedorData = array(
                'consecutivo' =>   $contador,
                'nombre'      =>   $data->nombre,
                'rfc'         =>   $data->rfc,
                'email'       =>   $data->email,
                'estatus'     =>   $data->estatus,
                'id'          =>   $data->id,
                'registro'    =>   ($data->created_at == $today) ? 1 : 2      
            );
            array_push($proveedorJson, $proveedorData);
            
        }

        return response()->json(['proveedores'=>$proveedorJson,'totalNuevos'=>$totalNuevos],200);
    }

    public function store(Request $request){
        // dd($request->all());
        try {
            DB::beginTransaction();

            // //Creando proveedor
            $proveedor = Proveedor::findOrFail( $request->idProv);
            // $proveedor->nombre  =   $data['nombre'];
            // $proveedor->rfc     =   $data['rfc'];
            // $proveedor->email   =   $data['email'];
            // $proveedor->estatus =   2; //Registrado
            // $proveedor->save();

            //Creando usuario para proveedor
            if($proveedor){
                $pass = 'prueba';
                $user   = new User();
                $user->id_proveedor =   $proveedor->id;
                $user->name         =   $proveedor->nombre;
                $user->email        =   $proveedor->email;
                $user->password     =    bcrypt($pass);
                

                if($user->save()){
                    $proveedor->estatus = 2;
                    $proveedor->save();
                }
    
                //Agregar rol Proveedor al usuario
                $rol = Role::find(2);
                $user->roles()->attach($rol);
            }
            
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
        // dd($request->all());
        try {
            DB::beginTransaction();
            // $data = $request->all();

            //Creando proveedor
            $proveedor = Proveedor::findOrFail($request->idProv);
            if($proveedor){
                $proveedor->estatus = 3; //Rechazado
                $proveedor->save();
            }
            // $proveedor->nombre  =   $data['nombre'];
            // $proveedor->rfc     =   $data['rfc'];
            // $proveedor->email   =   $data['email'];
            // $proveedor->estatus =   3; //Registrado
            // $proveedor->save();

            
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
