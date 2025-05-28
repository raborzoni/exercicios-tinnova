<?php

namespace App\Services;

class SomaMultiplos
{
    private array $historico;
    private array $multiplosEncontrados;
    private int $totalOperacoes;

    public function __construct()
    {
        $this->historico = [];
        $this->multiplosEncontrados = [];
        $this->totalOperacoes = 0;
    }

    /**
     * Calcula a soma dos múltiplos de 3 ou 5 abaixo de um número X
     * Método iterativo (força bruta)
     * 
     * @param int $numero
     * @param bool $mostrarPassos
     * @return array
     */
    public function calcularIterativo(int $numero, bool $mostrarPassos = false): array
    {
        $this->resetar();
        
        // Validação
        if ($numero <= 0) {
            return [
                'erro' => true,
                'mensagem' => 'O numero deve ser um número positivo maior que 0',
                'numero' => $numero,
                'resultado' => null
            ];
        }

        if ($mostrarPassos) {
            $this->historico[] = [
                'tipo' => 'inicio',
                'numero' => $numero,
                'mensagem' => "Buscando múltiplos de 3 ou 5 abaixo de {$numero}"
            ];
        }

        $soma = 0;
        $multiplos = [];

        // Percorre todos os números de 1 até numero-1
        for ($i = 1; $i < $numero; $i++) {
            $this->totalOperacoes++;
            
            $isMultiploDe3 = ($i % 3 === 0);
            $isMultiploDe5 = ($i % 5 === 0);
            
            if ($isMultiploDe3 || $isMultiploDe5) {
                $multiplos[] = $i;
                $soma += $i;
                
                $tipoMultiplo = [];
                if ($isMultiploDe3) $tipoMultiplo[] = '3';
                if ($isMultiploDe5) $tipoMultiplo[] = '5';
                
                if ($mostrarPassos) {
                    $this->historico[] = [
                        'tipo' => 'multiplo_encontrado',
                        'numero' => $i,
                        'multiplo_de' => $tipoMultiplo,
                        'soma_parcial' => $soma,
                        'mensagem' => "{$i} é múltiplo de " . implode(' e ', $tipoMultiplo) . " | Soma parcial: {$soma}"
                    ];
                }
            } else if ($mostrarPassos && $numero <= 20) {
                // Só mostra números que não são múltiplos se o numero for pequeno
                $this->historico[] = [
                    'tipo' => 'nao_multiplo',
                    'numero' => $i,
                    'mensagem' => "{$i} não é múltiplo de 3 nem de 5"
                ];
            }
        }

        $this->multiplosEncontrados = $multiplos;

        if ($mostrarPassos) {
            $this->historico[] = [
                'tipo' => 'resultado_final',
                'numero' => $numero,
                'multiplos' => $multiplos,
                'quantidade' => count($multiplos),
                'soma' => $soma,
                'mensagem' => "Múltiplos encontrados: [" . implode(', ', $multiplos) . "] | Soma total: {$soma}"
            ];
        }

        return [
            'erro' => false,
            'numero' => $numero,
            'multiplos_encontrados' => $multiplos,
            'quantidade_multiplos' => count($multiplos),
            'soma_total' => $soma,
            'metodo' => 'iterativo',
            'operacoes' => $this->totalOperacoes,
            'historico' => $this->historico
        ];
    }

