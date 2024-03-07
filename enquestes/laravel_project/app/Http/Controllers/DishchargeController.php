<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use App\Models\empresa;
use App\Models\Encuesta;
use DateTime;
use Illuminate\View\View;




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
        return view('discharge.new-ask', compact('empresas'));
    }

    public function FunctionName() : view {

        

        return view('discharge.new-ask', compact('empresas'));  
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






}
