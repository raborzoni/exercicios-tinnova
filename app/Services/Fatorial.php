<?php

namespace App\Services;

class Fatorial
{
    private array $historico;
    private int $totalOperacoes;

    public function __construct()
    {
        $this->historico = [];
        $this->totalOperacoes = 0;
    }

    /**
     * Calcula fatorial usando método iterativo
     * 
     * @param int $numero
     * @param bool $mostrarPassos
     * @return array
     */
    public function calcularIterativo(int $numero, bool $mostrarPassos = false): array
    {
        $this->resetar();
        
        if ($numero < 0) {
            return [
                'erro' => true,
                'mensagem' => 'Fatorial não é definido para números negativos',
                'numero' => $numero,
                'resultado' => null
            ];
        }

        if ($mostrarPassos) {
            $this->historico[] = [
                'tipo' => 'inicio',
                'numero' => $numero,
                'mensagem' => "Calculando {$numero}! (método iterativo)"
            ];
        }

        if ($numero === 0 || $numero === 1) {
            if ($mostrarPassos) {
                $this->historico[] = [
                    'tipo' => 'caso_especial',
                    'numero' => $numero,
                    'resultado' => 1,
                    'mensagem' => "{$numero}! = 1 (definição matemática)"
                ];
            }
            return [
                'erro' => false,
                'numero' => $numero,
                'resultado' => 1,
                'metodo' => 'iterativo',
                'operacoes' => 0,
                'historico' => $this->historico
            ];
        }

        $resultado = 1;
        $operacoes = [];

        if ($mostrarPassos) {
            $this->historico[] = [
                'tipo' => 'explicacao',
                'numero' => $numero,
                'mensagem' => "{$numero}! = " . implode(' × ', range(1, $numero))
            ];
        }

        for ($i = 1; $i <= $numero; $i++) {
            $valorAnterior = $resultado;
            $resultado *= $i;
            $this->totalOperacoes++;
            
            $operacoes[] = [
                'passo' => $i,
                'multiplicando' => $i,
                'valor_anterior' => $valorAnterior,
                'resultado_parcial' => $resultado
            ];

            if ($mostrarPassos) {
                $this->historico[] = [
                    'tipo' => 'passo',
                    'passo' => $i,
                    'operacao' => "{$valorAnterior} × {$i} = {$resultado}",
                    'resultado_parcial' => $resultado
                ];
            }
        }

        if ($mostrarPassos) {
            $this->historico[] = [
                'tipo' => 'resultado_final',
                'numero' => $numero,
                'resultado' => $resultado,
                'mensagem' => "Portanto, {$numero}! = {$resultado}"
            ];
        }

        return [
            'erro' => false,
            'numero' => $numero,
            'resultado' => $resultado,
            'metodo' => 'iterativo',
            'operacoes' => $this->totalOperacoes,
            'detalhes_operacoes' => $operacoes,
            'historico' => $this->historico
        ];
    }


    /**
     * Método recursivo interno
     * 
     * @param int $n
     * @param bool $mostrarPassos
     * @return int
     */
    private function fatorialRecursivoInterno(int $n, bool $mostrarPassos = false): int
    {
        if ($n === 0 || $n === 1) {
            if ($mostrarPassos) {
                $this->historico[] = [
                    'tipo' => 'caso_base',
                    'numero' => $n,
                    'resultado' => 1,
                    'mensagem' => "Caso base: {$n}! = 1"
                ];
            }
            return 1;
        }

        $this->totalOperacoes++;
        
        if ($mostrarPassos) {
            $this->historico[] = [
                'tipo' => 'chamada_recursiva',
                'numero' => $n,
                'mensagem' => "Calculando: {$n}! = {$n} × " . ($n-1) . "!"
            ];
        }

        $resultadoRecursivo = $this->fatorialRecursivoInterno($n - 1, $mostrarPassos);
        $resultado = $n * $resultadoRecursivo;

        if ($mostrarPassos) {
            $this->historico[] = [
                'tipo' => 'retorno_recursivo',
                'numero' => $n,
                'operacao' => "{$n} × {$resultadoRecursivo} = {$resultado}",
                'resultado' => $resultado
            ];
        }

        return $resultado;
    }

    /**
     * Executa os testes do exercício
     * 
     * @return array
     */
    public function executarTestes(): array
    {
        $numerosTesteDosExercicios = [0, 1, 2, 3, 4, 5, 6];
        $resultadosEsperados = [1, 1, 2, 6, 24, 120, 720];
        
        $testes = [];
        
        foreach ($numerosTesteDosExercicios as $index => $numero) {
            $resultado = $this->calcularIterativo($numero, false);
            $esperado = $resultadosEsperados[$index];
            $passou = $resultado['resultado'] === $esperado;
            
            $testes[] = [
                'numero' => $numero,
                'resultado_obtido' => $resultado['resultado'],
                'resultado_esperado' => $esperado,
                'passou_no_teste' => $passou,
                'expressao' => "{$numero}! = {$resultado['resultado']}"
            ];
        }
        
        return [
            'todos_os_testes_passaram' => !in_array(false, array_column($testes, 'passou_no_teste')),
            'testes_individuais' => $testes
        ];
    }

    /**
     * Reseta o histórico e contadores
     */
    private function resetar(): void
    {
        $this->historico = [];
        $this->totalOperacoes = 0;
    }

    /**
     * Retorna informações sobre fatorial
     * 
     * @return array
     */
    public function getInformacoes(): array
    {
        return [
            'definicao' => 'Fatorial de n é o produto de todos os números naturais de 1 até n',
            'notacao' => 'n!',
            'casos_especiais' => [
                '0! = 1 (produto vazio)',
                '1! = 1 (produto de um elemento)'
            ],
            'formula_recursiva' => 'n! = n × (n-1)!',
            'exemplos' => [
                '5! = 1 × 2 × 3 × 4 × 5 = 120',
                '0! = 1',
                '1! = 1'
            ]
        ];
    }
}