<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use App\Models\empresa; 



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
}
