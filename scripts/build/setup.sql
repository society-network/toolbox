create table src_files (
  src_file_id integer NOT NULL AUTO_INCREMENT,
	created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	deleted timestamp NULL DEFAULT NULL,
  modified timestamp NULL DEFAULT NULL,
  name varchar(255),
  PRIMARY KEY (src_file_id),
  UNIQUE KEY name (name)
);

create table src_data (
	src_data_id integer NOT NULL AUTO_INCREMENT,
	created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	deleted timestamp NULL DEFAULT NULL,
  modified timestamp NULL DEFAULT NULL,
  src_file_id integer NULL NULL,
	ref_code varchar(255),
	receiver_name varchar(255),
	address1 varchar(255),
	address2 varchar(255),
	suburb varchar(255),
	state varchar(255),
	postcode varchar(255),
	phone varchar(255),
	email varchar(255),
	delivery_note varchar(255),
	description varchar(255),
	quantity varchar(255),
	weight varchar(255),
	gross_value varchar(255),
	sender_country varchar(255),
	sender_name varchar(255),
	gross_currency varchar(255),
	primary key(src_data_id)
);

create table tmp_import_shippers (
  ShipperName1 varchar(255),
  ShipperName2 varchar(255),
  ShipperAddr1 varchar(255),
  ShipperAddr2 varchar(255),
  ShipperAddr3 varchar(255),
  ShipperCity varchar(255),
  ShipperState varchar(255),
  ShipperPostcode varchar(255),
  ShipperCountry varchar(255)
);

create table shippers (
	shipper_id integer NOT NULL AUTO_INCREMENT,
	created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	deleted timestamp NULL DEFAULT NULL,
	modified timestamp NULL DEFAULT NULL,
	shipper_name1 varchar(255),
	shipper_name2 varchar(255),
	shipper_addr1 varchar(255),
	shipper_addr2 varchar(255),
	shipper_addr3 varchar(255),
	shipper_city varchar(255),
	shipper_state varchar(255),
	shipper_postcode varchar(255),
	shipper_country varchar(255),
	primary key(shipper_id)
);

create table shipper_aliases (
	shipper_alias_id integer NOT NULL AUTO_INCREMENT,
	created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	deleted timestamp NULL DEFAULT NULL,
	modified timestamp NULL DEFAULT NULL,
	shipper_id integer NOT NULL,
	name varchar(255),
	primary key(shipper_alias_id)
);

create table depot_carrier_codes (
	depot_carrier_code_id integer NOT NULL AUTO_INCREMENT,
	created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	deleted timestamp NULL DEFAULT NULL,
	modified timestamp NULL DEFAULT NULL,
	depot_code varchar(255),
	carrier_code varchar(255),
	primary key(depot_carrier_code_id)
);

insert into depot_carrier_codes (depot_code, carrier_code) VALUES ('P8N', 'ASO');
insert into depot_carrier_codes (depot_code, carrier_code) VALUES ('UWR', 'AUW');
insert into depot_carrier_codes (depot_code, carrier_code) VALUES ('UUA', 'AUA');
insert into depot_carrier_codes (depot_code, carrier_code) VALUES ('UUB', 'AUB');
insert into depot_carrier_codes (depot_code, carrier_code) VALUES ('QTC', 'AUSL');
insert into depot_carrier_codes (depot_code, carrier_code) VALUES ('UR9', 'AUWL');
insert into depot_carrier_codes (depot_code, carrier_code) VALUES ('XNY', 'AUS');
insert into depot_carrier_codes (depot_code, carrier_code) VALUES ('464', 'AUP');
