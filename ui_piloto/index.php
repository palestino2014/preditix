<?php
    // Incluir o script de conexão
    include "php/conexao_bd.php";

    // Consulta SQL para obter todos os dados da tabela
    $consulta = $conn->query("SELECT * FROM ativo_veiculo");

    // Verifica se há resultados
    if ($consulta->num_rows > 0) {
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Preditix Home</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/style_default.css" rel="stylesheet">
	<script src="js/php-management.js"></script>

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-light sidebar sidebar-light accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
            <div class="sidebar-brand-text"><img src="./img/prediti_logo.png" alt="logo" width="100px"></div>
            <div class="sidebar-brand-icon">
                <img src="./img/shadow_logo_hourglass.png" alt="logo" width="40px">
            </div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

	    <!-- Sidebar Toggler (Sidebar) -->
	    <div class="text-center d-none d-md-inline mt-2">
		    <button id="sidebarToggle" class="btn rounded-circle mr-3">
		    </button>
	    </div>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
        </div>

        <!-- Side Bar content -->
	    <!-- Nav Item - Assets -->
	    <li class="nav-item">
		    <a class="nav-link" href="assets.html">
			    <i class="fas fa-fw fa-truck"></i>
			    <span>Ativos</span></a>
	    </li>
	    <!-- Nav Item - OS -->
	    <li class="nav-item">
		    <a class="nav-link" href="invoice.html">
			    <i class="fas fa-fw fa-file"></i>
			    <span>Ordens de Serviço</span></a>
	    </li>
	    <!-- Nav Item - KPI -->
	    <li class="nav-item">
		    <a class="nav-link" href="kpi.html">
			    <i class="fas fa-fw fa-chart-line"></i>
			    <span>KPI</span></a>
	    </li>
	    <!-- Nav Item - Help -->
	    <li class="nav-item">
		    <a class="nav-link" href="help.html">
			    <i class="fas fa-fw fa-hands-helping"></i>
			    <span>Ajuda</span></a>
	    </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle hamburger (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                    </li>

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
                <div class="container-fluid">

	                <!-- Page Heading -->
	                <div class="d-sm-flex align-items-center justify-content-between mb-4">
		                <div>
		                </div>
		                <div class="d-sm-flex align-items-center justify-content-around">
			                <a href="./assets-registering.html" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm ms-4 " style="margin-left: 20px;"><i
					                class="fas fa-folder-plus fa-sm text-white-50"></i>&nbsp&nbspCadastrar ativos</a>
			                <a href="./maintenance-request.html" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm ms-4 " style="margin-left: 20px;"><i
					                class="fas fa-calendar-plus fa-sm text-white-50"></i>&nbsp&nbspSolicitar manutenção</a>
		                </div>
	                </div>

	                <!-- Content Row -->
	                <div class="row">

		                <!-- Begin Page Content -->
		                <div class="container-fluid">

			                <!-- DataTales Example -->
			                <div class="card shadow mb-4">
				                <div class="card-header py-3 d-flex justify-content-between">
					                <h4 class="m-0 font-weight-bold text-primary">Dashboard</h4>

					                <!-- Change style content view -->
					                <div class="d-sm-flex align-items-center justify-content-between">
						                <div>
							                <h1 class="h3 mb-0 text-gray-800"></h1>
						                </div>
						                <div class="d-sm-flex align-items-center justify-content">
							                <a href="#table-show" class="d-none d-sm-inline-block btn btn-sm shadow-sm ms-4" style="display: block;"><i
									                class="fas fa-table fa-sm"></i></a>
							                <a href="#graphs-show" class="d-none d-sm-inline-block btn btn-sm shadow-sm ms-4" style="margin-left: 10px;"><i
									                class="fas fa-chart-pie fa-sm"></i></a>
						                </div>
					                </div>
				                </div>

				                <div class="card-body">
					                <div class="table-responsive" id="table-show">
						                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
							                <thead>
								                <tr>
									                <th>Identificação</th>
									                <th colspan="2">Tipo de ativo</th>
									                <th>Localização</th>
									                <th>Status</th>
									                <th>Odômetro</th>
									                <th>Próxima preventiva</th>
									                <th>Edição</th>
								                </tr>
							                </thead>
							                <tfoot>
								                <tr>
									                <th>Identificação</th>
									                <th colspan="2">Tipo de ativo</th>
									                <th>Localização</th>
									                <th>Status</th>
									                <th>Odômetro</th>
									                <th>Próxima preventiva</th>
									                <th>Edição</th>
								                </tr>
							                </tfoot>
							                <tbody>
								                <tr>
									                <td>QLS-2H91</td>
									                <td>Veículo</td>
									                <td>Cavalo Mecânico</td>
									                <td>Hydro-Barcarena</td>
									                <td>Em Operação</td>
									                <td>52414 KM</td>
									                <td>60.000 km</td>
									                <td><i class="fas fa-pen"></i></td>
								                </tr>
							                </tbody>
						                </table>
					                </div>
					                <!-- chart view start -->
					                <div id="graphs-show">
						                <div class="row">
							                <!-- Pie Chart -->
							                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								                <div class="card shadow mb-4">
									                <!-- Card Header - Dropdown -->
									                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
										                <h6 class="m-0 font-weight-bold text-primary text-lg-center">QLS-2H91 - Veículo</h6>
										                <div class="dropdown no-arrow">
											                <a class="dropdown-toggle" href="#" role="button" id="details01"
											                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												                <i class="fas fa-plus-circle fa-sm fa-fw text-gray-400"></i>
											                </a>
											                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
											                     aria-labelledby="dropdownMenuLink">
												                <a class="dropdown-item"><b>Identificação:</b> QLS-2H94</a>
												                <a class="dropdown-item"><b>Tipo:</b> Veículo</a>
												                <a class="dropdown-item"><b>Subtipo:</b> cavalo Mecânico</a>
												                <a class="dropdown-item"><b>Localização:</b> Porto-Icoaraci</a>
												                <a class="dropdown-item"><b>Status:</b> Em Manutenção</a>
												                <a class="dropdown-item"><b>Odômetro:</b> 52414 km</a>
												                <a class="dropdown-item"><b>Próxima Preventiva:</b> 60.000 km</a>
											                </div>
										                </div>
									                </div>
									                <!-- Card Body -->
									                <div class="card-body">
										                <div class="chart-pie pt-2 pb-2">
											                <canvas id="myPieChart0"></canvas>
										                </div>
										                <div class="mt-4 text-center small">
					                                        <span class="mr-2">
					                                            <i class="fas fa-circle text-warning"></i> Em Manutenção há 5 dias
					                                        </span>
									                    </div>
									                </div>
								                </div>
							                </div>
							                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								                <div class="card shadow mb-4">
									                <!-- Card Header - Dropdown -->
									                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
										                <h6 class="m-0 font-weight-bold text-primary text-lg-center">QLS-2H91 - Veículo</h6>
										                <div class="dropdown no-arrow">
											                <a class="dropdown-toggle" href="#" role="button" id="details02"
											                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												                <i class="fas fa-plus-circle fa-sm fa-fw text-gray-400"></i>
											                </a>
											                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
											                     aria-labelledby="dropdownMenuLink">
												                <a class="dropdown-item"><b>Identificação:</b> QLS-2H94</a>
												                <a class="dropdown-item"><b>Tipo:</b> Veículo</a>
												                <a class="dropdown-item"><b>Subtipo:</b> cavalo Mecânico</a>
												                <a class="dropdown-item"><b>Localização:</b> Porto-Icoaraci</a>
												                <a class="dropdown-item"><b>Status:</b> Em Manutenção</a>
												                <a class="dropdown-item"><b>Odômetro:</b> 52414 km</a>
												                <a class="dropdown-item"><b>Próxima Preventiva:</b> 60.000 km</a>
											                </div>
										                </div>
									                </div>
									                <!-- Card Body -->
									                <div class="card-body">
										                <div class="chart-pie pt-2 pb-2">
											                <canvas id="myPieChart1"></canvas>
										                </div>
										                <div class="mt-4 text-center small">
					                                        <span class="mr-2">
					                                            <i class="fas fa-circle text-warning"></i> Em Manutenção há 5 dias
					                                        </span>
										                </div>
									                </div>
								                </div>
							                </div>
							                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
								                <div class="card shadow mb-4">
									                <!-- Card Header - Dropdown -->
									                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
										                <h6 class="m-0 font-weight-bold text-primary text-lg-center">QLS-2H91 - Veículo</h6>
										                <div class="dropdown no-arrow">
											                <a class="dropdown-toggle" href="#" role="button" id="details03"
											                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												                <i class="fas fa-plus-circle fa-sm fa-fw text-gray-400"></i>
											                </a>
											                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
											                     aria-labelledby="dropdownMenuLink">
												                <a class="dropdown-item"><b>Identificação:</b> QLS-2H94</a>
												                <a class="dropdown-item"><b>Tipo:</b> Veículo</a>
												                <a class="dropdown-item"><b>Subtipo:</b> cavalo Mecânico</a>
												                <a class="dropdown-item"><b>Localização:</b> Porto-Icoaraci</a>
												                <a class="dropdown-item"><b>Status:</b> Em Manutenção</a>
												                <a class="dropdown-item"><b>Odômetro:</b> 52414 km</a>
												                <a class="dropdown-item"><b>Próxima Preventiva:</b> 60.000 km</a>
											                </div>
										                </div>
									                </div>
									                <!-- Card Body -->
									                <div class="card-body">
										                <div class="chart-pie pt-2 pb-2">
											                <canvas id="myPieChart2"></canvas>
										                </div>
										                <div class="mt-4 text-center small">
					                                        <span class="mr-2">
					                                            <i class="fas fa-circle text-warning"></i> Em Manutenção há 5 dias
					                                        </span>
										                </div>
									                </div>
								                </div>
							                </div>
						                </div>
					                </div>
					                <!-- chart view end -->
				                </div>
			                </div>

		                </div>
		                <!-- /.container-fluid -->

	                </div>
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
    echo "Nenhum veículo encontrado.";
}

// Fechar a consulta
$consulta->close();

// Fechar a conexão
$conn->close();
?>