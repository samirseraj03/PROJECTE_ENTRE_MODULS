<?php

namespace App\Http\Controllers;

use App\Models\Informes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InformesController extends Controller
{
    public function getInformes()
    {
    }

    public function insertarInforme($id_usuario, $id_enquesta, $id_company, $N_preguntas)
    {

        $informes = new Informes();
        $informes->enquesta = $id_enquesta;
        $informes->usuario = $id_usuario;
        $informes->company = $id_company;
        $informes->n_preguntas = $N_preguntas;
        $informes->save();
    }

    public function getSurveyUser()
    {

        $userId = auth()->user()->id; // Obtener el ID del usuario autenticado
        $UserSurvey = Informes::where('usuario', $userId)->get();
        return count($UserSurvey);
    }

    public function countEnquestas(Request $request)
    {

        $id_company = $request->input('idEmpresa');
        $companySurvey = Informes::where('company', $id_company)->get();
        return count($companySurvey);
    }

    public function countPreguntasPerUsuari(Request $request)
    {

        $id_company = $request->input('idEmpresa');

        $UserSurveyPreguntas = Informes::where('usuario', $id_company)->pluck('n_preguntas');
        $count = 0;
        foreach ($UserSurveyPreguntas as $pregutnas) {

            $count += intval($pregutnas);
        }
        return $count;
    }


    public function countPreguntasPerEmpresa(Request $request)
    {

        $id_company = $request->input('idEmpresa');

        $UserSurveyPreguntas = Informes::where('company', $id_company)->pluck('n_preguntas');

        $count = 0;
        foreach ($UserSurveyPreguntas as $pregutnas) {

            $count += intval($pregutnas);
        }

        return $count;

    }



    function obtenerInformacionUsuarios()
    {
        try {
            $resultados = DB::table('usuarios as u')
            ->select('u.id', 'u.nombre', DB::raw('SUM(n_preguntas) as n_preguntas'))
            ->join('informes as i', 'i.usuario', '=', 'u.id')
            ->groupBy('u.id', 'u.nombre')
            ->get();

        // Convertir los resultados a un array
        $arrayResultados = [];
        foreach ($resultados as $resultado) {
            $estado = 'No está activo';
            if ($resultado->n_preguntas >= 5 && $resultado->n_preguntas <= 10) {
                $estado = 'Puede ser activo';
            } elseif ($resultado->n_preguntas > 10) {
                $estado = 'Activo';
            }

            $arrayResultados[] = [
                'id' => $resultado->id,
                'nombre' => $resultado->nombre,
                'n_preguntas' => $resultado->n_preguntas,
                'estado' => $estado
            ];
        }
            return view('informes', compact('arrayResultados'));

        } catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e
            ], 500);
        }

    }



}
