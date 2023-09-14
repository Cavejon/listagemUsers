<?php
session_start();
include_once("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Listar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body class="row">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" style="margin-left: 2rem;" href="#">CRUD PHP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cad_usuario.php">Cadastre-se</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Listar Usuários</a>
                </li>
            </ul>
        </div>
    </nav>

    <h3 class="card-title text-center text-danger mt-4 mb-4 h2 ">Listagem de usuários</h3>

    <?php
    $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);

    //Receber o número da página 
    $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

    //Setar itens por página
    $qnt_result_pg = 3;

    //Calcular o inicio da visualização
    $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;


    $result_usuarios = "SELECT * FROM usuarios LIMIT $inicio, $qnt_result_pg";
    $resultado_usuarios = mysqli_query($conn, $result_usuarios);

    while ($row_usuario = mysqli_fetch_assoc($resultado_usuarios)) {

        echo "<div class='card container col-2' style='width: 18rem;'>";
                echo "<ul class='list-group list-group-flush'>";
                echo "<li class='list-group-item'>ID: " . $row_usuario['id'] . "</li>";
                echo "<li class='list-group-item'>Nome: " . $row_usuario['nome'] . "</li>";
                echo "<li class='list-group-item' style='height:4rem'>E-mail: " . $row_usuario['email'] . "</li>";
                echo "<div class='d-flex justify-content-center'>";
                echo "<a  href='edit_usuario.php?id=". $row_usuario['id']." ' class='text-decoration-none text-center p-2 text-danger'>Editar</a>";
                echo "<a  href='proc_apagar_usuario.php?id=". $row_usuario['id'] ." ' class='text-decoration-none text-center p-2 text-danger'>Apagar</a>";
                echo "</div>";
            echo "</ul>";
        echo "</div>";

    }
    ?>
    </div>

    <?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }

    //Paginação - somar a quantidade de usuários
    $result_pg = "SELECT COUNT(id) AS num_result FROM usuarios";
    $resultado_pg = mysqli_query($conn, $result_pg);
    $row_pg = mysqli_fetch_assoc($resultado_pg);
    //echo $row_pg['num_result'];
    //Quantidade de páginas que o site contém
    $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

    //Limitar os link antes e depois
    $max_links = 2;

    echo "<div class='container text-center mt-4 d-flex justify-content-center'>";

    echo "<a href='index.php?pagina=1' class='text-decoration-none p-2 text-muted'>Primeira Página </a>";

    for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
        if ($pag_ant >= 1) {
            echo "<a href='index.php?pagina=$pag_ant ' class='text-decoration-none p-2 text-muted'>$pag_ant </a>";
        }

    }
    echo "<a href='#' class='text-decoration-none p-2 text-muted'>$pagina </a>";

    for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
        if ($pag_dep <= $quantidade_pg) {
            echo "<a href='index.php?pagina=$pag_dep' class='text-decoration-none p-2 text-muted'>$pag_dep </a>";
        }

    }

    echo "<a href='index.php?pagina=$quantidade_pg' class='text-decoration-none p-2 text-muted'>Ultima Página</a>";

    echo "</div>";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>