    /**
     * Calcula usando fórmula matemática (mais eficiente)
     * Usa a fórmula da soma de PA: S = n * (primeiro + último) / 2
     * 
     * @param int $numero
     * @param bool $mostrarPassos
     * @return array
     */
    public function calcularFormula(int $numero, bool $mostrarPassos = false): array
    {
        $this->resetar();
        
        if ($numero <= 0) {
            return [
                'erro' => true,
                'mensagem' => 'O numero deve ser um número positivo maior que 0',
                'numero' => $numero,
                'resultado' => null
            ];
        }

        if ($mostrarPassos) {
            $this->historico[] = [
                'tipo' => 'inicio_formula',
                'numero' => $numero,
                'mensagem' => "Calculando usando fórmula matemática (Progressão Aritmética)"
            ];
        }

        // Soma dos múltiplos de 3
        $somaDe3 = $this->somaMultiplos(3, $numero - 1, $mostrarPassos);
        
        // Soma dos múltiplos de 5  
        $somaDe5 = $this->somaMultiplos(5, $numero - 1, $mostrarPassos);
        
        // Soma dos múltiplos de 15 (3 e 5) - para evitar contar duas vezes
        $somaDe15 = $this->somaMultiplos(15, $numero - 1, $mostrarPassos);

        // Aplicar princípio da inclusão-exclusão
        $somaTotal = $somaDe3 + $somaDe5 - $somaDe15;

        if ($mostrarPassos) {
            $this->historico[] = [
                'tipo' => 'calculo_final',
                'soma_multiplos_3' => $somaDe3,
                'soma_multiplos_5' => $somaDe5,
                'soma_multiplos_15' => $somaDe15,
                'formula' => "Soma(3) + Soma(5) - Soma(15)",
                'calculo' => "{$somaDe3} + {$somaDe5} - {$somaDe15} = {$somaTotal}",
                'resultado' => $somaTotal,
                'mensagem' => "Princípio da inclusão-exclusão: removemos os múltiplos de 15 para não contar duas vezes"
            ];
        }

        return [
            'erro' => false,
            'numero' => $numero,
            'soma_total' => $somaTotal,
            'metodo' => 'formula_matematica',
            'detalhes' => [
                'soma_multiplos_3' => $somaDe3,
                'soma_multiplos_5' => $somaDe5,
                'soma_multiplos_15' => $somaDe15,
                'explicacao' => 'Soma(múltiplos de 3) + Soma(múltiplos de 5) - Soma(múltiplos de 15)'
            ],
            'operacoes' => 6, // Operações matemáticas básicas
            'historico' => $this->historico
        ];
    }

    /**
     * Calcula a soma dos múltiplos de um número usando fórmula de PA
     * 
     * @param int $multiplo
     * @param int $numero
     * @param bool $mostrarPassos
     * @return int
     */
    private function somaMultiplos(int $multiplo, int $numero, bool $mostrarPassos = false): int
    {
        if ($numero < $multiplo) {
            return 0;
        }

        // Quantos múltiplos existem até o numero
        $quantidade = intval($numero / $multiplo);
        
        // Soma usando fórmula da PA: S = n * (primeiro + último) / 2
        // primeiro = multiplo, último = multiplo * quantidade
        $primeiro = $multiplo;
        $ultimo = $multiplo * $quantidade;
        $soma = $quantidade * ($primeiro + $ultimo) / 2;

        if ($mostrarPassos) {
            $this->historico[] = [
                'tipo' => 'calculo_pa',
                'multiplo' => $multiplo,
                'numero' => $numero,
                'quantidade' => $quantidade,
                'primeiro' => $primeiro,
                'ultimo' => $ultimo,
                'formula' => "S = n × (primeiro + último) ÷ 2",
                'calculo' => "S = {$quantidade} × ({$primeiro} + {$ultimo}) ÷ 2 = {$soma}",
                'resultado' => $soma
            ];
        }

        return (int) $soma;
    }

