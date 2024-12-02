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
    foreign key (photo_id) references photos(id),
    constraint UC_MachineType unique (name, max_basket_size)
);

--* Tree, task and pruning types
create table tree_types (
    id int auto_increment primary key,
    family varchar(255) not null,
    genus varchar(255) not null,
    species varchar(255) unique,
    photo_id int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (photo_id) references photos(id),
    constraint UC_TreeType unique (family, genus, species)
);

create table task_types (
    id int auto_increment primary key,
    name varchar(255) unique,
    photo_id int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (photo_id) references photos(id)
);

create table pruning_types (
    id int auto_increment primary key,
    name varchar(20) unique,
    description varchar(255),
    photo_id int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (photo_id) references photos(id)
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
    point_id int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (point_id) references points(id)
);

create table zones_predefined (
    id int auto_increment primary key,
    zone_id int unique,
    name varchar(255) not null,
    photo_id int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (zone_id) references zones(id),
    foreign key (photo_id) references photos(id),
    constraint UC_ZonePredefined unique (zone_id, name)
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
    name varchar(255) not null,
    contract_id int not null,
    zone_id int not null,
    -- point_id int unique,
    tree_type_id int not null,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (contract_id) references contracts(id),
    foreign key (zone_id) references zones(id),
    -- foreign key (point_id) references points(id),
    foreign key (tree_type_id) references tree_types(id)
);

create table incidences (
    id int auto_increment primary key,
    element_id int not null,
    name varchar(255) not null,
    description varchar(255),
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (element_id) references elements(id)
);

create table incidence_photos (
    id int auto_increment primary key,
    incidence_id int not null,
    photo_id int not null,
    created_at timestamp default current_timestamp,
    foreign key (incidence_id) references incidences(id),
    foreign key (photo_id) references photos(id),
    constraint UC_IncidencePhoto unique (incidence_id, photo_id)
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
    task_type_id int not null,
    tree_type_id int,
    notes varchar(255),
    status int default 0,
    route_id int,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    deleted_at timestamp,
    foreign key (work_orders_block_id) references work_orders_blocks(id),
    foreign key (task_type_id) references task_types(id),
    foreign key (tree_type_id) references tree_types(id),
    foreign key (route_id) references routes(id)
);

create table work_reports (
    id int auto_increment primary key,
    work_order_id int unique,
    observation varchar(255),
    spent_fuel decimal,
    created_at timestamp default current_timestamp,
    updated_at timestamp,
    foreign key (work_order_id) references work_orders(id)
);

create table work_report_photos (
    id int auto_increment primary key,
    work_report_id int not null,
    photo_id int not null,
    created_at timestamp default current_timestamp,
    foreign key (work_report_id) references work_reports(id),
    foreign key (photo_id) references photos(id),
    constraint UC_WorkReportPhoto unique (work_report_id, photo_id)
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
