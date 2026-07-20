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
Base de données SQLite 
  - Fichier base.sql à la racine
  - Tables : prefixes, operations, fees, clients, transactions

- Config CodeIgniter 4 + SQLite
  - Database.php : DBDriver = SQLite3
  - .env : environnement development
  - Seeder pour créer la base

-  Models
  - ClientModel : chercher client, créer client, changer solde
  - FeeModel : calculer frais selon montant
  - TransactionModel : historique des transactions
  - PrefixModel : vérifier si numéro valide
  - OperationModel : types d'opérations

-  Login automatique
  - Page avec champ numéro téléphone
  - Pas de mot de passe
  - Si numéro existe → connecté
  - Si numéro nouveau → compte créé auto (solde = 0)
  - Si mauvais préfixe → erreur

Voir le solde
  - Dashboard avec solde et numéro
  - Menu : Dépôt, Retrait, Transfert, Historique

-  Faire un dépôt
  - Formulaire montant
  - Montant positif obligatoire
  - Pas de frais
  - Solde augmente directement

-  Faire un retrait
  - Formulaire montant
  - Frais calculés selon barème
  - Vérifie solde suffisant
  - Solde diminue (montant + frais)

-  Faire un transfert
  - Formulaire : numéro destinataire + montant
  - Vérifie numéro destinataire valide
  - Empêche transfert vers soi-même
  - Frais calculés selon barème
  - Vérifie solde suffisant
  - Destinataire reçoit montant complet


Voir historique
  - Tableau avec toutes les transactions
  - Date, type, montant, frais, total, destinataire, solde après

-  Design
  - Fichier CSS séparé : public/css/client.css
  - Couleurs : bleu marine, gris, blanc
  - Pas flashy
  - Responsive (marche sur téléphone)

-  Sécurité
  - Vérifie connexion sur toutes les pages
  - Redirige vers login si pas connecté
  - Vérifie montant positif
  - Empêche transfert vers soi-même