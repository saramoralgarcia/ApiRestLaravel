<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
/**
* @OA\Info(
*             title="Api Registro de Clientes. Proyecto Sara Moral", 
*             version="1.0.0",
*             description="Esta API se encarga de manejar la información de la base de datos de clientes."
* )
*
* @OA\Server(url="http://localhost:8000")
*/
class ClienteController extends Controller
{
//-----------------------------------------------
//-----------------Listar Todo-------------------
//-----------------------------------------------

/**
     * Listado de todos Todos los registros de la base de datos clientes.
     * @OA\Get (
     *     path="/api/Clientes",
     *     tags={"Cliente"},
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="nombre",
     *                         type="string",
     *                         example="Sara"
     *                     ),
     *                     @OA\Property(
     *                         property="correo",
     *                         type="string",
     *                         example="sara@gmail.com"
     *                     ),
     *                     @OA\Property(
     *                         property="telefono",
     *                         type="string",
     *                         example="666666666"
     *                     ),
     *                     @OA\Property(
     *                         property="direccion",
     *                         type="string",
     *                         example="Ventas"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         example="2023-02-23T00:09:16.000000Z"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         example="2023-02-23T12:33:45.000000Z"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return Cliente::all();
    }


//-----------------------------------------------
//-----------------Crear---------------------
//-----------------------------------------------

/**
     * Registrar un Cliente
     * @OA\Post (
     *     path="/api/Clientes",
     *     tags={"Cliente"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="nombre",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="correo",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="telefono",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="direccion",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "nombre":"",
     *                     "correo":"",
     *                     "telefono":"",
     *                     "direccion":""
     * 
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="CREATED",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="nombre", type="string", example="Albert Gómez"),
     *              @OA\Property(property="correo", type="string", example="albert@gmail.com"),
     *              @OA\Property(property="telefono", type="string", example="987456321"),
     *              @OA\Property(property="direccion", type="string", example="Madrid"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="UNPROCESSABLE CONTENT",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The nombre field is required."),
     *              @OA\Property(property="errors", type="string", example="Objeto de errores"),
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required',
            'telefono' => 'required',
            'direccion' => 'required'

        ]);

        $cliente = new Cliente;
        $cliente->nombre = $request->nombre;
        $cliente->correo= $request->correo;
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;
        $cliente->save();

        return $cliente;
    }

//-----------------------------------------------
//-----------------Listar un Registro---------------------
//-----------------------------------------------
/**
     * Mostrar la información de un cliente
     * @OA\Get (
     *     path="/api/Clientes/{id}",
     *     tags={"Cliente"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=2),
     *              @OA\Property(property="nombres", type="string", example="Sara García"),
     *              @OA\Property(property="correo", type="string", example="sara@gmail.com"),
     *              @OA\Property(property="telefono", type="string", example="123456789"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *         )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NO SE ENCUENTRA EL REGISTRO",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Cliente] #id"),
     *          )
     *      )
     * )
     */

    public function show($id)
    {
        $cliente = Cliente::find($id);
        
        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }
        
        return response()->json($cliente);
    }

//-----------------------------------------------
//-----------------Modificar---------------------
//-----------------------------------------------

/**
 * Actualizar un Cliente
 * @OA\Put (
 *     path="/api/Clientes/{id}",
 *     tags={"Cliente"},
 *     @OA\Parameter(
 *         in="path",
 *         name="id",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(
 *                     property="nombre",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="correo",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="telefono",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="direccion",
 *                     type="string"
 *                 )
 *             ),
 *             example={
 *                 "nombre": "",
 *                 "correo": "",
 *                 "telefono": "",
 *                 "direccion": ""
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="success",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="number", example=1),
 *             @OA\Property(property="nombre", type="string", example="pepe"),
 *             @OA\Property(property="correo", type="string", example="pepe@gmail.es"),
 *             @OA\Property(property="telefono", type="string", example="654789321"),
 *             @OA\Property(property="direccion", type="string", example="Los Palacios"),
 *             @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
 *             @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="UNPROCESSABLE CONTENT",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The correo field is required."),
 *             @OA\Property(property="errors", type="string", example="Objeto de errores"),
 *         )
 *     )
 * )
 */


    public function update(Request $request, String $id)
    {
        // dd($request->all());
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required',
            'telefono' => 'required',
            'direccion' => 'required'

        ]);

        // $request->validate([
        //     'nombre' => 'required',
        //     'correo' => 'required|email'//|unique:clientes' . $id,
        //      //|numeric|digits:9', //digits:9 es que tiene que tener 9 numeros
        //     // 'direccion' => 'nullable',
        // ], [
        // //     'nombre.required' => 'El campo nombre es obligatorio.',
        // //     'correo.required' => 'El campo correo es obligatorio.',
        //     // 'correo.email' => 'El campo correo debe ser una dirección de correo electrónico válida.',
        // //     'telefono.required' => 'El campo debe ser un número.',
        // //     //'telefono.digits' => 'El campo debe tener 9 digitos.',
        // ]);
       

    $cliente = Cliente::findOrFail($id);

    $cliente->nombre = $request->nombre;
    $cliente->correo = $request->correo;
    $cliente->telefono = $request->telefono;
    $cliente->direccion = $request->direccion;
    $cliente->save();

    return $cliente;


    }

//-----------------------------------------------
//-----------------Eliminar---------------------
//-----------------------------------------------
  
/**
     * Eliminar un cliente
     * @OA\Delete (
     *     path="/api/Clientes/{id}",
     *     tags={"Cliente"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="NO CONTENT"
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="no encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No se pudo realizar correctamente la operación"),
     *          )
     *      )
     * )
     */

    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) 
        {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }
        $cliente->delete();
        //la 204 la respuesta se ha enviado con exito
        return response()->json(['message' => 'El cliente se ha eliminado correctamente'], 204);
    }
}



