configuration de la base :
-mkdir -p writable/database
-verifier si existe :ls writable/
-exécuter le Seeder:php spark db:seed DatabaseSeeder
-vérifier que le fichier .db est créé:ls writable/database/
  Voir les tables
sqlite3 writable/database/mobile_money.db ".tables"

-Voir le contenu de chaque table 
SELECT * FROM prefixes;
SELECT * FROM operations;
SELECT * FROM fees;
SELECT * FROM clients;

Réinitialiser (iz koa sendra magnova base.sql):
-Supprime l'ancienne base
rm writable/database/mobile_money.db

-Recrée tout
php spark db:seed DatabaseSeeder


Cote operateur:4433:TSILAVINA




Cote client :4338:Magy