configuration de la base :
-mkdir -p writable/database
-verifier si existe :ls writable/
-exécuter le Seeder:php spark db:seed DatabaseSeeder
-vérifier que le fichier .db est créé:ls writable/database/
  Voir les tables
sqlite3 writable/database/mobile_money.db ".tables"

Réinitialiser (iz koa sendra magnova base.sql):
-Supprime l'ancienne base
rm writable/database/mobile_money.db

-Recrée tout
php spark db:seed DatabaseSeeder


### Cote operateur:4433:TSILAVINA(v1)

Architecture & Base de Données (v1)

- Initialisation et configuration des 5 modèles partagés ('PrefixModel', 'OperationModel', 'FeeModel', 'ClientModel', 'TransactionModel') adaptés au schéma SQLite final.
- Structuration et isolation complète des routes administratives via un groupe avec namespace dédié dans 'app/Config/Routes.php'.

Fonctionnalités Backend & Frontend (Espace Admin) (v1)

- Gestion des préfixes : Création du contrôleur 'Prefixes.php' et de la vue associée permettant d'afficher les préfixes valides en base, d'en ajouter de nouveaux (avec leur nom d'opérateur associé) et de les supprimer.
- Gestion des barèmes de frais : Création du contrôleur 'Fees.php' et d'une interface dynamique permettant de lister et de modifier directement en base les tranches de montants minimum, maximum ainsi que les frais associés pour chaque type d'opération.
- Situation des comptes clients : Création du contrôleur 'Comptes.php' et d'un tableau de bord listant en temps réel tous les clients créés dans le système, affichant leur numéro de téléphone, leur solde actuel et leur date d'inscription.
- Situation des gains : Création du contrôleur 'Gains.php' exploitant des requêtes d'agrégation SQL ('SUM') pour afficher le montant total des frais perçus par l'opérateur, ainsi qu'une table de répartition des gains par type de transaction (retraits et transferts).

### Cote operateur(V2)

1. Structure & Données de Configuration ('base.sql')
* Modification / Ajout : 
  * Création de la table 'commissions' pour stocker le pourcentage de surtaxe ('2.0%' pour Orange et Airtel).
  * Ajout de la colonne 'is_our_operator' dans la table 'prefixes' pour distinguer dynamiquement notre réseau des réseaux tiers.
  * Ajout des colonnes 'commission' (revenus externes) et 'recipient' (numéro destinataire) dans la table 'transactions'.
  * Insertion des préfixes initiaux ('032', '033') et des règles de routage pour la simulation.

2. Logique de Calcul des Flux ('app/Controllers/Admin/Gains.php')
* Modification :
  * Refonte complète de la méthode 'index()' pour isoler les deux flux de revenus demandés.
  * Écriture de la requête SQL de séparation des gains : sommation de la colonne 'fee' (si interne) d'un côté, et de la colonne 'commission' (si externe) de l'autre.
  * Intégration d'une requête avec jointure ('JOIN') et extraction de chaîne ('SUBSTR(recipient, 1, 3)') pour calculer et grouper dynamiquement le montant global cumulé des transactions à reverser à chaque opérateur externe.

3. Interface d'Administration V2 ('app/Views/admin/gains.php')
* Modification :
  * Suppression de l'ancienne logique V1 pour implémenter la séparation stricte visuelle des profits (Gains Internes vs Commissions Externes vs Total Global).
  * Création du tableau de compensation indiquant de manière transparente la situation financière vis-à-vis des autres opérateurs (Montant total à envoyer et commissions générées par réseau).

4. Modèle de Persistance ('app/Models/TransactionModel.php')
* Modification :
  * Mise à jour du tableau '$allowedFields' pour inclure les champs 'commission' et 'recipient', indispensables pour que l'application puisse enregistrer et traiter les données transactionnelles inter-opérateurs.



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




Corrections 

- base.sql : ajout champ is_our_operator dans prefixes
- PrefixModel : ajout méthode isOurOperator()
- Auth.php : blocage login si numéro pas Yas (is_our_operator = 0)
- login.php : message "Seuls les numéros Yas peuvent se connecter"
- login.php : lien vers espace opérateur


V2


- Transfert vers tous les opérateurs
  - Yas → Yas : frais normaux
  - Yas → Orange/Airtel : + commission

-  Commission inter-opérateurs
  - CommissionModel : récupérer % commission
  - 2% pour tous les opérateurs externes

-  Option "Inclure frais de retrait"
  - Checkbox dans le formulaire
  - Si coché : émetteur paie aussi les frais de retrait du destinataire
  - Destinataire retire gratuitement

-  Envoi multiple
  - Bouton "Ajouter un destinataire"
  - Champs dynamiques avec JavaScript
  - Liste déroulante des numéros existants
  - Option "Autre numéro" pour saisie manuelle
  - Montant total divisé équitablement
  - Récapitulatif auto avant confirmation

-  Interface transfert clarifiée
  - Étape 1 : Choisir destinataires
  - Étape 2 : Montant total
  - Étape 3 : Options
  - Récapitulatif avec total à débiter

-  TransactionRecipientModel
  - Table transaction_recipients
  - Stocke chaque destinataire d'un envoi multiple




fichiers modifier :
Routes.php:admin point entre
modifie les controllers de Client pour utiliser cette routes ci :    return redirect()->to('/client/login');

fichiers et dossier creer:
includes/footer.php,navbar_admin.php et navbar_client.php puis les vue qui utilise ces includes on ceci :
<?= $this->include('includes/navbar_client') ?> pour le navbar client 
<?= $this->include('includes/navbar_admin') ?> pour le navbar admin
$active_page mis dans les controllers Prefixes, Fees, Comptes, Gains
Création Commissions.php (contrôleur) avec actions : index, ajouter, supprimer
Création commissions.php (vue) avec formulaire pour configurer les % par opérateur
Ajout  routes dans Routes.php (/admin/commissions)
Ajout lien "Commissions" dans la navbar admin entre Préfixes et Barèmes Frais

modif css client et admin pour animation et aggrandissement des cards



alea:
promotion pour les commission du frais de transfert vers le meme operateur