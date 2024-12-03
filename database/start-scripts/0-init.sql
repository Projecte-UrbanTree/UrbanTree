--* Photos
create table photos (
    id int auto_increment primary key,
    name varchar(255) not null,
    path varchar(255) not null,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp
);

--* Roles, users, contracts and machines
create table roles (
    id int auto_increment primary key,
    name varchar(255) unique,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp
);

create table users (
    id int auto_increment primary key,
    company varchar(255),
    name varchar(255) not null,
    surname varchar(255) not null,
    dni varchar(255) unique,
    password varchar(255) not null,
    email varchar(255) not null,
    role_id int not null,
    photo_id int,
    status int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (role_id) references roles(id),
    foreign key (photo_id) references photos(id)
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
    photo_id int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    constraint UC_MachineType unique (name, max_basket_size),
    foreign key (photo_id) references photos(id)
);

create table element_types(
    id int auto_increment primary key,
    name varchar(255) not null,
    description varchar(255),
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp
);

--* Tree, task and pruning types
create table tree_types (
    id int auto_increment primary key,
    family varchar(255) not null,
    genus varchar(255) not null,
    species varchar(255) unique,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    constraint UC_TreeType unique (family, genus, species)
);

create table tasks (
    id int auto_increment primary key,
    name varchar(255) unique,
    description varchar(255),
    tree_type_id int null,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (tree_type_id) references tree_types(id)
);

--* Points, zones and routes
create table points (
    id int auto_increment primary key,
    latitude decimal(10, 7) not null,
    longitude decimal(10, 7) not null,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    constraint UC_Point unique (latitude, longitude)
);

create table zones (
    id int auto_increment primary key,
    name varchar(255) not null,
    point_id int,
    contract_id int,
    city varchar(255),
    element_type_id int,
    amount int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (point_id) references points(id),
    foreign key (contract_id) references contracts(id),
    foreign key (element_type_id) references element_types(id)
);

create table routes (
    id int auto_increment primary key,
    distance float,
    travel_time int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp
);

create table route_points (
    id int auto_increment primary key,
    route_id int not null,
    point_id int not null,
    point_order int not null,
    created_at timestamp default current_timestamp,
    foreign key (route_id) references routes(id),
    foreign key (point_id) references points(id)
);

--* Elements and incidences
create table elements (
    id int auto_increment primary key,
    element_type_id int not null,
    contract_id int not null,
    zone_id int not null,
    point_id int unique,
    tree_type_id int null,
    incidence_id int NULL,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (contract_id) references contracts(id),
    foreign key (zone_id) references zones(id),
    foreign key (point_id) references points(id),
    foreign key (tree_type_id) references tree_types(id),
    foreign key (element_type_id) references element_types(id),
    forgein key (incidence_id) references incidences(id)
);

create table incidences (
    id int auto_increment primary key,
    element_id int not null,
    name varchar(255) not null,
    description varchar(255),
    photo_id int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (element_id) references elements(id),
    foreign key (photo_id) references photos(id)
);

--* Work orders, tasks and reports
create table work_orders (
    id int auto_increment primary key,
    contract_id int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (contract_id) references contracts(id)
);

create table work_orders_users (
    id int auto_increment primary key,
    work_order_id int not null,
    user_id int not null,
    created_at timestamp default current_timestamp,
    foreign key (work_order_id) references work_orders(id),
    foreign key (user_id) references users(id),
    constraint UC_WorkOrderUser unique (work_order_id, user_id)
);

create table work_orders_blocks (
    id int auto_increment primary key,
    work_order_id int not null,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (work_order_id) references work_orders(id)
);

create table work_orders_blocks_zones (
    id int auto_increment primary key,
    work_orders_block_id int not null,
    zone_id int not null,
    created_at timestamp default current_timestamp,
    foreign key (work_orders_block_id) references work_orders_blocks(id),
    foreign key (zone_id) references zones(id),
    constraint UC_WorkOrderBlockZone unique (work_orders_block_id, zone_id)
);

create table work_orders_blocks_tasks (
    id int auto_increment primary key,
    work_orders_block_id int not null,
    task_id int not null,
    tree_type_id int,
    notes varchar(255),
    status int default 0,
    route_id int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (work_orders_block_id) references work_orders_blocks(id),
    foreign key (task_id) references tasks(id),
    foreign key (tree_type_id) references tree_types(id),
    foreign key (route_id) references routes(id)
);


create table work_reports (
    id int auto_increment primary key,
    work_order_id int unique,
    observation varchar(255),
    spent_fuel decimal,
    photo_id int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    foreign key (work_order_id) references work_orders(id),
    foreign key (photo_id) references photos(id)
);


--* Sensors and sensor history
create table sensors (
    id int auto_increment primary key,
    contract_id int not null,
    zone_id int not null,
    point_id int unique,
    model varchar(255),
    is_active boolean,
    created_at timestamp default current_timestamp,
    foreign key (contract_id) references contracts(id),
    foreign key (zone_id) references zones(id),
    foreign key (point_id) references points(id),
    constraint UC_Sensor unique (contract_id, zone_id)
);

create table sensor_history (
    id int auto_increment primary key,
    sensor_id int not null,
    temperature float,
    humidity float,
    inclination float,
    created_at timestamp default current_timestamp,
    foreign key (sensor_id) references sensors(id),
    constraint UC_SensorHistory unique (sensor_id, created_at)
);
