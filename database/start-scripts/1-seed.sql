--* Users
INSERT INTO users (company, name, surname, dni, password, email, role) VALUES
('TechCorp', 'Carlos', 'García', '12345678A', '$2y$10$BvILqM2m0pJlHNzyugbIu.RqhLIKwKetsRCo3FQbpcOiVx2nHBc9m', 'carlos.garcia@example.com', 0), -- Password: demopass
('InnovaTech', 'Ana', 'Martínez', '23456789B', '$2y$10$BvILqM2m0pJlHNzyugbIu.RqhLIKwKetsRCo3FQbpcOiVx2nHBc9m', 'ana.martinez@example.com', 1),
('DesignWorks', 'Gemma', 'Palanca', '33344456G', '$2y$10$BvILqM2m0pJlHNzyugbIu.RqhLIKwKetsRCo3FQbpcOiVx2nHBc9m', 'gemma.palanca@example.com', 1), -- Password: demopass
('DesignWorks', 'José', 'Rodríguez', '34567890C', '$2y$10$BvILqM2m0pJlHNzyugbIu.RqhLIKwKetsRCo3FQbpcOiVx2nHBc9m', 'jose.rodriguez@example.com', 2); -- Password: demopass

--* Contracts
INSERT INTO contracts (name, start_date, end_date, invoice_proposed, invoice_agreed, invoice_paid) VALUES
('Ayuntamiento de Valencia', '2021-01-01', '2026-12-31', 1000.00, 900.00, 900.00),
('Administración General del Estado', '2026-01-01', '2021-12-31', 2000.00, 1800.00, 1800.00),
('Ayuntamiento de Carlet', '2021-01-01', '2026-12-31', 3000.00, 2700.00, 2700.00);

--* Machines
INSERT INTO machines (name, max_basket_size) VALUES
('Cesta elevadora', 200.00),
('Plataforma elevadora', 300.00),
('Tijera elevadora', 400.00);

--* Element Types
INSERT INTO element_types (name, description, requires_tree_type) VALUES
('Árbol', 'Elemento tipo árbol', true),
('Banco', 'Elemento tipo banco', false),
('Fuente', 'Elemento tipo fuente', false);

--* Tree Types
INSERT INTO tree_types (family, genus, species) VALUES
('Fagaceae', 'Quercus', 'Quercus robur'),
('Pinaceae', 'Pinus', 'Pinus sylvestris'),
('Sapindaceae', 'Acer', 'Acer campestre');

--* Tasks
INSERT INTO task_types (name, description) VALUES
('Podar árboles', 'Tarea de poda general'),
('Riego de árboles', 'Riego programado'),
('Fertilización', 'Fertilización básica');

--* Points
INSERT INTO points (latitude, longitude) VALUES
(40.416775, -3.703790),
(40.416776, -3.703795),
(40.416777, -3.703800);

--* Zones
INSERT INTO zones (name, contract_id) VALUES
('Zona Norte', 1),
('Zona Este', 2),
('Zona Oeste', 3);

--* Elements
INSERT INTO elements (element_type_id, contract_id, zone_id, point_id, tree_type_id) VALUES
(1, 1, 1, 1, 1),
(2, 2, 2, 2, NULL),
(3, 3, 3, 3, NULL);

--* Incidences
INSERT INTO incidences (element_id, name, description) VALUES
(1, 'Rama caída', 'Rama caída en el suelo'),
(2, 'Banco roto', 'Banco roto en el parque'),
(3, 'Fuente sin agua', 'Fuente sin agua en el parque');

--* Work Orders
INSERT INTO work_orders (contract_id, date) VALUES
(1,"2021-01-01"),
(2,"2021-02-01"),
(3,"2021-03-01");

--* Work Orders Users
INSERT INTO work_orders_users (work_order_id, user_id) VALUES
(1, 1),
(2, 2),
(3, 3);

--* Work Reports
INSERT INTO work_reports (work_order_id, observation, spent_fuel) VALUES
(1, 'Observación de la orden 1', 50.0),
(2, 'Observación de la orden 2', 60.0),
(3, 'Observación de la orden 3', 70.0);

--* Sensors
INSERT INTO sensors (zone_id, contract_id, point_id, model, is_active) VALUES
(1, 1, 1, 'Sensor Modelo A', TRUE),
(2, 2, 2, 'Sensor Modelo B', TRUE),
(3, 3, 3, 'Sensor Modelo C', FALSE);

--* Sensor History
INSERT INTO sensor_history (sensor_id, temperature, humidity, inclination) VALUES
(1, 22.5, 60.0, 15.0),
(2, 21.0, 55.0, 10.0),
(3, 19.0, 50.0, 12.0);

--* Work Orders Blocks
INSERT INTO work_orders_blocks (work_order_id, notes) VALUES
(1,"Notas de la orden 1"),
(2,"Notas de la orden test test test test test test test test test test test"),
(3, NULL);

--* Work Orders Blocks Zones
INSERT INTO work_orders_blocks_zones (work_orders_block_id, zone_id) VALUES
(1, 1),
(1, 2),
(2, 2),
(3, 3);

INSERT INTO work_orders_blocks_tasks (work_orders_block_id, task_id, tree_type_id) VALUES
(1, 1, 1),
(1, 2, 2),
(2, 2, NULL),
(3, 3, NULL);
