<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConvertisseurController extends Controller
{
    public function index()
    {
        return view('convertisseur');
    }

    public function convertir(Request $request)
    {
        $montant = $request->input('montant');
        $sens = $request->input('sens');

        if ($sens === 'MAD_TO_USD') {
            $resultat = $montant / 10; // Exemple : 1 USD = 10 MAD
        } else {
            $resultat = $montant * 10;
        }

        return view('convertisseur', [
            'montant' => $montant,
            'sens' => $sens,
            'resultat' => $resultat
        ]);
    }
}
