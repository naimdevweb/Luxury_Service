<?php
namespace App\DTO;

class OffreWithCountDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $titre,
        public readonly float $salaire,
        public readonly \DateTimeInterface $created_at,
        public readonly string $description,
        public readonly string $categorieNom
    ) {
    }
}