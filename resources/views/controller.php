<?php
// http://localhost/view.html
//recebe a requisicao
$nome = $_POST['nome'];
$tel = $_POST['telefone'];
$email = $_POST['email'];
$upId = $_POST['upid'];
$delId = $_POST['deid'];

if (isset($_POST['submit'])) 
{
    switch ($_POST['submit']) {
        case 'Salvar':
            inserir($nome, $tel, $email);
            break;
        case 'Alterar':
            alterar($upId, $nome, $tel, $email);
            break;
        case 'Deletar':
            deletar($delId);
            break;
        case 'Visualizar':
            visualizar();
            break;
    }
}

//conecta com o banco de dados
function connect()
{
    $link = mysqli_connect("localhost", "root", "", "aula");   

    if($link === false)
        die("ERROR: Could not connect." . mysqli_connect_error());
    else
        return $link;
}

//funcoes crud
function inserir($nome, $telefone, $email)
{
    $link = connect();
    $sql = "INSERT INTO clientes (primeiroNome, telefone, email) VALUES ('$nome', '$telefone', '$email')";

    if(mysqli_query($link, $sql)){
        echo "Cliente inserido. Retornando . . .";
        header("Refresh: 3;url=view.html");
    } else{
        echo "ERROR: $sql. " . mysqli_error($link);
    }
}

function alterar($id, $nome, $telefone, $email)
{
    $link = connect();

    $sql = "UPDATE clientes SET primeiroNome = '$nome', telefone = '$telefone', email = '$email' WHERE PersonID = '$id'";

    if(mysqli_query($link, $sql)){
        echo "Cliente alterado. Retornando . . .";
        header("Refresh: 3;url=view.html");
    } else{
        echo "ERROR: $sql. " . mysqli_error($link);
    }
}

function deletar($id)
{
    $link = connect();

    $sql = "DELETE FROM clientes WHERE PersonID = '$id'";

    if(mysqli_query($link, $sql)){
        echo "Cliente deletado. Retornando . . .";
        header("Refresh: 3;url=view.html");
    } else{
        echo "ERROR: $sql. " . mysqli_error($link);
    }
}

function visualizar()
{
    $link = connect();

    $sql = "SELECT * FROM clientes";
    $result = mysqli_query($link, $sql);

    echo"<table border='1'>";
    echo"<tr><td>ID</td><td>Nome</td><td>Telefone</td><td>Email</td><tr>";
        while($row = mysqli_fetch_assoc($result))
            echo "<tr><td>{$row['id']}</td><td>{$row['primeiroNome']}</td><td>{$row['telefone']}</td><td>{$row['email']}</td><tr>";
}