    /**
     * Compara os dois métodos
     * 
     * @param int $numero
     * @return array
     */
    public function compararMetodos(int $numero): array
    {
        if ($numero <= 0) {
            return [
                'erro' => true,
                'mensagem' => 'O numero deve ser um número positivo maior que 0'
            ];
        }

        // Método iterativo
        $inicioIterativo = microtime(true);
        $resultadoIterativo = $this->calcularIterativo($numero, false);
        $tempoIterativo = microtime(true) - $inicioIterativo;

        // Método com fórmula
        $inicioFormula = microtime(true);
        $resultadoFormula = $this->calcularFormula($numero, false);
        $tempoFormula = microtime(true) - $inicioFormula;

        return [
            'numero' => $numero,
            'resultado' => $resultadoIterativo['soma_total'],
            'comparacao' => [
                'iterativo' => [
                    'resultado' => $resultadoIterativo['soma_total'],
                    'tempo_ms' => number_format($tempoIterativo * 1000, 4),
                    'operacoes' => $resultadoIterativo['operacoes'],
                    'complexidade' => 'O(n)',
                    'vantagens' => ['Fácil de entender', 'Mostra todos os múltiplos'],
                    'desvantagens' => ['Lento para números grandes']
                ],
                'formula' => [
                    'resultado' => $resultadoFormula['soma_total'],
                    'tempo_ms' => number_format($tempoFormula * 1000, 4),
                    'operacoes' => $resultadoFormula['operacoes'],
                    'complexidade' => 'O(1)',
                    'vantagens' => ['Muito rápido', 'Constante independente do tamanho'],
                    'desvantagens' => ['Mais complexo de entender']
                ]
            ],
            'recomendacao' => $numero > 1000 ? 'Use o método da fórmula para números grandes' : 'Ambos os métodos são adequados',
            'resultados_iguais' => $resultadoIterativo['soma_total'] === $resultadoFormula['soma_total']
        ];
    }

    /**
     * Executa o teste do exercício (múltiplos abaixo de 10)
     * 
     * @return array
     */
    public function executarTesteExercicio(): array
    {
        $numero = 10;
        $resultadoEsperado = 23; // 3 + 5 + 6 + 9 = 23
        $multiplosEsperados = [3, 5, 6, 9];

        $resultado = $this->calcularIterativo($numero, true);
        
        return [
            'teste_do_exercicio' => [
                'numero' => $numero,
                'multiplos_esperados' => $multiplosEsperados,
                'multiplos_encontrados' => $resultado['multiplos_encontrados'],
                'soma_esperada' => $resultadoEsperado,
                'soma_obtida' => $resultado['soma_total'],
                'teste_passou' => $resultado['soma_total'] === $resultadoEsperado && $resultado['multiplos_encontrados'] === $multiplosEsperados
            ],
            'detalhes' => $resultado
        ];
    }

    /**
     * Calcula para múltiplos valores de uma vez
     * 
     * @param array $numeros
     * @return array
     */
    public function calcularMultiplos(array $numeros): array
    {
        $resultados = [];
        
        foreach ($numeros as $numero) {
            if (!is_numeric($numero) || $numero <= 0) {
                $resultados[] = [
                    'numero' => $numero,
                    'erro' => true,
                    'mensagem' => 'numero inválido'
                ];
                continue;
            }
            
            $numero = (int) $numero;
            $resultado = $this->calcularIterativo($numero, false);
            $resultados[] = [
                'numero' => $numero,
                'soma' => $resultado['soma_total'],
                'multiplos' => $resultado['multiplos_encontrados'],
                'quantidade' => $resultado['quantidade_multiplos'],
                'erro' => false
            ];
        }
        
        return $resultados;
    }

    /**
     * Reseta os dados
     */
    private function resetar(): void
    {
        $this->historico = [];
        $this->multiplosEncontrados = [];
        $this->totalOperacoes = 0;
    }

    /**
     * Retorna informações sobre o problema
     * 
     * @return array
     */
    public function getInformacoes(): array
    {
        return [
            'problema' => 'Soma dos múltiplos de 3 ou 5 abaixo de um número X',
            'exemplo' => 'Múltiplos de 3 ou 5 abaixo de 10: [3, 5, 6, 9] → Soma = 23',
            'metodos' => [
                'iterativo' => 'Percorre todos os números verificando se são múltiplos',
                'formula' => 'Usa fórmula de progressão aritmética (muito mais rápido)'
            ],
            'conceitos' => [
                'Múltiplo de 3: número divisível por 3 (resto da divisão = 0)',
                'Múltiplo de 5: número divisível por 5 (resto da divisão = 0)',
                'Princípio inclusão-exclusão: evita contar múltiplos de 15 duas vezes'
            ]
        ];
    }
}