<?php

namespace App\Services;


use App\Entity\Candidat;
use App\Attribute\ProfileCompletion;
use Countable;
use ReflectionClass;
use App\Interfaces\CandidatCompletionCalculatorInterface;


class CandidateCompletionCalculator implements CandidatCompletionCalculatorInterface {

    private ReflectionClass $reflection;


    public function calculateCompletion(Candidat $candidat) : int {

        // On crée un réflecteur de la classe $candidate, qui reflète, cad il permet de voir ce qu'il y a dans la classe sans vrm la toucher.
        $this->reflection = new ReflectionClass($candidat);

        // On récupère toutes les propriétés de la classe
        $properties = $this->reflection->getProperties();

        $totalFields = 0;
        $filledCount = 0;


        foreach ($properties as $property) {

            // On récupère l'attribut #[ProfileCompletion]
            $attributes = $property->getAttributes(ProfileCompletion::class);

            // Si la propriété ProfileCompletion existe bien dans notre propriété
            if (!empty($attributes)) {
                $totalFields++;

                // On rend la propriété accessible pour voir ce qui'l y a a l'intérieur
                $property->setAccessible(true);
                $value = $property->getValue($candidat);

                // Si la propriété a quelquechose a l'intérieur. On incrémente filledCount
                if ($this->isFieldCompleted($value)) {
                    $filledCount++;
                }
            }
        }


        // Ternary operator to remove dividing by zero
        $completionPercentage = $totalFields > 0 ? (int) round($filledCount / $totalFields * 100) : 0;

        return $completionPercentage;
    }


    private function  isFieldCompleted($value): bool {

        if ($value === null) {
            return false;
        }

        if (is_string($value) && trim($value) === '') {
            return false;
        }

        if (is_array($value) && empty($value)) {
            return false;
        }

        if ($value instanceof Countable && count($value) === 0) {
            return false;
        }

        return true;
    }


}






?>