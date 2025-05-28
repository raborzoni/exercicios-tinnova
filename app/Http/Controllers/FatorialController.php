<?php

namespace App\Http\Controllers;

use App\Services\Fatorial;
use Illuminate\Http\Request;

class FatorialController extends Controller
{
    /**
     * Executa os testes do exercício
     */
    public function executarTestes()
    {
        $fatorial = new Fatorial();
        $testes = $fatorial->executarTestes();
        $informacoes = $fatorial->getInformacoes();
        
        return response()->json([
            'titulo' => 'Testes do Exercício - Fatorial',
            'informacoes' => $informacoes,
            'resultados_dos_testes' => $testes
        ]);
    }

    /**
     * Endpoint simples para cálculo rápido
     */
    public function calcular($numero)
    {
        if (!is_numeric($numero) || $numero < 0 || $numero > 20) {
            return response()->json([
                'erro' => true,
                'mensagem' => 'Número deve ser um inteiro entre 0 e 20'
            ], 400);
        }

        $numero = (int) $numero;
        $fatorial = new Fatorial();
        $resultado = $fatorial->calcularIterativo($numero, false);
        
        return response()->json([
            'numero' => $numero,
            'fatorial' => $resultado['resultado'],
            'expressao' => "{$numero}! = {$resultado['resultado']}"
        ]);
    }
}