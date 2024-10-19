<?php
class Model {
    protected $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);
        $this->deploy();
    }

    private function _deploy() {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if(count($tables) == 0) {
            $sql =<<<END
            CREATE TABLE `clientes` (
                `ID_Cliente` int(11) NOT NULL,
                `Nombre` varchar(50) NOT NULL,
                `Apellido` varchar(50) NOT NULL,
                `Email` varchar(100) NOT NULL,
                `NombreUsuario` varchar(150) NOT NULL,
                `Contraseña` char(60) NOT NULL,
                `Telefono` varchar(20) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            CREATE TABLE `reservas` (
                `ID_Reserva` int(11) NOT NULL,
                `Fecha` date NOT NULL,
                `Nro_Habitacion` int(11) NOT NULL,
                `ID_Cliente` int(11) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

            ALTER TABLE `clientes`
            ADD PRIMARY KEY (`ID_Cliente`),
            ADD UNIQUE KEY `Email` (`Email`);

            --
            -- Indexes for table `reservas`
            --
            ALTER TABLE `reservas`
            ADD PRIMARY KEY (`ID_Reserva`),
            ADD KEY `fk_cliente` (`ID_Cliente`);

            --
            -- AUTO_INCREMENT for dumped tables
            --

            --
            -- AUTO_INCREMENT for table `clientes`
            --
            ALTER TABLE `clientes`
            MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

            --
            -- AUTO_INCREMENT for table `reservas`
            --
            ALTER TABLE `reservas`
            MODIFY `ID_Reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

            --
            -- Constraints for dumped tables
            --

            --
            -- Constraints for table `reservas`
            --
            ALTER TABLE `reservas`
            ADD CONSTRAINT `fk_cliente` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID_Cliente`);
            COMMIT;

            
            // Copiamos las tablas del archivo exportado de phpmyadmin.
		END;
        $this->db->query($sql);
  }
}

}