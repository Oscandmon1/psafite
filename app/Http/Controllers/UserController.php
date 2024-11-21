<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Venta;

class UserController extends Controller
{
    public function index()
    {
        $users = User:: all();

        $data =[
            'users' => $users,
            'status' =>200
        ];

        return response()->json($data, 200);
    }



    

    public function store(Request $request){

        $validator = Validator:: make ($request->all(),[
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required | email |unique:users',
        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        if (!$user){
            $data = [
                'message' => 'Error al crear el usuario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data =[
            'user' => $user,
            'status' => 201
        ];

        return response()->json($data, 201);

    }


    public function show($id)
    {
        $user = User:: find ($id);

        if(!$user){
            $data=[
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response() ->json($data,404);
        }

        $data=[
            'user' => $user,
            'status' => 200
        ];
        return response() ->json($data,200);

    }



    public function update(Request $request, $id){
        $user = User::find($id);

        if(!$user){
            $data=[
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response() ->json($data,404);
        }

        $validator = Validator:: make ($request->all(),[
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required | email |unique:user',
        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $user -> name = $request-> name;
        $user -> phone = $request-> phone;
        $user -> email = $request-> email;

        $user-> save();

        $data=[
            'message' => 'Usuario actualizado',
            'user' => $user,
            'status' => 200
        ];
        return response()->json($data, 200);

    }


    public function updatePartial(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->only(['name', 'phone', 'email']), [
            'email' => 'email|unique:users,email,' . $id, 
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        $user->save();

        $data = [
            'message' => 'Usuario actualizado',
            'user' => $user,
            'status' => 200
        ];
        return response()->json($data, 200);
    }




    public function destroy($id)
    {
        // Buscar el usuario por su ID
        $user = User::find($id);
    
        // Verificar si el usuario existe
        if (!$user) {
            $data = [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
    
        // Verificar si el usuario tiene ventas asociadas
        $ventasAsociadas = Venta::where('id_vendedor', $id)->exists();
    
        if ($ventasAsociadas) {
            $data = [
                'message' => 'No se puede eliminar el usuario porque tiene ventas asociadas.',
                'status' => 409 // Código de estado para conflicto
            ];
            return response()->json($data, 409);
        }
    
        // Eliminar el usuario si no tiene ventas asociadas
        $user->delete();
    
        $data = [
            'message' => 'Usuario eliminado correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

}
