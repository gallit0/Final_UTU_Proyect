
CREATE DATABASE madmotors;

CREATE TABLE Usuario ( 
idUsuario varchar(12) not null, 
emailUsuario Varchar(90) unique , 
contrasenaUsuario Varchar(90), 
nombreApellidoUsuario Varchar(40) , 
direccionUsuario Varchar(100), 
permisoUsuario int(1) not null DEFAULT 1,
PRIMARY KEY (idUsuario));

CREATE TABLE ClienteCorporativo(
rutCliente varchar(12) not null,
razonSocial varchar(90) not null,
FOREIGN KEY (rutCliente) REFERENCES Usuario(idUsuario) ON DELETE CASCADE, 
PRIMARY KEY (rutCliente));

CREATE TABLE Cliente (
ciCliente varchar(8) not null,
FOREIGN KEY (ciCliente) REFERENCES Usuario(idUsuario) ON DELETE CASCADE, 
PRIMARY KEY (ciCliente));

CREATE TABLE Empleado (
ciEmpleado varchar(8) not null, 
ocupacionEmpleado Varchar(20), 
fechaNacimiento DATE not null, 
FOREIGN KEY (ciEmpleado) REFERENCES Usuario(idUsuario) ON DELETE CASCADE,
PRIMARY KEY (ciEmpleado));

CREATE TABLE vehiculo (
matriculaVehiculo VARCHAR(10)not null, 
tipoVehiculo Varchar(25), 
marcaVehiculo Varchar(35),
colorVehiculo Varchar(20) , 
PRIMARY KEY (matriculaVehiculo));

CREATE TABLE llevaCorporacion ( 
rutCliente varchar(12) not null,
matriculaVehiculo Varchar (10) not null, 
FOREIGN KEY(rutCliente) references ClienteCorporativo(rutCliente) ON DELETE CASCADE,
FOREIGN KEY(matriculaVehiculo) references vehiculo(matriculaVehiculo) ON DELETE CASCADE, PRIMARY KEY(rutCliente, matriculaVehiculo));

CREATE TABLE llevaTaller ( 
ciCliente varchar(8) not null,
matriculaVehiculo Varchar (10) not null, 
FOREIGN KEY(ciCliente) references Cliente(ciCliente) ON DELETE CASCADE,
FOREIGN KEY(matriculaVehiculo) references vehiculo(matriculaVehiculo) ON DELETE CASCADE, PRIMARY KEY(ciCliente, matriculaVehiculo));

CREATE TABLE Reparacion( codigoReparacion varchar(16) not null, 
descReparacion text not null, 
presupuestoReparacion float, 
CombustibleIngresoVehiculo int(3), 
kilometrajeVehiculo int(7),
fechaingreso date not null, 
fechaegreso date , 
matriculaVehiculo varchar(10)not null,
aprovadaRep int(1) default null,
 FOREIGN KEY (matriculaVehiculo) REFERENCES vehiculo (matriculaVehiculo) ON DELETE CASCADE, PRIMARY KEY (codigoReparacion,matriculaVehiculo));

CREATE TABLE Proveedor( rutProveedor varchar(12) not null,
 nombreProveedor varchar(50)not null,
 direccionSucursalCercana varchar(100), 
PRIMARY KEY (rutProveedor)); 

CREATE TABLE Repuesto( 
idRepuesto int(30) not null AUTO_INCREMENT, 
nombreRepuesto varchar(50) not null,
marcaRepuesto varchar(50), 
desRepuesto text, 
cantidadRepuesto int (6) not null,
precioRepuesto float not null, 
urlimagen varchar(255) unique,
rutProveedor varchar(12) not null,
FOREIGN KEY (rutProveedor) REFERENCES Proveedor (rutProveedor) ON DELETE CASCADE,
PRIMARY KEY (idRepuesto));

CREATE TABLE EmpleadoAsignado( ciEmpleado varchar(8) not null, 
codigoReparacion varchar(16) not null,
 FOREIGN KEY (ciEmpleado) REFERENCES empleado (ciEmpleado) ON DELETE CASCADE, 
FOREIGN KEY (codigoReparacion) REFERENCES reparacion (codigoReparacion) ON DELETE CASCADE, PRIMARY KEY (ciEmpleado,codigoReparacion));

CREATE TABLE repuestousado( codigoReparacion varchar(16) not null,
 idRepuesto int(30)not null,
fechaUso date not null,
precioMomento float not null,
cantidadusada int(6) not null, 
 FOREIGN KEY (codigoReparacion) REFERENCES reparacion (codigoReparacion) ON DELETE CASCADE, FOREIGN KEY (idRepuesto) REFERENCES repuesto (idRepuesto) ON DELETE CASCADE,
 PRIMARY KEY (codigoReparacion,idRepuesto));

CREATE TABLE telefonosUsuario( idUsuario varchar(12) not null, 
telefonosUsuario varchar(15) not null, 
FOREIGN KEY (idUsuario) REFERENCES Usuario(idUsuario) ON DELETE CASCADE,
 PRIMARY KEY (idUsuario, telefonosUsuario));

CREATE TABLE telefonosPoveedor( rutProveedor varchar(12) not null, telefonosProveedor varchar(15) not null, 
FOREIGN KEY (rutProveedor) REFERENCES Proveedor(rutProveedor) ON DELETE CASCADE, 
PRIMARY KEY (rutProveedor, telefonosProveedor));

create table facturacion (
idFactura int AUTO_INCREMENT not null,
subtotal float not null,
totalIva float not null,
total float not null,
rutEmisor varchar(12) not null DEFAULT '020818280012',
fecha date not null,
moneda varchar (6) default 'UYU',
direccionCliente varchar (100) not null,
codigoQr varchar (200),
tipoImporte varchar (15) not null,
tipoFactura varchar (10) not null,
vencimientoFactura date not null,
manoObra float not null,
primary key(idFactura)
);

create table reparacionFactura(
codigoReparacion varchar(16) not null,
idRepuesto int not null,
idFactura int not null,
precio float not null,
cantidad int(6) not null,
FOREIGN KEY (codigoReparacion) REFERENCES reparacion (codigoReparacion) ON DELETE CASCADE, 
FOREIGN KEY (idRepuesto) REFERENCES repuesto (idRepuesto) ON DELETE CASCADE,
FOREIGN KEY (idFactura) REFERENCES facturacion (idFactura) ON DELETE CASCADE,
 PRIMARY KEY (codigoReparacion,idRepuesto, idFactura));

CREATE TABLE eFactura(
idFactura int not null,
rutCliente varchar (12) not null,
razonSocial varchar (90) not null,
FOREIGN KEY (idFactura) REFERENCES facturacion (idFactura) ON DELETE CASCADE,
FOREIGN KEY (rutCliente) REFERENCES Usuario(idUsuario) ON DELETE CASCADE,
PRIMARY KEY (idFactura)
);

CREATE TABLE eTicket(
idFactura int not null,
ciCliente varchar (12) not null,
nombreCliente varchar (90) not null,
FOREIGN KEY (idFactura) REFERENCES facturacion (idFactura) ON DELETE CASCADE,
FOREIGN KEY (ciCliente) REFERENCES Usuario(idUsuario) ON DELETE CASCADE,
PRIMARY KEY (idFactura)
);

