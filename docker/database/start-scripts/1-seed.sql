-- Inserts per a la taula tree_types
INSERT INTO tree_types (species, subspecies, family)
VALUES
  ('Quercus', 'Quercus robur', 'Fagaceae'),
  ('Pinus', 'Pinus sylvestris', 'Pinaceae'),
  ('Acer', 'Acer campestre', 'Sapindaceae');

-- Inserts per a la taula elements
INSERT INTO elements (name, latitude, longitude, tree_types_id, created_at, deleted_at, updated_at)
VALUES
  ('Roureda de la Selva', 41.8793, 2.8246, 1, '2024-11-01 10:30:00', NULL, '2024-11-10 12:00:00'),
  ('Pineda de les Gavarres', 41.9738, 2.7756, 2, '2024-11-02 09:45:00', NULL, '2024-11-11 11:15:00'),
  ('Arbre de la Plaça Major', 41.3879, 2.1699, 3, '2024-11-03 08:00:00', NULL, '2024-11-12 10:20:00');
