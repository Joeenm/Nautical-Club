<?php include '../db_connection.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe de Viajes por Barco</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
    <body>
    <?php include('../includes/header.php'); ?>
        <div class="container">
            <h2>Informe de Viajes por Barco</h2>
            <form action="" method="GET">
                <input type="text" name="matricula" placeholder="Matrícula del Barco" required>
                <button type="submit">Buscar</button>
            </form>

            <?php
            if (isset($_GET['matricula'])) {
                $matricula = $_GET['matricula'];
                $result = $conn->query("SELECT * FROM viaje WHERE matribarco = '$matricula'");

                if ($result->num_rows > 0) {
                    echo "<table>
                            <tr>
                                <th>Número</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Destino</th>
                                <th>Código del Patrón</th>
                            </tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['numero']}</td>
                                <td>{$row['fecha']}</td>
                                <td>{$row['hora']}</td>
                                <td>{$row['destino']}</td>
                                <td>{$row['codpatron']}</td>
                            </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p class='message error'>No se encontraron viajes para este barco.</p>";
                }
            }
            ?>
        </div>
    </body>
</html>
