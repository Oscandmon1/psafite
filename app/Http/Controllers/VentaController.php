<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{

    public function index()
    {
        $ventas = Venta::with('vendedor')->get();

        if ($ventas->isEmpty()) {
            return response()->json([
                'message' => 'No se encontró ninguna venta.',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'ventas' => $ventas,
            'status' => 200
        ], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_vendedor' => 'required|exists:users,id',
            'referencia' => 'required|string|max:10',
            'valor' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $existingVenta = Venta::where('referencia', $request->referencia)
                            ->first();


        if ($existingVenta) {
            $data = [
                'message' => 'Ya existe una venta con la misma referencia No se puede crear la venta.',
                'status' => 409 
            ];
            return response()->json($data, 409); 
        }


        $venta = Venta::create([
            'id_vendedor' => $request->id_vendedor,
            'referencia' => $request->referencia,
            'valor' => $request->valor,
        ]);


        if (!$venta) {
            $data = [
                'message' => 'Error al crear la venta',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        
        $data = [
            'message' => 'Venta registrada con éxito',
            'venta' => $venta,
            'status' => 201
        ];
        return response()->json($data, 201);
    }


}
