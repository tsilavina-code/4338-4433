<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Chemin vers base.sql à la racine du projet
        $sqlFile = ROOTPATH . 'base.sql';
        
        // Vérifie que le fichier existe
        if (!file_exists($sqlFile)) {
            throw new \Exception("Fichier base.sql introuvable : " . $sqlFile);
        }
        
        // Lit le contenu
        $sql = file_get_contents($sqlFile);
        
        // Split par point-virgule (SQLite ne supporte pas multi-requêtes)
        $queries = array_filter(array_map('trim', explode(';', $sql)));
        
        $db = $this->db;
        
        foreach ($queries as $query) {
            if (!empty($query)) {
                $db->query($query);
            }
        }
        
        echo "✅ Base initialisée avec succès depuis base.sql\n";
    }
}