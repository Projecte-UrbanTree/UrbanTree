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
INSERT INTO element_types (name, description, requires_tree_type, icon, color) VALUES
('Árbol', 'Elemento tipo árbol', true, 'fa-solid fa-tree', '#ff8629'),
('Banco', 'Elemento tipo banco', false, 'fa-solid fa-chair', '#3bc736'),
('Fuente', 'Elemento tipo fuente', false, 'fa-solid fa-faucet', '#007bff');

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

--* Zones
INSERT INTO zones (name, contract_id, color, description) VALUES
('Amposta A', 1, '#FF0000', 'Esta es una descripción de la zona 1.');

--* Points
INSERT INTO points (latitude, longitude, zone_id, element_id) VALUES
(0.5846986, 40.7097591, 1, NULL),
(0.5868467, 40.7045287, 1, NULL),
(0.5879137, 40.7058229, 1, NULL),
(0.5879137, 40.7061787, 1, NULL),
(0.5876434, 40.7068150, 1, NULL),
(0.5880987, 40.7077425, 1, NULL),
(0.5885966, 40.7078719, 1, NULL),
(0.5889096, 40.7080228, 1, NULL),
(0.5875581, 40.7087238, 1, NULL),
(0.5864769, 40.7091660, 1, NULL),
(0.5854810, 40.7095110, 1, NULL),
(40.7092449, 0.5852129, NULL, 2),
(40.7084313, 0.5855778, NULL, 3),
(40.7076177, 0.5858998, NULL, 4),
(40.7081059, 0.5879175, NULL, 5),
(40.7074062, 0.5875097, NULL, 6),
(40.7068041, 0.5862003, NULL, 7),
(40.7059580, 0.5865008, NULL, 8),
(40.7051281, 0.5868442, NULL, 9);

--* Elements
INSERT INTO elements (element_type_id, contract_id, zone_id, point_id, tree_type_id) VALUES
(1, 1, 1, 1, 1),
(1, 1, 1, 12, NULL),
(1, 1, 1, 13, NULL),
(1, 1, 1, 14, NULL),
(3, 1, 1, 15, NULL),
(2, 1, 1, 16, NULL),
(1, 1, 1, 17, NULL),
(1, 1, 1, 18, NULL),
(1, 1, 1, 19, NULL);

--* Incidences
INSERT INTO incidences (element_id, name, description) VALUES
(1, 'Rama caída', 'Rama caída en el suelo');

--* Work Orders
INSERT INTO work_orders (contract_id, date) VALUES
(1,"2021-01-01");

--* Work Orders Users
INSERT INTO work_orders_users (work_order_id, user_id) VALUES
(1, 1);

--* Work Reports
INSERT INTO work_reports (work_order_id, observation, spent_fuel) VALUES
(1, 'Observación de la orden 1', 50.0);

--* Sensors
INSERT INTO sensors (zone_id, contract_id, point_id, model, is_active) VALUES
(1, 1, 1, 'Sensor Modelo A', TRUE),
(1, 1, 2, 'Sensor Modelo B', TRUE),
(1, 1, 3, 'Sensor Modelo C', FALSE);

--* Sensor History
INSERT INTO sensor_history (sensor_id, temperature, humidity, inclination) VALUES
(1, 22.5, 60.0, 15.0),
(2, 21.0, 55.0, 10.0),
(3, 19.0, 50.0, 12.0);

--* Work Orders Blocks
INSERT INTO work_orders_blocks (work_order_id, notes) VALUES
(1,"Notas de la orden 1");

--* Work Orders Blocks Zones
INSERT INTO work_orders_blocks_zones (work_orders_block_id, zone_id) VALUES
(1, 1);

INSERT INTO work_orders_blocks_tasks (work_orders_block_id, task_id, tree_type_id) VALUES
(1, 1, 1);
