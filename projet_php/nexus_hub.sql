CREATE DATABASE IF NOT EXISTS nexus_hub
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
 
USE nexus_hub;
 
CREATE TABLE IF NOT EXISTS collaborateurs (
    id    INT          NOT NULL AUTO_INCREMENT,
    nom   VARCHAR(100) NOT NULL,
    age   TINYINT      NOT NULL,
    role  VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 
-- Données de démonstration IGNORE sert a ignorer la query si les données existe deja
INSERT IGNORE INTO collaborateurs (nom, age, role) VALUES
    ('Alice Martin',   32, 'Développeur'),
    ('Bob Dupont',     45, 'Directeur'),
    ('Clara Petit',    28, 'Designer'),
    ('David Moreau',   38, 'Chef de projet'),
    ('Emma Lefebvre',  24, 'Développeur');
 