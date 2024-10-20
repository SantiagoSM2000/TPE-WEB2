<?php
require_once "config.php";

class Model {
    protected $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);
        $this->_deploy();
    }

    private function _deploy() {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        if(count($tables) == 0) {
            $sql = <<<END
        CREATE TABLE `clients` (
            `ID_Client` int(11) NOT NULL,
            `Firstname` varchar(50) NOT NULL,
            `Lastname` varchar(50) NOT NULL,
            `Email` varchar(100) NOT NULL,
            `Phone_number` varchar(20) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        INSERT INTO `clients` (`ID_Client`, `Firstname`, `Lastname`, `Email`, `Phone_number`) VALUES
        (1, 'Juan', 'Perez', 'jp@gmail.com', '000'),
        (5, 'Marcos', 'Juarez', 'mj@gmail.com', '111');


        CREATE TABLE `reservations` (
            `ID_Reservation` int(11) NOT NULL,
            `Date` date NOT NULL,
            `Room_number` int(11) NOT NULL,
            `ID_Client` int(11) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        INSERT INTO `reservations` (`ID_Reservation`, `Date`, `Room_number`, `ID_Client`) VALUES
        (29, '2024-10-20', 202, 1),
        (30, '2024-10-21', 303, 1),
        (31, '2024-10-20', 303, 5),
        (32, '2024-10-21', 404, 5),
        (33, '2024-10-23', 505, 5);


        CREATE TABLE `users` (
            `ID_User` int(11) NOT NULL,
            `Username` varchar(50) NOT NULL,
            `Password` char(60) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        INSERT INTO `users` (`ID_User`, `Username`, `Password`) VALUES
           (1, 'webadmin', '\$2y\$10\$KpFpJvyTfLlvk1AXMT1nauLCvCc7qCupkGKhzHXudqvYh50RuYCZS');

        ALTER TABLE `clients`
        ADD PRIMARY KEY (`ID_Client`),
        ADD UNIQUE KEY `Email` (`Email`);

        ALTER TABLE `reservations`
        ADD PRIMARY KEY (`ID_Reservation`),
        ADD KEY `fk_cliente` (`ID_Client`);

        ALTER TABLE `users`
        ADD PRIMARY KEY (`ID_User`),
        ADD UNIQUE KEY `Username` (`Username`);

        ALTER TABLE `clients`
        MODIFY `ID_Client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

        ALTER TABLE `reservations`
        MODIFY `ID_Reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

        ALTER TABLE `users`
        MODIFY `ID_User` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

        ALTER TABLE `reservations`
        ADD CONSTRAINT `fk_cliente` FOREIGN KEY (`ID_Client`) REFERENCES `clients` (`ID_Client`);
        COMMIT;
    END;
        $this->db->query($sql);
        }
    }
}