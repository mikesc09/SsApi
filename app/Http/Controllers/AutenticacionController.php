<?php

namespace App\Http\Controllers;

use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use \Config, Carbon\Carbon;
use App\Models\Sistema\Usuario;


class AutenticacionController extends Controller
{

    public function iniciarSesionLocal(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(!isset($credentials['email']) || $credentials['email'] == ''){

            return response()->json(['error' => 'Proporcione un Usuario valido'], 409);
        }

        $usuario = Usuario::where('email',$credentials['email'])->first();
        //dd($usuario);

        if(!$usuario) {                
            return response()->json(['error' => 'El usuario esta desactivado'], 401); 
        }


        // if(!$usuario) {    CHECAR POR QUE SI EL CORREO ESTA EL PASSWORD ESTA BIEN PERO EL CORREO MAL PASA.            
        //     return response()->json(['error' => 'invalid_credentials'], 401); 
        // }

        if(Hash::check($credentials['password'], $usuario->password)){     

            if(!$usuario->activo) {                
                return response()->json(['error' => 'El usuario esta desactivado'], 401); 
            }

            $usuario_data = [
                "id" => $usuario->id,
                "email" => $usuario->email,
                "nombre" => $usuario->nombre,
                "apellido_paterno" => $usuario->apellido_paterno,
                "apellido_materno" => $usuario->apellido_materno,
                "salud_id" => $usuario->salud_id,
                "activo" => $usuario->activo
            ];

        

            $claims = [
                "sub" => $usuario->id,
                "email" => $usuario->email,
                //"apellidos" => $usuario->apellidos,
                //"permisos" => $lista_permisos
            ];

            $factory = JWTFactory::customClaims($claims);

            $payload = $factory->make();
    
            //$payload = JWTFactory::make($claims);
            $token = JWTAuth::encode($payload);

            return response()->json(['token' => $token->get(), 'usuario'=>$usuario_data], 200);
        
        } else{
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
        //Encriptamos el refresh oauth para que no quede 100% expuesto en la aplicacion web
        //$refresh_token_encrypted = Crypt::encrypt($api_response->refresh_token);
        //return response()->json(['token' => 1345], 200);
    }

    public function iniciarSesionSaludID(Request $request){
        
        $credentials = $request->only('email', 'password');

        if (!isset($credentials['email']) || $credentials['email'] == '') {
            
            return response()->json(['error' => 'Proporcione un Usuario valido'], 409);

        } elseif (!isset($credentials['password']) || $credentials['password'] == '') {

            return response()->json(['error' => 'Proporcione una contrasenia valida'], 409);

        }

        $post_request = 'grant_type=password'
        .'&client_id='.env('CLIENT_ID')
        .'&client_secret='.env('CLIENT_SECRET')
        .'&username='.$credentials['email']
        .'&password='.$credentials['password'];

        $ch = curl_init();
        $header[]         = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);
        curl_setopt($ch, CURLOPT_URL, env('OAUTH_SERVER').'/oauth/access_token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_request);

        $api_response = json_decode(curl_exec($ch)); 
        $curlError = curl_error($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($curlError){ 
            throw new Exception("Hubo un problema al intentar hacer la autenticacion. cURL problem: $curlError");
        }

        if($http_code != 200){
        if(isset($api_response->error)){
                return response()->json(['error'=>$api_response->error],$http_code);	
            }else{
                return response()->json(['error'=>"Error"],$http_code);
            }
        }

       $usuario = Usuario::where('email',$credentials['email'])->first();

       if(!$usuario){
        return response()->json(['error' => 'Este usuario no esta autorizado para utilizar este sistema, Contacte con el Administrador del sistema'], 401);
       }

       if(!$usuario->activo){
        return response()->json(['error' => 'Este Usuario esta bloqueado, Contacte con el Administrador del sistema'], 403);
       }
       


       $post_request = 'access_token='.$api_response->access_token;
       

        $ch = curl_init();
        $header[]         = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);
        curl_setopt($ch, CURLOPT_URL, env('OAUTH_SERVER').'/oauth/vinculacion');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_request);
        


        $api_response = json_decode(curl_exec($ch));
        $curlError = curl_error($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        
        if($curlError){ 
             throw new Exception("Hubo un problema al intentar hacer la vinculación. cURL problem: $curlError");
        }
        
        if($http_code != 200){
            return Response::json(['error'=>$api_response->error],$http_code);
        }

        $usuario_data = [
            "id" => $usuario->id,
            "email" => $usuario->email,
            "nombre" => $usuario->nombre,
            "apellido_paterno" => $usuario->apellido_paterno,
            "apellido_materno" => $usuario->apellido_materno,
            "salud_id" => $usuario->salud_id,
            "activo" => $usuario->activo
        ];

        //dd($usuario_data);

    

        $claims = [
            "sub" => $usuario->id,
            "email" => $usuario->email,
            //"apellidos" => $usuario->apellidos,
            //"permisos" => $lista_permisos
        ];

        $factory = JWTFactory::customClaims($claims);

        $payload = $factory->make();

        //$payload = JWTFactory::make($claims);
        $token = JWTAuth::encode($payload);

        return response()->json(['token' => $token->get(), 'usuario'=>$usuario_data], 200);

    }

    public function autenticar(Request $request)
    {
        
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {

            if(!isset($credentials['email']) || $credentials['email'] == ''){

                return response()->json(['error' => 'Proporcione un Usuario valido'], 409);
            }
           
            $post_request = 'grant_type=password'
            .'&client_id='.env('CLIENT_ID')
            .'&client_secret='.env('CLIENT_SECRET')
            .'&username='.$credentials['email']
            .'&password='.$credentials['password'];       
   
            $ch = curl_init();
            $header[]         = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);
            curl_setopt($ch, CURLOPT_URL, env('OAUTH_SERVER').'/oauth/access_token');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_request);

            // Execute & get variables
            $api_response = json_decode(curl_exec($ch)); 
            $curlError = curl_error($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if($curlError){ 
                throw new Exception("Hubo un problema al intentar hacer la autenticacion. cURL problem: $curlError");
            }

            if($http_code != 200){
            if(isset($api_response->error)){
                    return response()->json(['error'=>$api_response->error],$http_code);	
                }else{
                    return response()->json(['error'=>"Error"],$http_code);
                }
            }

            //////////////////////////////mi api////////////////////////////////////

            $usuario = Usuario::where('email',$credentials['email'])->first();

            if(!$usuario) {                
                return response()->json(['error' => 'Este usuario no esta autorizado para utilizar este sistema'], 401); 
            }

            if(!$usuario->activo) {                
                return response()->json(['error' => 'El usuario esta desactivado'], 401); 
            }
            

            //Encriptamos el refresh oauth para que no quede 100% expuesto en la aplicacion web
            //$refresh_token_encrypted = Crypt::encrypt($api_response->refresh_token);
            return response()->json(['token' => 1], 200);





















            //si el usuario esta activo

            $log_usuario = new LogInicioSesion();
            $log_usuario->usuario_id = $usuario->id;
            $log_usuario->servidor_id = $usuario->servidor_id;
            $log_usuario->ip = $request->ip();
            $log_usuario->navegador = $request->header('User-Agent');
            $log_usuario->updated_at = Carbon::now();

            if(Hash::check($credentials['email'], $usuario->email)){
                $lista_permisos = "";
                $modulo_inicio = null;
                if ($usuario->su) {
                    $permisos = Permiso::all();
                    foreach ( $permisos as $permiso){
                        if ($lista_permisos != "") {
                            $lista_permisos .= "|";
                        }
                        $lista_permisos.=$permiso->id;
                    }
                } else {
                    $roles = $usuario->roles;
                    
                    foreach ( $roles as $rol){
                        $modulo_inicio = $rol->modulo_inicio;
                        $permisos = $rol->permisos;
                        foreach ( $permisos as $permiso){
                            if ($lista_permisos != "") {
                                $lista_permisos .= "|";
                            }
                            $lista_permisos.=$permiso->id;
                        }
                    }

                    if($usuario->modulo_inicio){
                        $modulo_inicio = $usuario->modulo_inicio;
                    }
                }
                
                $claims = [
                    "sub" => 1,
                    "id" => $usuario->id,
                    //"nombre" => $usuario->nombre,
                    //"apellidos" => $usuario->apellidos,
                    //"permisos" => $lista_permisos
                ];

                $unidades_medicas = [];
               
                if( $usuario->su ){
                    //buscar que tengan almacenes y almacenes externos
                    //$ums = UnidadMedica::where('activa',1)->orderBy('unidades_medicas.nombre')->get();
                    
                    $ums_ext = UnidadMedica::whereIn('clues', function($query){
                        $query->select('clues_perteneciente')->from('almacenes')->where('externo',1);
                    });

                    $ums = UnidadMedica::has('almacenes')
                        ->union($ums_ext)
                        ->orderBy('nombre')
                        ->get();

                    foreach($ums as $um){
                        
                        $almacenes_externos = Almacen::where('clues_perteneciente',$um->clues)->get();
                        
                        $um->almacenes; // Obtenemos los almacenes
                        $um->almacenes_externos = $almacenes_externos; // Obtenemos los almacenes externos

                       

                    }
                    $unidades_medicas = $ums;

                    //$unidades_medicas = UnidadMedica::has('almacenes')->with('almacenes')->orderBy('unidades_medicas.nombre')->get();
                } else {
                    $ums = $usuario->unidadesMedicas;
                    $almacenes = $usuario->almacenes()->lists("almacenes.id");
                    foreach($ums as $um){
                        $almacenes_res = $um->almacenes()->whereIn('almacenes.id',$almacenes)->get(); // aqui inserta almaces que dependande mi
                        $um->almacenes = $almacenes_res;
                        $almacenes_externos = Almacen::where('clues_perteneciente',$um->clues)->get();
                        $um->almacenes_externos = $almacenes_externos; // Obtenemos los almacenes externos
                        //$almacenes = $um->almacenes()->has('usuarios')->where('usuario_id',$usuario->id)->get();
                    }
                    $unidades_medicas = $ums;
                }

                $servidor_usuario = Servidor::find($usuario->servidor_id);
                

                $usuario_data = [
                    "id" => $usuario->id,
                    "nombre" => $usuario->nombre,
                    "apellidos" => $usuario->apellidos,
                    "su" => $usuario->su,
                    "avatar" => $usuario->avatar,
                    "medico_id" =>$usuario->medico_id,
                    "permisos" => $lista_permisos,                    
                    "unidades_medicas" =>  $unidades_medicas,
                    "servidor" => $servidor_usuario,
                    "modulo_inicio" => $modulo_inicio
                ];

                if($usuario->su){ //Harima: se agrego para los modulos de los proveedores
                    $usuario_data["proveedores"] = Proveedor::all();
                }

                $server_info = [
                    "server_datetime_snap" => getdate(),
                    "token_refresh_ttl" => Config::get("jwt.refresh_ttl"),
                    "api_version" => Config::get("sync.api_version"),
                    "data" => Servidor::find(env('SERVIDOR_ID')),
                ];

                $log_usuario->login_status = 'OK';
                $log_usuario->save();

                $payload = JWTFactory::make($claims);
                $token = JWTAuth::encode($payload);


                // CONFIGURACIÓN GENERAL
                $variable = ConfiguracionGeneral::get();
                $configuracion = [];

                foreach ($variable as $key => $value) {			
                    if($value->clave == 'fondo' || $value->clave == 'logo')
                        $configuracion[$value->clave] = $value->valor;
                    else
                        $configuracion[$value->clave] = json_decode($value->valor);
                }
                // CONFIGURACIÓN GENERAL
                

                $data_configuracion =  ["iva"=>16];
                return response()->json(['token' => $token->get(), 'configuracion_general'=>$configuracion, 'usuario'=>$usuario_data, 'server_info'=> $server_info], 200);
            } else {
                $log_usuario->login_status = 'ERR_PSW';
                $log_usuario->save();
                return response()->json(['error' => 'invalid_credentials'], 401); 
            }

        } catch (JWTException $e) {
            $log_usuario->login_status = 'ERR_TKN';
            $log_usuario->save();
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
    }
    public function refreshToken(Request $request){
        try{
            $token =  JWTAuth::parseToken()->refresh();

            return response()->json(['token' => $token], 200);

        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'token_expirado'], 401);  
        } catch (JWTException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
