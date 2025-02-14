<?php

namespace App\Interfaces;

use App\Entity\Candidat;

interface CandidatCompletionCalculatorInterface
{
    public function calculateCompletion(Candidat $candidat) : int;
}