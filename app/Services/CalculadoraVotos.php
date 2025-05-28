<?php

namespace App\Services;

class CalculadoraVotos
{
    private int $totalEleitores;
    private int $votosValidos;
    private int $votosBrancos;
    private int $votosNulos;

    public function __construct(int $totalEleitores, int $votosValidos, int $votosBrancos, int $votosNulos)
    {
        $this->totalEleitores = $totalEleitores;
        $this->votosValidos = $votosValidos;
        $this->votosBrancos = $votosBrancos;
        $this->votosNulos = $votosNulos;
    }

    /**
     * Calcula o percentual de votos válidos em relação ao total de eleitores
     * 
     * @return float
     */
    public function percentualVotosValidos(): float
    {
        if ($this->totalEleitores == 0) {
            return 0;
        }
        
        return ($this->votosValidos / $this->totalEleitores) * 100;
    }

    /**
     * Calcula o percentual de votos brancos em relação ao total de eleitores
     * 
     * @return float
     */
    public function percentualVotosBrancos(): float
    {
        if ($this->totalEleitores == 0) {
            return 0;
        }
        
        return ($this->votosBrancos / $this->totalEleitores) * 100;
    }

    /**
     * Calcula o percentual de votos nulos em relação ao total de eleitores
     * 
     * @return float
     */
    public function percentualVotosNulos(): float
    {
        if ($this->totalEleitores == 0) {
            return 0;
        }
        
        return ($this->votosNulos / $this->totalEleitores) * 100;
    }

    // Métodos getters para acessar os valores (opcional)
    public function getTotalEleitores(): int
    {
        return $this->totalEleitores;
    }

    public function getVotosValidos(): int
    {
        return $this->votosValidos;
    }

    public function getVotosBrancos(): int
    {
        return $this->votosBrancos;
    }

    public function getVotosNulos(): int
    {
        return $this->votosNulos;
    }
}

// Exemplo de uso:
/*
$calculadora = new CalculadoraVotos(1000, 800, 150, 50);

echo "Percentual de votos válidos: " . number_format($calculadora->percentualVotosValidos(), 2) . "%\n";
echo "Percentual de votos brancos: " . number_format($calculadora->percentualVotosBrancos(), 2) . "%\n";
echo "Percentual de votos nulos: " . number_format($calculadora->percentualVotosNulos(), 2) . "%\n";

// Resultado esperado:
// Percentual de votos válidos: 80.00%
// Percentual de votos brancos: 15.00%
// Percentual de votos nulos: 5.00%
*/