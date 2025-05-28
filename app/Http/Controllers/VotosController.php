<?php

namespace App\Http\Controllers;

use App\Services\CalculadoraVotos;
use Illuminate\Http\Request;


class VotosController extends Controller
{
    public function calcularPercentuais()
    {
        $totalEleitores = 1000;
        $votosValidos = 800;
        $votosBrancos = 150;
        $votosNulos = 50;

        $calculadora = new CalculadoraVotos($totalEleitores, $votosValidos, $votosBrancos, $votosNulos);

        $dados = [
            'total_eleitores' => $calculadora->getTotalEleitores(),
            'votos_validos' => $calculadora->getVotosValidos(),
            'votos_brancos' => $calculadora->getVotosBrancos(),
            'votos_nulos' => $calculadora->getVotosNulos(),
            'percentual_validos' => number_format($calculadora->percentualVotosValidos(), 2),
            'percentual_brancos' => number_format($calculadora->percentualVotosBrancos(), 2),
            'percentual_nulos' => number_format($calculadora->percentualVotosNulos(), 2)
        ];

        return response()->json($dados);
    }

    public function calcularComParametros(Request $request)
    {
        $request->validate([
            'total_eleitores' => 'required|integer|min:1',
            'votos_validos' => 'required|integer|min:0',
            'votos_brancos' => 'required|integer|min:0',
            'votos_nulos' => 'required|integer|min:0'
        ]);

        $calculadora = new CalculadoraVotos(
            $request->total_eleitores,
            $request->votos_validos,
            $request->votos_brancos,
            $request->votos_nulos
        );

        $dados = [
            'total_eleitores' => $calculadora->getTotalEleitores(),
            'votos_validos' => $calculadora->getVotosValidos(),
            'votos_brancos' => $calculadora->getVotosBrancos(),
            'votos_nulos' => $calculadora->getVotosNulos(),
            'percentual_validos' => number_format($calculadora->percentualVotosValidos(), 2),
            'percentual_brancos' => number_format($calculadora->percentualVotosBrancos(), 2),
            'percentual_nulos' => number_format($calculadora->percentualVotosNulos(), 2)
        ];

        return response()->json($dados);
    }
}