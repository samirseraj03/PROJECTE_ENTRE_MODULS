<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Encuesta;
use App\Models\opciones;
use App\Models\preguntas;
use App\Models\TipusPregunta;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Mockery\Undefined;
use App\Http\Controllers\InformesController;

class EnquestaController extends Controller
{

    public function GetALLEnquestas()
    {
        try {
            $empresas = Encuesta::all();
            return response()->json([
                'success' => true,
                'data' => $empresas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en mostrar la Empresa'
            ], 500);
        }
    }

    public function mostrarEnquesta(Request $request)
    {
        try {
            // Retrieve the selectParam from the request
            $selectParam = $request->input('enquesta');

            $result = $this->processData($selectParam);

            // Return the view with processed data
            return $result;
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 500);
        }
    }

    private function processData($param1)
    {
        try {
            // Saved Json
            $formattedData2 = [];

            $idEncuesta = $param1; //$itemsFormatats[0]['id_encuesta'];

            $preguntes = preguntas::where('id_encuesta', $idEncuesta)->get();
            $preguntesFormatades = $preguntes->toArray();

            foreach ($preguntesFormatades as &$pregunta) {
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
                $opcionsFormatades = $opcions->toArray();

                foreach ($opcionsFormatades as &$opcio) {
                    $formatedOpcions[] = $opcio['descripcion'];
                }

                $formattedPregunta +=
                    [
                        "id" => "$id_pregunta",
                        "tipus" => "$nom_tipus",
                        "pregunta" => "$enunciat",
                    ];

                if (count($formatedOpcions) <= 1) {
                    if ($formatedOpcions == null || !isset($formatedOpcions)) {
                        $formattedPregunta +=
                            [
                                "placeholder" => "Inserta un valor",
                            ];
                    } else {
                        $formattedPregunta +=
                            [
                                "placeholder" => $formatedOpcions[0],
                            ];
                    }
                } else {
                    $formattedPregunta +=
                        [
                            "opcions" => $formatedOpcions,
                        ];
                }
                $formattedData2[] = $formattedPregunta;
            }

            // Return a sample result for demonstration
            return [
                'enquesta' => $formattedData2,
                'result' => 'Succes',
            ];
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 500);
        }
    }

    private function processEmpresa($param1)
    {
        try {
            // Saved Json
            $idEncuesta = $param1; //$itemsFormatats[0]['id_encuesta'];

            $encuesta = encuesta::where('id_encuesta', $idEncuesta)->get();
            $id_empresa = $encuesta[0]['id_empresa'];

            // Return a sample result for demonstration
            return $id_empresa;
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 500);
        }
    }

    public function getEnquesta(Request $request): View
    {
        try {
            // Retrieve the selectParam from the request
            $selectParam = $request->input('selectEnquesta');

            $result = $this->processData($selectParam);

            $empresa = $this->processEmpresa($selectParam);

            $info = [];

            $info += ["enquesta_id" => $selectParam];
            $info += ["empresa_id" => $empresa];

            // Return the view with processed data
            return view('survey', ['data' => $result], ['info' => $info], ['info' => $info]);
            //var empresa = @json($id_empresa)
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e
            ], 500);
        }
        //'Credenciales inválidas'
    }

    
    public function insertResposta(Request $request)
    {
        try 
        {
            $data = $request->all();
            
            // Check if id_empresa exists and is not empty
            if (!empty($data)) {
                // Use the id_empresa value in your logic
                // For example, you can perform database queries, calculations, or other operations
                // based on the id_empresa value

                $informController = new InformesController();

                try 
                {   
                    $id_usuario = auth()->user()->id;
                }
                catch (\Exception $e) 
                {
                    $id_usuario = null;
                }

                $id_empresa = $request->input('id_empresa');
                $id_enquesta = $request->input('id_enquesta');
                $num_preguntes = count($request->all())-3; //We take the data of id_empresa, id_enquesta and _token

                $informController->insertarInforme($id_usuario, $id_enquesta, $id_empresa, $num_preguntes);
            }

            //$id_empresa = $data['data'];
            /*
            return response()->json([
                'success' => true,
                'data' => $id_usuario,
            ], 200);
            */
            
            return redirect('/home')->with('success', '¡Encuesta enviada correctamente!');
            //Enviar correu validació
            //Mail::to($request->correo)->send(new MyEmail($request->nombre, "s'ha creat un nou compte d'usuari."));
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e
            ], 500);
        }
    }
}
