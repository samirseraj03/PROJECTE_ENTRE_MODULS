<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use App\Models\empresa;
use App\Models\Encuesta;
use App\Models\TipusPregunta;
use DateTime;
use Illuminate\View\View;

use App\Models\opciones;
use App\Models\preguntas;
use Attribute;
use Mockery\Generator\StringManipulation\Pass\Pass;

class DishchargeController extends Controller
{
    public function DischargeCompany(Request $request): RedirectResponse
    {

        // Retrieve parameters from the request
        $param1 = $request->input('nombreEmpresa');

        // Your logic based on parameters
        $Company = new Empresa();
        $Company->nombre = $param1;
        $Company->save();

        return redirect()->route('home')->with('success', 'Empresa creada correctamente');
    }

    public function LoadDischargeSurvey(Request $request): View
    {

        $empresas = empresa::all();
        return view('discharge.new-survey', compact('empresas'));
    }


    public function LoadDischargeAsk(Request $request): View
    {

        $empresas = empresa::all();
        $tipus = TipusPregunta::all();


        return view('discharge.new-ask', compact('empresas' ,'tipus'));
    }


    public function DischargeSurvey(Request $request): RedirectResponse
    {


        $idEmpresa = $request->input('id_empresa');
        $NombreEncuesta = $request->input('nombreEncuesta');
        $fechaFinalizacion = new DateTime($request->input('fechaFinalizacion'));
        $fechaCreacion = new DateTime();

        // Your logic based on parameters
        $Encuesta = new Encuesta();
        $Encuesta->descripcion = $NombreEncuesta;
        $Encuesta->data_creacion = $fechaCreacion;
        $Encuesta->data_finalizacion = $fechaFinalizacion;
        $Encuesta->id_empresa = $idEmpresa;

        $Encuesta->save();

        return redirect()->route('home')->with('success', 'encuesta creada correctamente');
    }


    // obtner todas las opciones disponibles
    public function getopciones()  {

       $opciones = opciones::all();
       return response()->json($opciones); 
    }


    public function insert_new_ask(Request $request) :  RedirectResponse {
   


        // RECOGER LOS DATOS DEL FORMAULARIO DE LAS ALTAS 
        $id_encuesta = $request->input('selectEncuesta');
        $nombre_pregunta = $request->input('nombrePregunta');
        $Tipus_pregunta = $request->input('selectTipusPregunta');

        // hacemos el insert para la tabla de pregunta
        $Pregunta = new preguntas();
        $Pregunta->id_encuesta = $id_encuesta;
        $Pregunta->enunciado = $nombre_pregunta;
        $Pregunta->id_tipus = $Tipus_pregunta;
        $Pregunta->save();

        $id_pregunta_nueva = $Pregunta->id_pregunta;


 
        if ($Tipus_pregunta == "4" || $Tipus_pregunta == "5" ){
            // recogemos los datos para tipus de preguntas 
            $opciones_selecciondas = $request->input('opcionsSeleccionades');
            $arrayTmp =  explode(',', $opciones_selecciondas);
            $arrayTmp = array_map('intval', $arrayTmp);

            $opciones = opciones::all();



            for ( $i = 0 ; $i < count($opciones) - 1 ; $i++){
                
                $id_opcion_buscar = $opciones[$i]->id_opcion;


                if (in_array($id_opcion_buscar, $arrayTmp , true) == true) {

                    // insertamos la informacion que falta para las opciones y assiganrlas a la pregunta
                    $opciones_insert = new opciones();
                    $pregunta = $opciones->where('id_opcion', $id_opcion_buscar)->pluck('descripcion');
                    $opciones_insert->id_pregunta = $id_pregunta_nueva ;
                    $opciones_insert->descripcion = $pregunta->first() ;
                    $opciones_insert->save();
                  }
                };
        }
        return redirect()->route('home')->with('success', 'pregunta creada correctamente');
    }






}
