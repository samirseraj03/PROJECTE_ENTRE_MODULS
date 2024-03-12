<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
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
        // Implement your logic here based on parameters

        // For example, you can query a database, perform calculations, etc.
        $items = Encuesta::where('descripcion', $param1)->get();
        $itemsFormatats = $items->toArray();
        $idEncuesta = $itemsFormatats[0]['id_encuesta'];

        

        $formattedData = [
            [
                "id" => "nomComplet",
                "tipus" => "text",
                "pregunta" => "Quin és el teu nom complet? Això Funciona",
                "placeholder" => "Escriu el teu nom complet aquí"
            ],
            [
                "id" => "dataNaixement",
                "tipus" => "date",
                "pregunta" => "Quina és la teva data de naixement?",
                "placeholder" => "Selecciona la teva data de naixement"
            ],
            [
                "id" => "email",
                "tipus" => "email",
                "pregunta" => "Quin és el teu correu electrònic?",
                "placeholder" => "Escriu el teu correu electrònic aquí"
            ],
            [
                "id" => "ocupacio",
                "tipus" => "select",
                "pregunta" => "Quina és la teva ocupació actual?",
                "opcions" => [
                    "Estudiant",
                    "Professional",
                    "Autònom",
                    "Desocupat",
                    "Altres"
                ]
            ],
            [
                "id" => "interessos",
                "tipus" => "checkbox",
                "pregunta" => "Quins són els teus interessos? (Selecciona tot el que correspongui)",
                "opcions" => [
                    "Lectura",
                    "Esports",
                    "Viages",
                    "Cinema",
                    "Cuina",
                    "Tecnologia"
                ]
            ],
            [
                "id" => "genere",
                "tipus" => "radio",
                "pregunta" => "Quin és el teu gènere?",
                "opcions" => [
                    "Femení",
                    "Masculí",
                    "No binari",
                    "Prefereixo no dir-ho"
                ]
            ],
            [
                "id" => "comentaris",
                "tipus" => "textarea",
                "pregunta" => "Tens algun comentari o suggeriment?",
                "placeholder" => "Escriu els teus comentaris aquí"
            ]
        ];

        // Return a sample result for demonstration
        return [
            'enquesta' => $formattedData,
            'result' => 'Bondia',
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
