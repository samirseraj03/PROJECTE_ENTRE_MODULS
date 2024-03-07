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
        $result = $this->processData($param1, $param2);

        // Return the view with processed data
        return view('survey2', ['data' => $result]);
    }

    private function processData($param1)
    {
        // Implement your logic here based on parameters

        // For example, you can query a database, perform calculations, etc.
        $itemID = Encuesta::where('descripcion', $param1)->get();

        // Return a sample result for demonstration
        return [
            'enquesta' => $itemID,
            'result' => 'Bondia',
        ];
    }

    public function postEnquesta(Request $request): View
    {
        // Retrieve the selectParam from the request
        $selectParam = $request->input('selectEnquesta');

        $result = $this->processData($selectParam);

        // Return the view with processed data
        return view('survey2', ['data' => $result]);
    }
}
