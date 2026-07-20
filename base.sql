-- ============================================================
-- base.sql
-- Mobile Money - Version 1
-- ============================================================

-- 1. SUPPRESSION PROPRE
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS clients;
DROP TABLE IF EXISTS fees;
DROP TABLE IF EXISTS operations;
DROP TABLE IF EXISTS prefixes;

-- 2. TABLES

CREATE TABLE prefixes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefix TEXT NOT NULL UNIQUE,
    operator TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code TEXT NOT NULL UNIQUE,
    name TEXT NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE fees (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    operation_id INTEGER NOT NULL,
    min_amount REAL NOT NULL,
    max_amount REAL NOT NULL,
    fee_amount REAL NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (operation_id) REFERENCES operations(id)
);

CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    phone TEXT NOT NULL UNIQUE,
    balance REAL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id INTEGER NOT NULL,
    type TEXT NOT NULL,
    amount REAL NOT NULL,
    fee REAL DEFAULT 0,
    total REAL NOT NULL,
    recipient TEXT,
    balance_before REAL,
    balance_after REAL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

-- 3. DONNEES INITIALES

-- Préfixes opérateurs
INSERT INTO prefixes (prefix, operator) VALUES 
('032', 'Orange'),
('037', 'Orange'),
('034', 'Telma'),
('038', 'Telma'),
('033', 'Airtel'),
('035', 'Airtel');

-- Types d'opérations
INSERT INTO operations (code, name, description) VALUES 
('DEPOT', 'Depot', 'Depot d''argent'),
('RETRAIT', 'Retrait', 'Retrait d''argent'),
('TRANSFERT', 'Transfert', 'Transfert vers un autre numero');

-- Frais RETRAIT
INSERT INTO fees (operation_id, min_amount, max_amount, fee_amount) VALUES 
((SELECT id FROM operations WHERE code = 'RETRAIT'), 0, 5000, 100),
((SELECT id FROM operations WHERE code = 'RETRAIT'), 5001, 20000, 300),
((SELECT id FROM operations WHERE code = 'RETRAIT'), 20001, 100000, 500),
((SELECT id FROM operations WHERE code = 'RETRAIT'), 100001, 999999999, 1000);

-- Barèmes de frais : TRANSFERT
INSERT INTO fees (operation_id, min_amount, max_amount, fee_amount) VALUES 
((SELECT id FROM operations WHERE code = 'TRANSFERT'), 0, 10000, 200),
((SELECT id FROM operations WHERE code = 'TRANSFERT'), 10001, 999999999, 500);


-- Clients test (un par préfixe)
INSERT INTO clients (phone, balance) VALUES 
('0331234567', 50000),   -- Airtel 033
('0357654321', 25000),   -- Airtel 035
('0321111111', 100000),  -- Orange 032
('0372222222', 75000),   -- Orange 037
('0343333333', 30000),   -- Telma 034
('0384444444', 60000);   -- Telma 038