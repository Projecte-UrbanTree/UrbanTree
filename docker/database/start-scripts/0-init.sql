create table points (
  id int auto_increment primary key,
  latitude decimal(10, 7) not null,
  longitude decimal(10, 7) not null,
  constraint UC_Point unique (latitude, longitude)
);

create table task_types (
  id int auto_increment primary key,
  name varchar(255) unique
);

create table zones (
  id int auto_increment primary key,
  name varchar(255) not null,
  postal_code int not null,
  point_id int not null unique,
  foreign key (point_id) references points(id),
  constraint UC_Zone unique (name, postal_code)
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
  name varchar(255) not null,
  zone_id int not null,
  point_id int not null,
  tree_type_id int not null,
  created_at timestamp default current_timestamp,
  deleted_at timestamp,
  updated_at timestamp,
  foreign key (zone_id) references zones(id),
  foreign key (point_id) references points(id),
  foreign key (tree_type_id) references tree_types(id)
);

create table incidences (
  id int auto_increment primary key,
  element_id int not null,
  name varchar(255) not null,
  description varchar(255),
  photo varchar(255),
  created_at timestamp default current_timestamp,
  foreign key (element_id) references elements(id)
);

create table roles (
  id int auto_increment primary key,
  name varchar(255)
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
  contract_id int,
  created_at timestamp default current_timestamp,
  deleted_at timestamp,
  updated_at timestamp,
  foreign key (contract_id) references contracts(id)
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
  work_order_id int,
  notes varchar(255),
  created_at timestamp,
  deleted_at timestamp,
  foreign key (work_order_id) references work_orders(id)
);

create table tasks_workers (
  id int auto_increment primary key,
  task_id int,
  worker_id int,
  foreign key (task_id) references tasks(id),
  foreign key (worker_id) references workers(id)
);

create table tasks_zones (
  id int auto_increment primary key,
  task_id int,
  zone_id int,
  foreign key (task_id) references tasks(id),
  foreign key (zone_id) references zones(id)
);

create table tasks_tasktypes (
  id int auto_increment primary key,
  task_id int,
  tasktype_id int,
  foreign key (task_id) references tasks(id),
  foreign key (tasktype_id) references task_types(id)
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
