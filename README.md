Querys

-- Tabla de Usuarios
CREATE TABLE Usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    NUIP VARCHAR(20) UNIQUE NOT NULL,
    telefono VARCHAR(15),
    direccion VARCHAR(100),
    email VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(100) NOT NULL,
    rol ENUM('SuperAdmin', 'Admin', 'Abogado', 'Secretario', 'Usuario') NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    numero_licencia VARCHAR(50),
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    especialidad VARCHAR(100)
);

-- Tabla de Casos
CREATE TABLE Casos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_caso VARCHAR(20) UNIQUE NOT NULL,
    descripcion TEXT,
    estado ENUM('abierto', 'cerrado', 'en progreso') DEFAULT 'abierto',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_cierre DATETIME
);

-- Tabla de Asignaciones
CREATE TABLE Asignaciones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    caso_id INT NOT NULL,
    cliente_id INT NOT NULL,
    abogado_id INT NOT NULL,
    secretario_id INT,
    fecha_asignacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (caso_id) REFERENCES Casos(id),
    FOREIGN KEY (cliente_id) REFERENCES Usuarios(id),
    FOREIGN KEY (abogado_id) REFERENCES Usuarios(id),
    FOREIGN KEY (secretario_id) REFERENCES Usuarios(id)
);

-- Tabla de Contactos
CREATE TABLE Contactos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_envio DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Historial de Casos
CREATE TABLE Historial_Casos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    caso_id INT NOT NULL,
    usuario_id INT NOT NULL,
    descripcion TEXT,
    fecha_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (caso_id) REFERENCES Casos(id),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)
);

-- Tabla de Documentos
CREATE TABLE Documentos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    caso_id INT NOT NULL,
    nombre_documento VARCHAR(100) NOT NULL,
    tipo_documento VARCHAR(50),
    url_documento VARCHAR(255),
    fecha_subida DATETIME DEFAULT CURRENT_TIMESTAMP,
    usuario_id INT NOT NULL,
    FOREIGN KEY (caso_id) REFERENCES Casos(id),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)
);