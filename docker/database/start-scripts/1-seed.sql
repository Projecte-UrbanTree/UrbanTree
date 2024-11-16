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


INSERT INTO task_types (name) VALUES
('Task 1'),
('Task 2'),
('Task 3');