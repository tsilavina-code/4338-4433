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


### Cote operateur:4433:TSILAVINA

Architecture & Base de Données :

- Initialisation et configuration des 5 modèles partagés ('PrefixModel', 'OperationModel', 'FeeModel', 'ClientModel', 'TransactionModel') adaptés au schéma SQLite final.
- Structuration et isolation complète des routes administratives via un groupe avec namespace dédié dans 'app/Config/Routes.php'.

Fonctionnalités Backend & Frontend (Espace Admin) :

- Gestion des préfixes : Création du contrôleur 'Prefixes.php' et de la vue associée permettant d'afficher les préfixes valides en base, d'en ajouter de nouveaux (avec leur nom d'opérateur associé) et de les supprimer.
- Gestion des barèmes de frais : Création du contrôleur 'Fees.php' et d'une interface dynamique permettant de lister et de modifier directement en base les tranches de montants minimum, maximum ainsi que les frais associés pour chaque type d'opération.
- Situation des comptes clients : Création du contrôleur 'Comptes.php' et d'un tableau de bord listant en temps réel tous les clients créés dans le système, affichant leur numéro de téléphone, leur solde actuel et leur date d'inscription.
- Situation des gains : Création du contrôleur 'Gains.php' exploitant des requêtes d'agrégation SQL (`SUM`) pour afficher le montant total des frais perçus par l'opérateur, ainsi qu'une table de répartition des gains par type de transaction (retraits et transferts).




### Cote client :4338:Magy
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