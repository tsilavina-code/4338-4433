-- ============================================================
-- base.sql
-- Mobile Money - Version 1 + Version 2
-- Opérateur : Yas
-- ============================================================

-- 1. SUPPRESSION PROPRE
DROP VIEW IF EXISTS v_gains;
DROP VIEW IF EXISTS v_comptes;
DROP TABLE IF EXISTS transaction_recipients;
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS clients;
DROP TABLE IF EXISTS fees;
DROP TABLE IF EXISTS commissions;
DROP TABLE IF EXISTS operations;
DROP TABLE IF EXISTS prefixes;

-- 2. TABLES

-- Préfixes des opérateurs
-- is_our_operator : 1 = Yas (notre opérateur), 0 = autre opérateur
CREATE TABLE prefixes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefix TEXT NOT NULL UNIQUE,
    operator TEXT NOT NULL,
    is_our_operator INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Types d'opérations
CREATE TABLE operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code TEXT NOT NULL UNIQUE,
    name TEXT NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Barèmes de frais par tranche de montant (modifiable)
CREATE TABLE fees (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    operation_id INTEGER NOT NULL,
    min_amount REAL NOT NULL,
    max_amount REAL NOT NULL,
    fee_amount REAL NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (operation_id) REFERENCES operations(id)
);

-- Commissions pour transferts vers autres opérateurs (V2)
-- Les opérateurs ici correspondent aux préfixes qui seront ajoutés en V2
CREATE TABLE commissions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    operator TEXT NOT NULL UNIQUE,
    percentage REAL NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Comptes clients (uniquement numéros Yas)
CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    phone TEXT NOT NULL UNIQUE,
    balance REAL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Transactions
-- include_withdraw_fee : 1 = frais de retrait prépayés par l'émetteur (V2)
-- is_multiple : 1 = envoi vers plusieurs numéros (V2)
-- commission : frais vers autre opérateur (V2)
CREATE TABLE transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id INTEGER NOT NULL,
    type TEXT NOT NULL,
    amount REAL NOT NULL,
    fee REAL DEFAULT 0,
    commission REAL DEFAULT 0,
    total REAL NOT NULL,
    recipient TEXT,
    include_withdraw_fee INTEGER DEFAULT 0,
    is_multiple INTEGER DEFAULT 0,
    balance_before REAL,
    balance_after REAL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

-- Destinataires pour envoi multiple (V2)
CREATE TABLE transaction_recipients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    transaction_id INTEGER NOT NULL,
    recipient_phone TEXT NOT NULL,
    amount REAL NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (transaction_id) REFERENCES transactions(id)
);

-- 3. DONNÉES INITIALES

-- Préfixes : seulement Yas au départ, les autres seront ajoutés via l'admin en V2
INSERT INTO prefixes (prefix, operator, is_our_operator) VALUES 
('034', 'Yas', 1),
('038', 'Yas', 1);

-- Types d'opérations
INSERT INTO operations (code, name, description) VALUES 
('DEPOT', 'Depot', 'Depot d''argent'),
('RETRAIT', 'Retrait', 'Retrait d''argent'),
('TRANSFERT', 'Transfert', 'Transfert vers un autre numero');

-- Barèmes de frais : RETRAIT
INSERT INTO fees (operation_id, min_amount, max_amount, fee_amount) VALUES 
((SELECT id FROM operations WHERE code = 'RETRAIT'), 0, 5000, 100),
((SELECT id FROM operations WHERE code = 'RETRAIT'), 5001, 20000, 300),
((SELECT id FROM operations WHERE code = 'RETRAIT'), 20001, 100000, 500),
((SELECT id FROM operations WHERE code = 'RETRAIT'), 100001, 999999999, 1000);

-- Barèmes de frais : TRANSFERT
INSERT INTO fees (operation_id, min_amount, max_amount, fee_amount) VALUES 
((SELECT id FROM operations WHERE code = 'TRANSFERT'), 0, 10000, 200),
((SELECT id FROM operations WHERE code = 'TRANSFERT'), 10001, 999999999, 500);

-- Commissions pour autres opérateurs (seront utilisés quand les préfixes seront ajoutés en V2)
INSERT INTO commissions (operator, percentage) VALUES 
('Orange', 2.0),
('Airtel', 1.5);

-- Clients test (uniquement Yas)
INSERT INTO clients (phone, balance) VALUES 
('0341111111', 50000),
('0382222222', 25000),
('0343333333', 100000);