<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $sqlFile = ROOTPATH . 'base.sql';
        
        if (!file_exists($sqlFile)) {
            throw new \Exception("Fichier base.sql introuvable : " . $sqlFile);
        }
        
        $sql = file_get_contents($sqlFile);
        
        // Supprime TOUS les commentaires SQL (--)
        $sql = preg_replace('/--.*$/m', '', $sql);
        
        // Supprime les lignes vides multiples
        $sql = preg_replace("/[\r\n]+/", "\n", $sql);
        
        // Split par ; et exécute
        $queries = array_filter(array_map('trim', explode(';', $sql)));
        
        $db = $this->db;
        
        foreach ($queries as $query) {
            if (!empty($query)) {
                try {
                    $db->query($query);
                } catch (\Exception $e) {
                    // Ignore "not an error" qui est un faux positif SQLite
                    if (strpos($e->getMessage(), 'not an error') === false) {
                        throw $e;
                    }
                }
            }
        }
        
        echo " Base initialisée avec succès depuis base.sql\n";
    }
}