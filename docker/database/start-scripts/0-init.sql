--* Roles, users, contracts and machines
create table roles (
    id int auto_increment primary key,
    name varchar(255) unique,
    created_at timestamp default current_timestamp
);

create table workers (
    id int auto_increment primary key,
    company varchar(255),
    name varchar(255),
    dni varchar(255) unique,
    password varchar(255),
    email varchar(255),
    role_id int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (role_id) references roles(id)
);

create table contracts (
    id int auto_increment primary key,
    name varchar(255) not null,
    start_date timestamp not null,
    end_date timestamp,
    invoice_proposed float,
    invoice_agreed float,
    invoice_paid float,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp
);

create table machines (
    id int auto_increment primary key,
    name varchar(255),
    max_basket_size float not null,
    created_at timestamp default current_timestamp,
    constraint UC_MachineType unique (name, max_basket_size)
);

--* Tree, task and pruning types
create table tree_types (
    id int auto_increment primary key,
    family varchar(255) not null,
    genus varchar(255) not null,
    species varchar(255) unique,
    created_at timestamp default current_timestamp,
    constraint UC_TreeType unique (family, genus, species)
);

create table task_types (
    id int auto_increment primary key,
    name varchar(255) unique,
    created_at timestamp default current_timestamp
);

create table pruning_types (
    id int auto_increment primary key,
    name varchar(20) unique,
    description varchar(255),
    created_at timestamp default current_timestamp
);

--* Points and zones
create table points (
    id int auto_increment primary key,
    latitude decimal(10, 7) not null,
    longitude decimal(10, 7) not null,
    created_at timestamp default current_timestamp,
    constraint UC_Point unique (latitude, longitude)
);

create table zones (
    id int auto_increment primary key,
    name varchar(255) not null,
    postal_code int not null,
    point_id int unique,
    created_at timestamp default current_timestamp,
    foreign key (point_id) references points(id),
    constraint UC_Zone unique (name, postal_code)
);

--* Elements and incidences
create table elements (
    id int auto_increment primary key,
    name varchar(255) not null,
    zone_id int not null,
    point_id int unique,
    tree_type_id int not null,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
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
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (element_id) references elements(id)
);

--TODO: tasks, routes and works
create table work_orders (
    id int auto_increment primary key,
    name varchar(255),
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp
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
    created_at timestamp default current_timestamp,
    foreign key (point_id) references points(id)
);

create table tasks (
    id int auto_increment primary key,
    task_name varchar(255),
    work_order_id int,
    description varchar(255),
    element_id int,
    machine_id int,
    route_id int,
    part_id int,
    history_id int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (work_order_id) references work_orders(id),
    foreign key (element_id) references elements(id),
    foreign key (machine_id) references machines(id),
    foreign key (route_id) references routes(id),
    foreign key (part_id) references parts(id)
);

create table task_workers (
    id int auto_increment primary key,
    task_id int,
    worker_id int,
    created_at timestamp default current_timestamp,
    foreign key (task_id) references tasks(id),
    foreign key (worker_id) references workers(id)
);

--* FUTURE: sensors and sensor history
-- create table sensors (
--     id int auto_increment primary key,
--     entidad_vegetal int,
--     element_id int,
--     model varchar(255),
--     operative boolean,
--     class varchar(255),
--     created_at timestamp default current_timestamp,
--     foreign key (element_id) references elements(id)
-- );
-- 
-- create table sensor_history (
--     id int auto_increment primary key,
--     sensor_id int,
--     temperature float,
--     humedad float,
--     inclination float,
--     created_at timestamp default current_timestamp,
--     foreign key (sensor_id) references sensors(id)
-- );
