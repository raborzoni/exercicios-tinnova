<?php

namespace App\Services;

class BubbleSort
{
    private array $vetor;
    private array $historico;
    private int $totalTrocas;
    private int $totalComparacoes;

    public function __construct(array $vetor)
    {
        $this->vetor = $vetor;
        $this->historico = [];
        $this->totalTrocas = 0;
        $this->totalComparacoes = 0;
    }

    /**
     * Executa o algoritmo Bubble Sort
     * 
     * @param bool $mostrarPassos - Se true, salva cada passo no histórico
     * @return array
     */
    public function ordenar(bool $mostrarPassos = false): array
    {
        $n = count($this->vetor);
        $vetor = $this->vetor; 
        
        if ($mostrarPassos) {
            $this->historico[] = [
                'tipo' => 'inicio',
                'vetor' => $vetor,
                'mensagem' => "Vetor inicial: [" . implode(', ', $vetor) . "]"
            ];
        }

        for ($iteracao = 0; $iteracao < $n - 1; $iteracao++) {
            $houveTroca = false;
            
            if ($mostrarPassos) {
                $this->historico[] = [
                    'tipo' => 'iteracao',
                    'iteracao' => $iteracao + 1,
                    'vetor' => $vetor,
                    'mensagem' => "=== ITERAÇÃO " . ($iteracao + 1) . " ==="
                ];
            }

            for ($i = 0; $i < $n - 1 - $iteracao; $i++) {
                $this->totalComparacoes++;
                
                if ($mostrarPassos) {
                    $this->historico[] = [
                        'tipo' => 'comparacao',
                        'posicoes' => [$i, $i + 1],
                        'valores' => [$vetor[$i], $vetor[$i + 1]],
                        'vetor' => $vetor,
                        'mensagem' => "Comparando posições $i e " . ($i + 1) . ": {$vetor[$i]} e {$vetor[$i + 1]}"
                    ];
                }

                if ($vetor[$i] > $vetor[$i + 1]) {
                    $temp = $vetor[$i];
                    $vetor[$i] = $vetor[$i + 1];
                    $vetor[$i + 1] = $temp;
                    
                    $this->totalTrocas++;
                    $houveTroca = true;

                    if ($mostrarPassos) {
                        $this->historico[] = [
                            'tipo' => 'troca',
                            'posicoes' => [$i, $i + 1],
                            'valores_antes' => [$temp, $vetor[$i]],
                            'valores_depois' => [$vetor[$i], $vetor[$i + 1]],
                            'vetor' => $vetor,
                            'mensagem' => "TROCA: {$temp} ↔ {$vetor[$i]} | Vetor: [" . implode(', ', $vetor) . "]"
                        ];
                    }
                } else if ($mostrarPassos) {
                    $this->historico[] = [
                        'tipo' => 'sem_troca',
                        'posicoes' => [$i, $i + 1],
                        'valores' => [$vetor[$i], $vetor[$i + 1]],
                        'vetor' => $vetor,
                        'mensagem' => "SEM TROCA: {$vetor[$i]} ≤ {$vetor[$i + 1]} | Vetor: [" . implode(', ', $vetor) . "]"
                    ];
                }
            }

            if ($mostrarPassos) {
                $elementosOrdenados = array_slice($vetor, $n - 1 - $iteracao);
                $this->historico[] = [
                    'tipo' => 'fim_iteracao',
                    'iteracao' => $iteracao + 1,
                    'vetor' => $vetor,
                    'elementos_ordenados' => $elementosOrdenados,
                    'mensagem' => "Fim da iteração " . ($iteracao + 1) . ". Elementos já ordenados: [" . implode(', ', $elementosOrdenados) . "]"
                ];
            }

            if (!$houveTroca) {
                if ($mostrarPassos) {
                    $this->historico[] = [
                        'tipo' => 'otimizacao',
                        'vetor' => $vetor,
                        'mensagem' => "Nenhuma troca realizada. Vetor já está ordenado!"
                    ];
                }
                break;
            }
        }

        if ($mostrarPassos) {
            $this->historico[] = [
                'tipo' => 'resultado_final',
                'vetor' => $vetor,
                'total_comparacoes' => $this->totalComparacoes,
                'total_trocas' => $this->totalTrocas,
                'mensagem' => "RESULTADO FINAL: [" . implode(', ', $vetor) . "]"
            ];
        }

        return $vetor;
    }

    /**
     * Retorna o histórico de execução
     * 
     * @return array
     */
    public function getHistorico(): array
    {
        return $this->historico;
    }

    /**
     * Retorna estatísticas da execução
     * 
     * @return array
     */
    public function getEstatisticas(): array
    {
        return [
            'vetor_original' => $this->vetor,
            'total_comparacoes' => $this->totalComparacoes,
            'total_trocas' => $this->totalTrocas,
            'tamanho_vetor' => count($this->vetor)
        ];
    }

    /**
     * Retorna o vetor original
     * 
     * @return array
     */
    public function getVetorOriginal(): array
    {
        return $this->vetor;
    }

    /**
     * Reseta o algoritmo com um novo vetor
     * 
     * @param array $novoVetor
     * @return void
     */
    public function resetar(array $novoVetor): void
    {
        $this->vetor = $novoVetor;
        $this->historico = [];
        $this->totalTrocas = 0;
        $this->totalComparacoes = 0;
    }
}