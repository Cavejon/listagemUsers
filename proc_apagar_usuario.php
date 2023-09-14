<?php

session_start();
include_once("conexao.php");
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    $result_usuario = "DELETE FROM usuarios WHERE id='$id'";
    $resultado_usuario = mysqli_query($conn, $result_usuario);

    if (mysqli_affected_rows($conn)) {
        $_SESSION['msg'] = "<p class='text-center text-success h5 mt-4'>Usuário apagado com sucesso</p>";
        header("Location: index.php");
    } else {
        $_SESSION['msg'] = "<p class='text-center text-danger h5 mt-4'>Erro: Usuário não foi apagado</p>";
        header("Location: index.php");
    }
} else {
    $_SESSION['msg'] = "<p class='text-center text-danger h5 mt-4'>Necessário selecionar o usuário</p>";
    header("Location: index.php");
}
?>