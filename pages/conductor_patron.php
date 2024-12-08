<?php include '../db_connection.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar, Buscar y Actualizar Patrón</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
    <body>
        <?php include('../includes/header.php'); ?>
        <div class="container">
            <h2>Registrar Nuevo Patrón</h2>
            <form action="" method="POST">
                <input type="text" name="codigo" placeholder="Código" required>
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="text" name="telefono" placeholder="Teléfono" required>
                <input type="text" name="direccion" placeholder="Dirección" required>
                <button type="submit" name="registrar">Registrar</button>
            </form>

            <?php
            if (isset($_POST['registrar'])) {
                $codigo = trim($_POST['codigo']);
                $nombre = trim($_POST['nombre']);
                $telefono = trim($_POST['telefono']);
                $direccion = trim($_POST['direccion']);

                if (empty($codigo) || empty($nombre) || empty($telefono) || empty($direccion)) {
                    echo "<p class='message error'>Por favor, complete todos los campos.</p>";
                } else {

                    $stmt = $conn->prepare("SELECT * FROM conductor_patron WHERE codigo = ?");
                    $stmt->bind_param("s", $codigo);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo "<p class='message error'>El código ya está registrado.</p>";
                    } else {
                        
                        $stmt = $conn->prepare("INSERT INTO conductor_patron (codigo, nombre, telefono, direccion) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("ssss", $codigo, $nombre, $telefono, $direccion);

                        if ($stmt->execute()) {
                            echo "<p class='message success'>Patrón registrado exitosamente.</p>";
                        } else {
                            echo "<p class='message error'>Error: " . $conn->error . "</p>";
                        }

                        $stmt->close();
                    }
                }

                $conn->close();
            }
            ?>

            <h2>Buscar Patrón</h2>
            <form action="" method="GET">
                <input type="text" name="buscar_codigo" placeholder="Código del Patrón">
                <button type="submit">Buscar</button>
            </form>

            <?php
            if (isset($_GET['buscar_codigo'])) {
                $buscar_codigo = $_GET['buscar_codigo'];
                $result = $conn->query("SELECT * FROM conductor_patron WHERE codigo = '$buscar_codigo'");

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<p>Código: " . $row['codigo'] . "</p>";
                    echo "<p>Nombre: " . $row['nombre'] . "</p>";
                    echo "<p>Teléfono: " . $row['telefono'] . "</p>";
                    echo "<p>Dirección: " . $row['direccion'] . "</p>";
                } else {
                    echo "<p class='message error'>No se encontró el patrón.</p>";
                }
            }
            ?>

            <h2>Actualizar Patrón</h2>
            <form action="" method="POST">
                <input type="text" name="codigo" placeholder="Código" required>
                <input type="text" name="nombre" placeholder="Nombre">
                <input type="text" name="telefono" placeholder="Teléfono">
                <input type="text" name="direccion" placeholder="Dirección">
                <button type="submit" name="actualizar">Actualizar</button>
            </form>

            <?php
            if (isset($_POST['actualizar'])) {
                $codigo = trim($_POST['codigo']);
                $nombre = trim($_POST['nombre']);
                $telefono = trim($_POST['telefono']);
                $direccion = trim($_POST['direccion']);

                if (empty($codigo) || empty($nombre) || empty($telefono) || empty($direccion)) {
                    echo "<p class='message error'>Por favor, complete todos los campos.</p>";
                } else {
                    
                    $stmt = $conn->prepare("SELECT * FROM conductor_patron WHERE codigo = ?");
                    $stmt->bind_param("s", $codigo);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        
                        $stmt = $conn->prepare("UPDATE conductor_patron SET nombre = ?, telefono = ?, direccion = ? WHERE codigo = ?");
                        $stmt->bind_param("ssss", $nombre, $telefono, $direccion, $codigo);

                        if ($stmt->execute()) {
                            echo "<p class='message success'>Patrón actualizado exitosamente.</p>";
                        } else {
                            echo "<p class='message error'>Error al actualizar: " . $conn->error . "</p>";
                        }

                        $stmt->close();
                    } else {
                        echo "<p class='message error'>El código ingresado no existe.</p>";
                    }
                }

                $conn->close();
            }
            ?>
        </div>
    </body>
</html>
