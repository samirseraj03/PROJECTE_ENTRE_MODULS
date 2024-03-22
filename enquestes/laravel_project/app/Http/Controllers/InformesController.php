<?php

namespace App\Http\Controllers;

use App\Models\informes;
use Illuminate\Http\Request;

class InformesController extends Controller
{
    public function getInformes(){}

    public function insertarInforme($id_usuario , $id_enquesta , $id_company , $N_preguntas){
        
        $informes = new informes();
        $informes->enquesta = $id_enquesta;
        $informes->usuari = $id_usuario;
        $informes->company = $id_company;
        $informes->n_preguntas = $N_preguntas;
        $informes->save();
    }
    
    public function getSurveyUser(){

        $userId = auth()->user()->id; // Obtener el ID del usuario autenticado
        $UserSurvey = informes::where('usuari', $userId)->get();
        return count($UserSurvey);

    }

    public function countEnquestas(Request $request){

        $id_company = $request->input('idEmpresa');              
        $companySurvey = informes::where('company', $id_company)->get();
        return count($companySurvey);
    }

    public function countPreguntasPerUsuari(Request $request){

        $id_company = $request->input('idEmpresa');              

        $UserSurveyPreguntas = informes::where('usuari', $id_company)->pluck('n_preguntas');
        $count = 0;
        foreach ($UserSurveyPreguntas as $pregutnas){

            $count += intval($pregutnas);
        }
        return $count;
    }










}
