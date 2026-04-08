<?php

namespace Database\Seeders;

use App\Models\AuditType;
use Illuminate\Database\Seeder;

class AuditTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $auditTypes = [
            ['code' => 'create', 'label' => 'Création'],
            ['code' => 'update', 'label' => 'Modification'],
            ['code' => 'delete', 'label' => 'Suppression'],
            ['code' => 'read', 'label' => 'Lecture'],
            ['code' => 'login', 'label' => 'Connexion'],
            ['code' => 'logout', 'label' => 'Déconnexion'],
            ['code' => 'download', 'label' => 'Téléchargement'],
            ['code' => 'export', 'label' => 'Exportation'],
            ['code' => 'import', 'label' => 'Importation'],
            ['code' => 'other', 'label' => 'Autre'],
        ];

        foreach ($auditTypes as $type) {
            AuditType::firstOrCreate(
                ['code' => $type['code']],
                ['label' => $type['label']]
            );
        }
    }
}
