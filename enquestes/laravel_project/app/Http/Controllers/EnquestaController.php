<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\opciones;
use App\Models\preguntas;
use App\Models\TipusPregunta;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EnquestaController extends Controller
{
    public function getEnquesta(Request $request): View
    {
        // Retrieve parameters from the request
        $param1 = $request->input('param1');
        $param2 = $request->input('param2');

        // Your logic based on parameters
        $result = $this->processData($param1);

        // Return the view with processed data
        return view('survey2', ['data' => $result]);
    }

    private function processData($param1)
    {
        // Saved Json
        $formattedData2 = [];

        // For example, you can query a database, perform calculations, etc.
        $items = encuesta::where('descripcion', $param1)->get();
        $itemsFormatats = $items->toArray();
        $idEncuesta = $itemsFormatats[0]['id_encuesta'];

        $preguntes = preguntas::where('id_encuesta', $idEncuesta)->get();
        $preguntesFormatades = $preguntes->toArray();

        foreach ($preguntesFormatades as &$pregunta) 
        {
            $formattedPregunta = [];

            // Save Questions parameters
            $enunciat = $pregunta['enunciado'];
            $id_pregunta = $pregunta['id_pregunta'];
            $id_tipus = $pregunta['id_tipus'];

            // Get Tipus Name
            $tipus = TipusPregunta::where('id_tipus', $id_tipus)->get();
            $tipusFormatat = $tipus->toArray();
            $nom_tipus = $tipusFormatat[0]['tipus'];

            // Get Question options
            $formatedOpcions = [];

            $opcions = opciones::where('id_pregunta', $id_pregunta)->get();
            $opcionsFormatades = $opcions-> toArray();

            foreach($opcionsFormatades as &$opcio)
            {
                $formatedOpcions[] = $opcio['descripcion'];
            }

            $formattedPregunta += 
            [
                "id" => "$id_pregunta",
                "tipus" => "$nom_tipus" ,
                "pregunta" => "$enunciat",
            ];

            if(count($formatedOpcions) <= 1)
            {
                $formattedPregunta +=
                [
                    "placeholder" => $formatedOpcions[0],
                ];
            }
            else
            {
                $formattedPregunta +=
                [
                    "opcions" => $formatedOpcions,
                ];
            }
            $formattedData2[] = $formattedPregunta;
        }

        $formattedData = $formattedData2;

        // Return a sample result for demonstration
        return [
            'enquesta' => $formattedData,
            'result' => 'Succes',
        ];
    }

    public function postEnquesta(Request $request): View
    {
        // Retrieve the selectParam from the request
        $selectParam = $request->input('selectEnquesta');

        $result = $this->processData($selectParam);

        // Return the view with processed data
        return view('survey', ['data' => $result]);
    }
}
