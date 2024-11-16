-- Insert sample roles (Admin, Manager, Worker)
INSERT INTO roles (name) VALUES
('Administrador'),
('Gerente'),
('Trabajador');

-- Insert sample workers (Spanish users)
INSERT INTO workers (company, name, dni, password, email, role_id, created_at, updated_at, deleted_at) VALUES
('TechCorp', 'Carlos García', '12345678A', 'hashedpassword1', 'carlos.garcia@example.com', 1, NOW(), NOW(), NULL), -- Admin
('InnovaTech', 'Ana Martínez', '23456789B', 'hashedpassword2', 'ana.martinez@example.com', 2, NOW(), NOW(), NULL), -- Manager
('DesignWorks', 'José Rodríguez', '34567890C', 'hashedpassword3', 'jose.rodriguez@example.com', 3, NOW(), NOW(), NULL); -- Worker

-- Insert sample tree types
INSERT INTO tree_types (family, genus, species) VALUES
('Fagaceae', 'Quercus', 'Quercus robur'),
('Pinaceae', 'Pinus', 'Pinus sylvestris'),
('Sapindaceae', 'Acer', 'Acer campestre');

-- Insert sample contracts
INSERT INTO contracts (name, start_date, end_date, invoice_proposed, invoice_agreed, invoice_paid) VALUES
('Ayuntamiento de Valencia', '2021-01-01', '2021-12-31', 1000.00, 900.00, 900.00),
('Administración General del Estado', '2021-01-01', '2021-12-31', 2000.00, 1800.00, 1800.00),
('Ayuntamiento de Carlet', '2021-01-01', '2021-12-31', 3000.00, 2700.00, 2700.00);

-- Insert sample task types
INSERT INTO task_types (name) VALUES
('Abono arbustos'),
('Podar setos'),
('Abono setos');

-- Insert sample pruning types
INSERT INTO pruning_types (name, description) VALUES
('A', 'Poda de mantenimiento en árbol tipo A, caduco, de p.c. entre 41/80 cm.'),
('B', 'Poda de mantenimiento en árbol tipo B, caduco, de p.c. mayor de 81 cm.'),
('C', 'Poda de mantenimiento en árbol tipo C, perenne, de p.c. entre 41/60 cm.');

-- Insert sample points
INSERT INTO points (latitude, longitude) VALUES
(40.416775, -3.703790),
(40.416776, -3.703795),
(40.416777, -3.703800);
