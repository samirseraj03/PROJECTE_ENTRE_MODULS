<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use App\Models\Empresa;
use App\Models\Encuesta;
use App\Models\TipusPregunta;
use DateTime;
use Illuminate\View\View;

use App\Models\Opciones;
use App\Models\Preguntas;
use Attribute;
use Mockery\Generator\StringManipulation\Pass\Pass;

class DishchargeController extends Controller
{
    public function DischargeCompany(Request $request): RedirectResponse
    {
        try {
            // Obtener parámetros de la solicitud
            $nombreEmpresa = $request->input('nombreEmpresa');

            // Lógica basada en los parámetros
            $empresa = new Empresa();
            $empresa->nombre = $nombreEmpresa;
            $empresa->save();

            // Redirigir a la página de inicio con un mensaje de éxito
            return redirect()->route('home')->with('success', 'Empresa creada correctamente');
        } catch (\Exception $e) {
            // Manejar cualquier excepción y devolver un mensaje de error
            return redirect()->route('home')->with('error', 'Error al crear la Empresa: ' . $e->getMessage());
        }
    }


    public function LoadDischargeSurvey(Request $request): View
    {
        try {
            $empresas = Empresa::all();
            return view('discharge.new-survey', compact('empresas'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 500);
        }
    }


    public function LoadDischargeAsk(Request $request): View
    {
        try {
            $empresas = Empresa::all();
            $tipus = TipusPregunta::all();

            return view('discharge.new-ask', compact('empresas', 'tipus'));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 500);
        }
    }


    public function DischargeSurvey(Request $request): RedirectResponse
    {
        try {
            $idEmpresa = $request->input('id_empresa');
            $NombreEncuesta = $request->input('nombreEncuesta');
            $fechaFinalizacion = new DateTime($request->input('fechaFinalizacion'));
            $fechaCreacion = new DateTime();

            // Tu lógica basada en los parámetros
            $Encuesta = new Encuesta();
            $Encuesta->descripcion = $NombreEncuesta;
            $Encuesta->data_creacion = $fechaCreacion;
            $Encuesta->data_finalizacion = $fechaFinalizacion;
            $Encuesta->id_empresa = $idEmpresa;

            $Encuesta->save();

            // Redirigimos a la página de inicio con un mensaje de éxito
            return redirect()->route('home')->with('success', 'encuesta creada correctamente');
        } catch (\Exception $e) {
            // Manejamos cualquier excepción y devolvemos un mensaje de error
            return redirect()->route('home')->with('error', 'Error al crear la encuesta: ' . $e->getMessage());
        }
    }



    // obtner todas las opciones disponibles
    public function getopciones()
    {
        try {
            $opciones = Opciones::all();
            return response()->json($opciones);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 500);
        }
    }

    public function InsertOption(Request $request): RedirectResponse
    {

        try {
            $opciones = new Opciones();
            $opciones->descripcion =  $request->input('opcio');
            $opciones->save();

            return redirect()->route('show_option_form')->with('success', 'pregunta creada correctamente');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error al crear la opcio: ' . $e->getMessage());
        };
    }



    public function insert_new_ask(Request $request): RedirectResponse
    {
        try {
            // RECOGER LOS DATOS DEL FORMULARIO DE LAS ALTAS
            $id_encuesta = $request->input('selectEncuesta');
            $nombre_pregunta = $request->input('nombrePregunta');
            $Tipus_pregunta = $request->input('selectTipusPregunta');

            // hacemos el insert para la tabla de pregunta
            $Pregunta = new Preguntas();
            $Pregunta->id_encuesta = $id_encuesta;
            $Pregunta->enunciado = $nombre_pregunta;
            $Pregunta->id_tipus = $Tipus_pregunta;
            $Pregunta->save();

            // Obtenemos el ID de la pregunta recién creada
            $id_pregunta_nueva = $Pregunta->id_pregunta;

            if ($Tipus_pregunta == "4" || $Tipus_pregunta == "5") {
                // recogemos los datos para tipus de preguntas
                $opciones_selecciondas = $request->input('opcionsSeleccionades');
                $arrayTmp =  explode(',', $opciones_selecciondas);
                $arrayTmp = array_map('intval', $arrayTmp);

                $opciones = Opciones::all();

                foreach ($opciones as $opcion) {
                    if (in_array($opcion->id_opcion, $arrayTmp, true)) {
                        // Insertamos la información que falta para las opciones y asignarlas a la pregunta
                        $opciones_insert = new Opciones();
                        $opciones_insert->id_pregunta = $id_pregunta_nueva;
                        $opciones_insert->descripcion = $opcion->descripcion;
                        $opciones_insert->save();
                    }
                }
            }

            // Redirigimos a la página de inicio con un mensaje de éxito
            return redirect()->route('home')->with('success', 'pregunta creada correctamente');
        } catch (\Exception $e) {
            // Manejamos cualquier excepción y devolvemos un mensaje de error
            return redirect()->route('home')->with('error', 'Error al crear la pregunta: ' . $e->getMessage());
        }
    }
}
