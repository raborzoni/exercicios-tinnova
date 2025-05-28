<?php

namespace App\Http\Controllers;

use App\Services\BubbleSort;
use Illuminate\Http\Request;

class BubbleSortController extends Controller
{
    /**
     * Ordena o vetor do exercício com detalhamento completo
     */
    public function ordenarVetorExercicio()
    {
        $vetorExercicio = [5, 3, 2, 4, 7, 1, 0, 6];
        
        $bubbleSort = new BubbleSort($vetorExercicio);
        $vetorOrdenado = $bubbleSort->ordenar(true); 
        
        return response()->json([
            'vetor_original' => $vetorExercicio,
            'vetor_ordenado' => $vetorOrdenado,
            'estatisticas' => $bubbleSort->getEstatisticas(),
            'historico_completo' => $bubbleSort->getHistorico()
        ]);
    }
}