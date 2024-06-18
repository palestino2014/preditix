<?php
// Verificar se os cookies de autenticação estão definidos
if(isset($_COOKIE['usuario']) && isset($_COOKIE['autenticado'])) {
    // Verificar se os cookies correspondem ao usuário autenticado
    $usuario = $_COOKIE['usuario'];
    $autenticado = $_COOKIE['autenticado'];

    // Verificar se o usuário está autenticado
    if ($autenticado === 'true') {
        // Conteúdo da página protegido
?>

<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Consulta SQL para buscar todos os registros na tabela
$sql = "SELECT * FROM ativo_tanque";
$resultado = $conn->query($sql);

// Verificar se a consulta foi bem-sucedida
if ($resultado === false) {
    die("Erro na consulta SQL: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Preditix MVP</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/style_default.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                    <div class="sidebar-brand-text"><img src="./img/prediti_logo.png" alt="logo" width="100px"></div>
                    <div class="sidebar-brand-icon">
                        <img src="./img/shadow_logo_hourglass.png" alt="logo" width="40px">
                    </div>
                </a>
                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Jefferson Mendes</span>
                            <img class="img-profile rounded-circle"
                                 src="img/profile.png" alt="profile picture">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Sair
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid p-1">
                    <!-- Page Heading -->
                    <h2>Resultados da Busca</h2>

                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
<tr>
        <th class='d-none d-sm-table-cell'>ID</th>
        <th>TAG</th>
        <th class='d-none d-sm-table-cell'>Fabricante</th>
        <th class='d-none d-sm-table-cell'>Ano de fabricação</th>
        <th>Localização</th>
        <th class='d-none d-sm-table-cell'>Capacidade Volumétrica</th>
        <th class='d-none d-sm-table-cell'>Foto</th>
        <th>Ação</th>
    </tr>

    <?php
    // Exibir os resultados em uma tabela
    while ($row = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td class='d-none d-sm-table-cell'>" . $row["id"] . "</td>";
        echo "<td>" . $row["tag"] . "</td>";
        echo "<td class='d-none d-sm-table-cell'>" . $row["fabricante"] . "</td>";
        echo "<td class='d-none d-sm-table-cell'>" . $row["anoFabricacao"] . "</td>";
        echo "<td>" . $row["localizacao"] . "</td>";
        echo "<td class='d-none d-sm-table-cell'>" . $row["capacidadeVolumetrica"] . "</td>";
        echo "<td class='d-none d-sm-table-cell'><img src='" . $row["foto"] . "' alt='Foto'></td>";
        echo "<td><button class='btn btn-primary' type='button' onclick=\"encaminharParaOutraPagina(" . $row["id"] . ")\">Encaminhar</button></td>";
        echo "</tr>";
    }
    ?>
</table>

<script>
    function encaminharParaOutraPagina(id) {
        // Redirecionar para outra página com base no ID
        window.location.href = "os_tanque.php?id=" + id;
    }
</script>
</div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Preditix 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

</div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Você realmente deseja sair?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Caso continue você terá que logar novamente.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Permanecer logado</button>
                    <a class="btn btn-primary" href="404.html">Encerrar sessão</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/script.min.js"></script>

</body>

</html>

<?php
// Fechar a conexão
$conn->close();
?>

<?php
        // Fim do conteúdo da página protegido
        exit();
    }
}

// Se os cookies não estiverem definidos ou não corresponderem ao usuário autenticado, redirecionar para a página de login
header("Location: login.php");
exit();
?>
