--* Roles, users, contracts and machines
INSERT INTO roles (name) VALUES
('Administrador'),
('Gerente'),
('Trabajador');
INSERT INTO workers (company, name, dni, password, email, role_id) VALUES
('TechCorp', 'Carlos García', '12345678A', 'hashedpassword1', 'carlos.garcia@example.com', 1),
('InnovaTech', 'Ana Martínez', '23456789B', 'hashedpassword2', 'ana.martinez@example.com', 2),
('DesignWorks', 'José Rodríguez', '34567890C', 'hashedpassword3', 'jose.rodriguez@example.com', 3);
INSERT INTO contracts (name, start_date, end_date, invoice_proposed, invoice_agreed, invoice_paid) VALUES
('Ayuntamiento de Valencia', '2021-01-01', '2021-12-31', 1000.00, 900.00, 900.00),
('Administración General del Estado', '2021-01-01', '2021-12-31', 2000.00, 1800.00, 1800.00),
('Ayuntamiento de Carlet', '2021-01-01', '2021-12-31', 3000.00, 2700.00, 2700.00);
INSERT INTO machines (name, max_basket_size) VALUES
('Cesta elevadora', 200.00),
('Plataforma elevadora', 300.00),
('Tijera elevadora', 400.00);
--* Tree, task and pruning types
INSERT INTO tree_types (family, genus, species) VALUES
('Fagaceae', 'Quercus', 'Quercus robur'),
('Pinaceae', 'Pinus', 'Pinus sylvestris'),
('Sapindaceae', 'Acer', 'Acer campestre');
INSERT INTO task_types (name) VALUES
('Abono arbustos'),
('Podar setos'),
('Abono setos');
INSERT INTO pruning_types (name, description) VALUES
('A', 'Poda de mantenimiento en árbol tipo A, caduco, de p.c. entre 41/80 cm.'),
('B', 'Poda de mantenimiento en árbol tipo B, caduco, de p.c. mayor de 81 cm.'),
('C', 'Poda de mantenimiento en árbol tipo C, perenne, de p.c. entre 41/60 cm.');
--* Points and zones
INSERT INTO points (latitude, longitude) VALUES
(40.416775, -3.703790),
(40.416776, -3.703795),
(40.416777, -3.703800);
INSERT INTO zones (name, postal_code, point_id) VALUES
('Zona 1', '46001', 1),
('Zona 2', '46002', 2),
('Zona 3', '46003', 3);
--* Elements and incidences
INSERT INTO elements (name, zone_id, point_id, tree_type_id) VALUES
('Árbol 1', 1, 1, 1),
('Árbol 2', 2, 2, 2),
('Árbol 3', 3, 3, 3);
INSERT INTO incidences (name, element_id, description) VALUES
('Rama caída', 1, 'Rama caída en el suelo'),
('Banco roto', 2, 'Banco roto en el parque'),
('Fuente sin agua', 3, 'Fuente sin agua en el parque'),
('Árbol enfermo', 1, 'Árbol con signos de enfermedad'),
('Banco pintado', 2, 'Banco pintado con grafitis'),
('Fuente con fuga', 3, 'Fuente con fuga de agua');
--* Work orders, tasks and reports
INSERT INTO work_orders (contract_id) VALUES
(1),
(2),
(3);
INSERT INTO tasks (work_order_id, notes) VALUES
(1, 'Poda de mantenimiento en árbol tipo A, caduco, de p.c. entre 41/80 cm.'),
(2, 'Poda de mantenimiento en árbol tipo B, caduco, de p.c. entre 50/100 cm.'),
(3, 'Poda de mantenimiento en árbol tipo C, caduco, de p.c. entre 60/120 cm.');
INSERT INTO tasks_zones (task_id, zone_id) VALUES
(1, 1),
(2, 2),
(3, 3);
INSERT INTO tasks_tasktypes (task_id, tasktype_id) VALUES
(1, 1),
(2, 2),
(3, 3);
INSERT INTO tasks_workers (task_id, worker_id) VALUES
(1, 1),
(2, 2),
(3, 3);
--* Sensors and sensor history
INSERT INTO sensors (zone_id, model, is_active) VALUES
(1, 'Sensor 1', 1),
(2, 'Sensor 2', 1),
(3, 'Sensor 3', 1);
