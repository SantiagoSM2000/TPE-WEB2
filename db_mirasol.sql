-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2024 at 03:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_mirasol`
--

-- --------------------------------------------------------

--
-- Table structure for table `habitaciones`
--

CREATE TABLE `habitaciones` (
  `ID_Habitacion` int(11) NOT NULL,
  `Nro_Habitacion` int(11) NOT NULL,
  `Tipo_Habitacion` varchar(50) NOT NULL,
  `Capacidad` int(11) NOT NULL,
  `Precio` decimal(10,0) NOT NULL,
  `Estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `habitaciones`
--

INSERT INTO `habitaciones` (`ID_Habitacion`, `Nro_Habitacion`, `Tipo_Habitacion`, `Capacidad`, `Precio`, `Estado`) VALUES
(1, 101, 'Individual', 1, 10000, 'Disponible'),
(2, 402, 'Suite', 4, 25000, 'Disponible');

-- --------------------------------------------------------

--
-- Table structure for table `huespedes`
--

CREATE TABLE `huespedes` (
  `ID_Huesped` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `DNI` int(11) NOT NULL,
  `Telefono` varchar(50) NOT NULL,
  `Mail` varchar(50) NOT NULL,
  `Domicilio` varchar(50) NOT NULL,
  `Localidad` varchar(50) NOT NULL,
  `Pais` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `huespedes`
--

INSERT INTO `huespedes` (`ID_Huesped`, `Nombre`, `Apellido`, `DNI`, `Telefono`, `Mail`, `Domicilio`, `Localidad`, `Pais`) VALUES
(1, 'Juan', 'Perez', 20297582, '+54 9 249 422-5555', 'JuanPerez@huesped.com', '14 de Julio 604', 'Tandil', 'Argentina'),
(2, 'Valeria', 'Díaz', 25678412, '+54 9 249 465-7732', 'ValeriaDíaz@huesped.com', 'Belgrano 589', 'Tandil', 'Argentina');

-- --------------------------------------------------------

--
-- Table structure for table `reservas`
--

CREATE TABLE `reservas` (
  `ID_Reserva` int(11) NOT NULL,
  `ID_Huesped` int(11) NOT NULL,
  `ID_Habitacion` int(11) NOT NULL,
  `Cantidad_Personas` int(11) NOT NULL,
  `Fecha_Entrada` date NOT NULL,
  `Fecha_Salida` date NOT NULL,
  `Estado` varchar(50) NOT NULL,
  `Total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservas`
--

INSERT INTO `reservas` (`ID_Reserva`, `ID_Huesped`, `ID_Habitacion`, `Cantidad_Personas`, `Fecha_Entrada`, `Fecha_Salida`, `Estado`, `Total`) VALUES
(1, 1, 1, 1, '2024-07-03', '2024-07-05', 'Confirmada', 10000),
(2, 2, 2, 4, '2024-10-09', '2024-10-11', 'Confirmada', 25000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `habitaciones`
--
ALTER TABLE `habitaciones`
  ADD PRIMARY KEY (`ID_Habitacion`),
  ADD UNIQUE KEY `Nro_Habitacion` (`Nro_Habitacion`) USING BTREE;

--
-- Indexes for table `huespedes`
--
ALTER TABLE `huespedes`
  ADD PRIMARY KEY (`ID_Huesped`),
  ADD UNIQUE KEY `DNI` (`DNI`) USING BTREE,
  ADD UNIQUE KEY `Telefono` (`Telefono`) USING BTREE,
  ADD UNIQUE KEY `Mail` (`Mail`) USING BTREE;

--
-- Indexes for table `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`ID_Reserva`),
  ADD KEY `ID_Cliente` (`ID_Huesped`),
  ADD KEY `ID_Habitacion` (`ID_Habitacion`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `habitaciones`
--
ALTER TABLE `habitaciones`
  MODIFY `ID_Habitacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `huespedes`
--
ALTER TABLE `huespedes`
  MODIFY `ID_Huesped` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservas`
--
ALTER TABLE `reservas`
  MODIFY `ID_Reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`ID_Huesped`) REFERENCES `huespedes` (`ID_Huesped`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`ID_Habitacion`) REFERENCES `habitaciones` (`ID_Habitacion`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
