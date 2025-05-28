<?php

namespace App\Http\Controllers;

use App\Services\SomaMultiplos;
use Illuminate\Http\Request;

class SomaMultiplosController extends Controller
{
    /**
     * Executa o teste do exercício (múltiplos abaixo de 10)
     */
    public function executarTesteExercicio()
    {
        $somaMultiplos = new SomaMultiplos();
        $teste = $somaMultiplos->executarTesteExercicio();
        $informacoes = $somaMultiplos->getInformacoes();
        
        return response()->json([
            'titulo' => 'Teste do Exercício - Múltiplos de 3 ou 5',
            'informacoes' => $informacoes,
            'resultado_teste' => $teste
        ]);
    }   

    /**
     * Endpoint simples para cálculo rápido
     */
    public function calcular($numero)
    {
        if (!is_numeric($numero) || $numero <= 0) {
            return response()->json([
                'erro' => true,
                'mensagem' => 'numero deve ser um número positivo'
            ], 400);
        }

        $numero = (int) $numero;
        if ($numero > 1000000) {
            return response()->json([
                'erro' => true,
                'mensagem' => 'numero muito alto. Use até 1.000.000'
            ], 400);
        }

        $somaMultiplos = new SomaMultiplos();
        
        // Usa fórmula para números grandes, iterativo para pequenos
        if ($numero > 10000) {
            $resultado = $somaMultiplos->calcularFormula($numero, false);
            $metodo = 'formula_matematica';
        } else {
            $resultado = $somaMultiplos->calcularIterativo($numero, false);
            $metodo = 'iterativo';
        }
        
        return response()->json([
            'numero' => $numero,
            'soma_total' => $resultado['soma_total'],
            'metodo_usado' => $metodo,
            'exemplo' => $numero <= 20 ? $resultado['multiplos_encontrados'] ?? 'Múltiplos calculados por fórmula' : 'Múltiplos não listados (numero alto)'
        ]);
    }

}