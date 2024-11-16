create table points (
  id int auto_increment primary key,
  latitude decimal,
  longitude decimal
);

create table zones (
  id int auto_increment primary key,
  name varchar(255),
  quantity int,
  postal_code int,
  point_id int,
  foreign key (point_id) references points(id)
);

create table tree_types (
  id int auto_increment primary key,
  family varchar(255) not null,
  genus varchar(255) not null,
  species varchar(255) not null unique,
  constraint UC_TreeType unique (family, genus, species)
);

create table elements (
  id int auto_increment primary key,
  name varchar(255),
  latitude decimal,
  longitude decimal,
  tree_types_id int,
  created_at timestamp,
  deleted_at timestamp,
  updated_at timestamp,
  foreign key (tree_types_id) references tree_types(id)
);

create table inventory (
  id int auto_increment primary key,
  element_id int,
  zone_id int,
  foreign key (element_id) references elements(id),
  foreign key (zone_id) references zones(id)
);

create table incidences (
  id int auto_increment primary key,
  name varchar(255),
  photo varchar(255),
  element_id int,
  description varchar(255),
  incident_date timestamp,
  foreign key (element_id) references elements(id)
);

create table roles (
  id int auto_increment primary key,
  name varchar(255) unique
);

create table workers (
  id int auto_increment primary key,
  company varchar(255),
  name varchar(255),
  dni varchar(255) unique,
  password varchar(255),
  email varchar(255),
  role_id int,
  created_at timestamp,
  deleted_at timestamp,
  updated_at timestamp,
  foreign key (role_id) references roles(id)
);


CREATE TABLE contracts (
  id int auto_increment primary key,
  name varchar(255),
  start_date DATE,
  end_date DATE,
  invoice_proposed float,
  invoice_agreed float,
  invoice_paid float,
  created_at timestamp default current_timestamp,
  deleted_at timestamp,
  updated_at timestamp
);

create table work_orders (
  id int auto_increment primary key,
  name varchar(255),
  created_at timestamp,
  deleted_at timestamp,
  updated_at timestamp
);

create table machines (
  id int auto_increment primary key,
  name varchar(255),
  basket_size varchar(255) NULL
);

create table parts (
  id int auto_increment primary key,
  observation varchar(255),
  quantity int,
  fuel decimal,
  picture varchar(255)
);

create table routes (
  id int auto_increment primary key,
  distance float,
  point_id int,
  travel_time int,
  foreign key (point_id) references points(id)
);

create table tasks (
  id int auto_increment primary key,
  task_name varchar(255),
  work_order_id int,
  description varchar(255),
  inventory_id int,
  machine_id int,
  route_id int,
  status BIT,
  part_id int,
  history_id int,
  created_at timestamp,
  deleted_at timestamp,
  foreign key (work_order_id) references work_orders(id),
  foreign key (inventory_id) references inventory(id),
  foreign key (machine_id) references machines(id),
  foreign key (route_id) references routes(id),
  foreign key (part_id) references parts(id)
);

create table worker_tasks (
  id int auto_increment primary key,
  task_id int,
  worker_id int,
  foreign key (task_id) references tasks(id),
  foreign key (worker_id) references workers(id)
);

create table sensors (
  id int auto_increment primary key,
  entidad_vegetal int,
  element_id int,
  model varchar(255),
  operative boolean,
  class varchar(255),
  created_at timestamp default current_timestamp,
  foreign key (element_id) references elements(id)
);

create table sensor_history (
  id int auto_increment primary key,
  sensor_id int,
  temperature float,
  humedad float,
  inclination float,
  created_at timestamp default current_timestamp,
  foreign key (sensor_id) references sensors(id)
);

create table pruning_types (
  id int auto_increment primary key,
  name varchar(20) unique,
  description varchar(255)
);

create table task_types (
  id int auto_increment primary key,
  name varchar(255) unique
);
