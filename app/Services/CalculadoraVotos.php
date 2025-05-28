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