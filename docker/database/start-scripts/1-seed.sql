-- Insert sample roles (Admin, Manager, Worker)
INSERT INTO roles (role_name) VALUES
('Administrador'),
('Gerente'),
('Trabajador');

-- Insert sample workers (Spanish users)
INSERT INTO workers (company, name, dni, password, email, role_id, created_at, updated_at, deleted_at) VALUES
('TechCorp', 'Carlos García', '12345678A', 'hashedpassword1', 'carlos.garcia@example.com', 1, NOW(), NOW(), NULL), -- Admin
('InnovaTech', 'Ana Martínez', '23456789B', 'hashedpassword2', 'ana.martinez@example.com', 2, NOW(), NOW(), NULL), -- Manager
('DesignWorks', 'José Rodríguez', '34567890C', 'hashedpassword3', 'jose.rodriguez@example.com', 3, NOW(), NOW(), NULL); -- Worker


-- Insert sample elements (trees, benches, fountains)
INSERT INTO elements(name, latitude, longitude, created_at, updated_at, deleted_at) VALUES
('Árbol', 40.416775, -3.703790, NOW(), NOW(), NULL),
('Banco', 40.416775, -3.703790, NOW(), NOW(), NULL),
('Fuente', 40.416775, -3.703790, NOW(), NOW(), NULL);

-- INSERT SAMPLE INCIDENCTS
INSERT INTO incidences (name, element_id, description, incident_date) VALUES
('Rama caída', 1, 'Rama caída en el suelo', NOW()),
('Banco roto', 2, 'Banco roto en el parque', NOW()),
('Fuente sin agua', 3, 'Fuente sin agua en el parque', NOW()),
('Árbol enfermo', 1, 'Árbol con signos de enfermedad', NOW()),
('Banco pintado', 2, 'Banco pintado con grafitis', NOW()),
('Fuente con fuga', 3, 'Fuente con fuga de agua', NOW());
