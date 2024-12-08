<?php include '../db_connection.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Viaje</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
    <body>
    <?php include('../includes/header.php'); ?>
        <div class="container">
            <h2>Registrar un Nuevo Viaje</h2>
            <form action="" method="POST">
                <input type="text" name="numero" placeholder="Número de Viaje" required value="<?= isset($_POST['registrar_viaje']) ? htmlspecialchars($_POST['numero']) : ''; ?>">
                <input type="text" name="matribarco" placeholder="Matrícula del Barco" required value="<?= isset($_POST['registrar_viaje']) ? htmlspecialchars($_POST['matribarco']) : ''; ?>">
                <input type="text" name="codpatron" placeholder="Código del Patrón" required value="<?= isset($_POST['registrar_viaje']) ? htmlspecialchars($_POST['codpatron']) : ''; ?>">
                <input type="text" name="fecha" placeholder="Fecha (YYYY-MM-DD)" required value="<?= isset($_POST['registrar_viaje']) ? htmlspecialchars($_POST['fecha']) : ''; ?>">
                <input type="text" name="hora" placeholder="Hora (HH:MM)" required value="<?= isset($_POST['registrar_viaje']) ? htmlspecialchars($_POST['hora']) : ''; ?>">
                <input type="text" name="destino" placeholder="Destino" required value="<?= isset($_POST['registrar_viaje']) ? htmlspecialchars($_POST['destino']) : ''; ?>">
                <button type="submit" name="registrar_viaje">Registrar Viaje</button>
            </form>

            <?php
            if (isset($_POST['registrar_viaje'])) {
                $numero = trim($_POST['numero']);
                $matribarco = trim($_POST['matribarco']);
                $codpatron = trim($_POST['codpatron']);
                $fecha = trim($_POST['fecha']);
                $hora = trim($_POST['hora']);
                $destino = trim($_POST['destino']);

                if (empty($numero) || empty($matribarco) || empty($codpatron) || empty($fecha) || empty($hora) || empty($destino)) {
                    echo "<p class='message error'>Por favor, complete todos los campos.</p>";
                } else {

                    $stmt = $conn->prepare("SELECT * FROM viaje WHERE numero = ?");
                    $stmt->bind_param("s", $numero);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo "<p class='message error'>El número de viaje ya está registrado.</p>";
                    } else {
                        $stmt = $conn->prepare("SELECT * FROM barco WHERE matricula = ?");
                        $stmt->bind_param("s", $matribarco);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows === 0) {
                            echo "<p class='message error'>La matrícula del barco no existe.</p>";
                        } else {
                            $stmt = $conn->prepare("SELECT * FROM conductor_patron WHERE codigo = ?");
                            $stmt->bind_param("s", $codpatron);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows === 0) {
                                echo "<p class='message error'>El código del patrón no existe.</p>";
                            } else {
                                $stmt = $conn->prepare("INSERT INTO viaje (numero, matribarco, codpatron, fecha, hora, destino) VALUES (?, ?, ?, ?, ?, ?)");
                                $stmt->bind_param("ssssss", $numero, $matribarco, $codpatron, $fecha, $hora, $destino);

                                if ($stmt->execute()) {
                                    echo "<p class='message success'>Viaje registrado exitosamente.</p>";
                                } else {
                                    echo "<p class='message error'>Error al registrar el viaje: " . $conn->error . "</p>";
                                }
                            }
                        }
                    }
                    $stmt->close();
                }
                $conn->close();
            }
            ?>
        </div>
    </body>
</html>
