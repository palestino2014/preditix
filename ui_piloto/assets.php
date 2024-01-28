<?php
    // Incluir o script de conexão
    include "php/conexao_bd.php";

    // Consulta SQL para obter todos os dados da tabela
    $ativo_embarcacao = $conn->query("SELECT * FROM ativo_embarcacao");
    $ativo_implemento = $conn->query("SELECT * FROM ativo_implemento");
    $ativo_tanque = $conn->query("SELECT * FROM ativo_tanque");
    $ativo_veiculo = $conn->query("SELECT * FROM ativo_veiculo");

    // Verifica se há resultados
    if ($ativo_embarcacao || $ativo_implemento || $ativo_tanque || $ativo_veiculo -> num_rows > 0) {
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Preditix - Ativos</title>

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
        <ul class="navbar-nav bg-light sidebar sidebar-light accordion" 
        id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" 
            href="index.php">
                <div class="sidebar-brand-text">
                    <img src="./img/prediti_logo.png" 
                    alt="logo" 
                    width="100px"></div>
                <div class="sidebar-brand-icon">
                    <img src="./img/shadow_logo_hourglass.png" 
                    alt="logo" 
                    width="40px">
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline mt-2">
                <button id="sidebarToggle" 
                class="btn rounded-circle mr-3">
                </button>
            </div>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
            </div>

            <!-- Side Bar content -->
            <!-- Nav Item - Assets -->
            <li class="nav-item active">
                <a  class="nav-link" 
                    href="assets.php">
                    <i class="fas fa-fw fa-truck"></i>
                    <span>Ativos</span></a>
            </li>
            <!-- Nav Item - OS -->
            <li class="nav-item">
                <a  class="nav-link" 
                    href="invoice.html">
                    <i class="fas fa-fw fa-file"></i>
                    <span>Ordens de Serviço</span></a>
            </li>
            <!-- Nav Item - KPI -->
            <li class="nav-item">
                <a  class="nav-link" 
                    href="kpi.html">
                    <i class="fas fa-fw fa-chart-line"></i>
                    <span>KPI</span></a>
            </li>
            <!-- Nav Item - Help -->
            <li class="nav-item">
                <a  class="nav-link" 
                    href="help.html">
                    <i class="fas fa-fw fa-hands-helping"></i>
                    <span>Ajuda</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper"
             class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop"
                            class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle"
                               href="#"
                               id="searchDropdown"
                               role="button"
                               data-toggle="dropdown"
                               aria-haspopup="true"
                               aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle"
                               href="#"
                               id="userDropdown"
                               role="button"
                               data-toggle="dropdown"
                               aria-haspopup="true"
                               aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Jefferson Mendes</span>
                                <img class="img-profile rounded-circle"
                                     src="img/profile.png"
                                     alt="profile picture">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                 aria-labelledby="userDropdown">
                                <a class="dropdown-item"
                                   href="#"
                                   data-toggle="modal"
                                   data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Sair
                                </a>
                            </div>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <h1 class="h3 mb-4 text-gray-800">
                            Lista de ativos
                        </h1>

                        <!-- List of assets Start-->
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header"
                                     id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link"
                                                data-toggle="collapse"
                                                data-target="#collapseOne"
                                                aria-expanded="true"
                                                aria-controls="collapseOne">
                                                Embarcações
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne"
                                     class="collapse"
                                     aria-labelledby="headingOne"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                    <!-- Content Start-->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">TAG</th>
                                                    <th class="text-center">Tipo de Embarcação</th>
                                                    <th class="text-center">Inscrição</th>
                                                    <th class="text-center">Nome da embarcação</th>
                                                    <th class="text-center">Capacidade Volumétrica</th>
                                                    <th class="text-center">Opções</th>
                                                    <!-- Adicione mais colunas conforme necessário -->
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center">TAG</th>
                                                    <th class="text-center">Tipo de Embarcação</th>
                                                    <th class="text-center">Inscrição</th>
                                                    <th class="text-center">Nome da embarcação</th>
                                                    <th class="text-center">Capacidade Volumétrica</th>
                                                    <th class="text-center">Opções</th>
                                                    <!-- Adicione mais colunas conforme necessário -->
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                // Loop através dos resultados e exibir cada linha na tabela
                                                while ($row = $ativo_embarcacao->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?= $row["id"] ?></td>
                                                        <td class="text-center"><?= $row["tipo_embarcacao"] ?></td>
                                                        <td class="text-center"><?= $row["num_inscricao"] ?></td>
                                                        <td class="text-center"><?= $row["ano_fabricacao"] ?></td>
                                                        <td class="text-center"><?= $row["capacidade_volumetrica"] ?></td>
                                                        <td class="text-center">
                                                            <a  data-toggle="modal"
                                                                data-target="#moreInformationModal">
                                                                <i class="fas fa-plus-circle"></i>
                                                            </a>
                                                            <a href="php/atualizar_embarcacao.php">&#9998;</a>
                                                        </td>                                                       
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Content End-->
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header"
                                     id="headingFour">
                                     <h2 class="mb-0">
                                        <button class="btn btn-link"
                                                data-toggle="collapse"
                                                data-target="#collapseFour"
                                                aria-expanded="true"
                                                aria-controls="collapseFour">
                                            Implementos
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseFour"
                                     class="collapse"
                                     aria-labelledby="headingFour"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                    <!-- Content Start-->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">TAG</th>
                                                    <th class="text-center">Placa</th>
                                                    <th class="text-center">Vínculo permanente</th>
                                                    <th class="text-center">Tipo de Implemento</th>
                                                    <th class="text-center">Fabricante</th>
                                                    <th class="text-center">Modelo</th>
                                                    <th class="text-center">Ano de Fabricação</th>
                                                    <th class="text-center">Opções</th>
                                                    <!-- Adicione mais colunas conforme necessário -->
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th class="text-center">TAG</th>
                                                    <th class="text-center">Placa</th>
                                                    <th class="text-center">Vínculo permanente</th>
                                                    <th class="text-center">Tipo de Implemento</th>
                                                    <th class="text-center">Fabricante</th>
                                                    <th class="text-center">Modelo</th>
                                                    <th class="text-center">Ano de Fabricação</th>
                                                    <th class="text-center">Opções</th>
                                                    <!-- Adicione mais colunas conforme necessário -->
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                // Loop através dos resultados e exibir cada linha na tabela
                                                while ($row = $ativo_implemento->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center"><?= $row["tag"] ?></td>
                                                        <td class="text-center"><?= $row["placa"] ?></td>
                                                        <td class="text-center"><?= $row["id"] ?></td>
                                                        <td class="text-center"><?= $row["tipo_implemento"] ?></td>
                                                        <td class="text-center"><?= $row["fabricante"] ?></td>
                                                        <td class="text-center"><?= $row["modelo"] ?></td>
                                                        <td class="text-center"><?= $row["ano_fabricao"] ?></td>
                                                        <td class="text-center">
                                                            <a  data-toggle="modal"
                                                                data-target="#moreInformationModal">
                                                                <i class="fas fa-plus-circle"></i>
                                                            </a>
                                                            <a href="php/atualizar_implemento.php">&#9998;</a>
                                                        </td>                                                        <!-- Adicione mais colunas conforme necessário -->
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Content End-->
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header"
                                     id="headingTwo">
                                     <h2 class="mb-0">
                                        <button class="btn btn-link collapsed"
                                                data-toggle="collapse"
                                                data-target="#collapseTwo"
                                                aria-expanded="false"
                                                aria-controls="collapseTwo">
                                            Tanques de armazenamento
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo"
                                     class="collapse"
                                     aria-labelledby="headingTwo"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- Content Start-->
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">TAG</th>
                                                        <th class="text-center">Fabricante / Responsável técnico</th>
                                                        <th class="text-center">Ano de Fabricação</th>
                                                        <th class="text-center">Ano</th>
                                                        <th class="text-center">Capacidade Volumétrica</th>
                                                        <th class="text-center">Opções</th>
                                                        <!-- Adicione mais colunas conforme necessário -->
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-center">TAG</th>
                                                        <th class="text-center">Fabricante / Responsável técnico</th>
                                                        <th class="text-center">Ano de Fabricação</th>
                                                        <th class="text-center">Ano</th>
                                                        <th class="text-center">Capacidade Volumétrica</th>
                                                        <th class="text-center">Opções</th>
                                                        <!-- Adicione mais colunas conforme necessário -->
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    // Loop através dos resultados e exibir cada linha na tabela
                                                    while ($row = $ativo_tanque->fetch_assoc()) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?= $row["tag"] ?></td>
                                                            <td class="text-center"><?= $row["id"] ?></td>
                                                            <td class="text-center"><?= $row["anoFabricacao"] ?></td>
                                                            <td class="text-center"><?= $row["fabricante"] ?></td>
                                                            <td class="text-center"><?= $row["capacidadeVolumetrica"] ?></td>
                                                            <td class="text-center">
                                                                <a data-toggle="modal"
                                                                    data-target="#moreInformationModal">
                                                                    <i class="fas fa-plus-circle"></i>
                                                                </a>
                                                                <a href="php/atualizar_tanque.php">&#9998;</a>
                                                            </td>                                                            <!-- Adicione mais colunas conforme necessário -->
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Content End-->
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header"
                                     id="headingTwo">
                                     <h2 class="mb-0">
                                        <button class="btn btn-link collapsed"
                                                data-toggle="collapse"
                                                data-target="#collapseFive"
                                                aria-expanded="false"
                                                aria-controls="collapseFive">
                                            Veículos
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseFive"
                                     class="collapse"
                                     aria-labelledby="headingFive"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                        <!-- Content Start-->
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">TAG</th>
                                                        <th class="text-center">Placa</th>
                                                        <th class="text-center">Tipo de Veículo</th>
                                                        <th class="text-center">Fabricante</th>
                                                        <th class="text-center">Modelo</th>
                                                        <th class="text-center">Ano de Fabricação</th>
                                                        <th class="text-center">Opções</th>
                                                        <!-- Adicione mais colunas conforme necessário -->
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-center">TAG</th>
                                                        <th class="text-center">Placa</th>
                                                        <th class="text-center">Tipo de Veículo</th>
                                                        <th class="text-center">Fabricante</th>
                                                        <th class="text-center">Modelo</th>
                                                        <th class="text-center">Ano de Fabricação</th>
                                                        <th class="text-center">Opções</th>
                                                        <!-- Adicione mais colunas conforme necessário -->
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    // Loop através dos resultados e exibir cada linha na tabela
                                                    while ($row = $ativo_veiculo->fetch_assoc()) {
                                                        ?>
                                                            <tr>
                                                                <td class="text-center"><?= $row["tag"] ?></td>
                                                                <td class="text-center"><?= $row["placa"] ?></td>
                                                                <td class="text-center"><?= $row["tipo_veiculo"] ?></td>
                                                                <td class="text-center"><?= $row["fabricante"] ?></td>
                                                                <td class="text-center"><?= $row["modelo"] ?></td>
                                                                <td class="text-center"><?= $row["ano_fabricacao"] ?></td>
                                                                <td class="text-center">
                                                                    <a  data-toggle="modal"
                                                                        data-target="#moreInformationModal">
                                                                        <i class="fas fa-plus-circle"></i>
                                                                    </a>
                                                                    <a href="php/atualizar_veiculo.php">&#9998;</a>
                                                                </td>
                                                                <!-- Adicione mais colunas conforme necessário -->
                                                            </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Content End-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- List of assets End-->
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

        <!-- More information Modal-->
        <div class="modal fade" id="moreInformationModal" tabindex="-1" role="dialog" aria-labelledby="More information Modal"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Mais informações sobre o ativo:</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">An item</li>
                        <li class="list-group-item">A second item</li>
                        <li class="list-group-item">A third item</li>
                        <li class="list-group-item">A fourth item</li>
                        <li class="list-group-item">And a fifth one</li>
                    </ul>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Permanecer logado</button>
                        <a class="btn btn-primary" href="404.html">Encerrar sessão</a>
                    </div>
                </div>
            </div>
        </div>

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

            <!-- Page level plugins -->
            <script src="vendor/datatables/jquery.dataTables.min.js"></script>
            <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/datatables-demo.js"></script>

            <!-- Page level plugins -->
            <script src="vendor/chart.js/Chart.min.js"></script>

            <!-- Page level custom scripts -->
            <script src="js/demo/chart-area-demo.js"></script>
            <script src="js/demo/chart-pie-demo.js"></script>

    </body>

</html>
<?php
    } else {
        echo "Dados não encontrados.";
    }

    // Fechar a consulta
    $ativo_embarcacao->close();
    $ativo_implemento->close();
    $ativo_tanque->close();
    $ativo_veiculo->close();

    // Fechar a conexão
    $conn->close();
?>