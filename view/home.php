<?php
require('../controller/VerificaLogado.php');
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="Bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sidebars.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="Bootstrap/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="js/jquery-1.8.2.js" type="text/javascript"></script>

    <script src="js/sidebars.js"></script>
</head>

<body class="mh-100">
    <div class="d-flex d-print-none flex-column">
        <nav class="navbar navbar-expand-lg shadow p-3 mb-2 rounded navbar-light bg-light">
            <div class="container-fluid" id="Menu">
                <a class="navbar-brand">
                    <span id="empresa"></span>
                </a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto">
                        <?php
                            if (isset($_SESSION['agenda']) and ($_SESSION['agenda'])) {
                                echo ('                                
                                <li class="nav-item dropdown">
                                <a type="button" class="rounded dropdown-toggle text-decoration-none fw-bold" id="DropAgendamento" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="icon/calendar.png" width="20" height="20" alt="Agendamento"> Agendamento</a>
                                <ul class="dropdown-menu" aria-labelledby="DropAgendamento">');
                            
                                if (isset($_SESSION['agendainclusao']) and $_SESSION['agendainclusao']) {
                                    echo('<li><a type="button" class="dropdown-item fw-bolder" Texto="Agendamento -> Inclusão" Local="AgendaInclusao.php">-> Inclusão</a></li>');
                                }
                                if (isset($_SESSION['agendaAlteracao']) and $_SESSION['agendaAlteracao']) {
                                    echo('<li><a type="button" class="dropdown-item fw-bolder" Texto="Agendamento -> Consulta" Local="AgendaConsulta.php">-> Consulta</a></li>');
                                }
                            }

                            if (isset($_SESSION['agenda']) and ($_SESSION['agenda'])) {
                                echo('</ul></li>');
                            }
                        ?>
                        <?php
                            if (isset($_SESSION['portaria']) and ($_SESSION['portaria'])) {
                                echo ('                                
                                <li class="nav-item dropdown ms-5">
                                <a type="button" class="rounded dropdown-toggle text-decoration-none fw-bold" id="DropPortaria" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="icon/calendar.png" width="20" height="20" alt="Portaria"> Portaria</a>
                                <ul class="dropdown-menu" aria-labelledby="DropPortaria">');
                            
                                if (isset($_SESSION['portariainclusao']) and $_SESSION['portariainclusao']) {
                                    echo('<li><a type="button" class="dropdown-item fw-bolder" Texto="Portaria -> Inclusão" Local="PortariaInclusao.php">-> Inclusão</a></li>');
                                }
                            }

                            if (isset($_SESSION['portaria']) and ($_SESSION['portaria'])) {
                                echo('</ul></li>');
                            }
                        ?>
                        <?php
                            if (isset($_SESSION['encartes']) and ($_SESSION['encartes'])) {
                                echo ('                                
                                <li class="nav-item dropdown ms-5">
                                <a type="button" class="rounded dropdown-toggle text-decoration-none fw-bold" id="DropEncartes" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="icon/menu_book.svg" width="20" height="20" alt="Agendamento"> Encartes</a>
                                <ul class="dropdown-menu" aria-labelledby="DropAgendamento">');
                            
                                if (isset($_SESSION['encarteinclusao']) and $_SESSION['encarteinclusao']) {
                                    echo('<li><a type="button" class="dropdown-item fw-bolder" Texto="Encartes -> Inclusão" Local="EncarteInclusao.php">-> Inclusão</a></li>');
                                }
                                if (isset($_SESSION['encarteAlteracao']) and $_SESSION['encarteAlteracao']) {
                                    echo('<li><a type="button" class="dropdown-item fw-bolder" Texto="Encartes -> Consulta" Local="EncarteConsulta.php">-> Consulta</a></li>');
                                }
                            }

                            if (isset($_SESSION['encartes']) and ($_SESSION['encartes'])) {
                                echo('</ul></li>');
                            }
                        ?>   
                        <?php
                            if (isset($_SESSION['validade']) and ($_SESSION['validade'])) {
                                echo ('                                
                                <li class="nav-item dropdown ms-5">
                                    <a type="button" Local="ConfereValidade.php" class="rounded text-decoration-none fw-bold"><img src="icon/checklist.svg" width="20" height="20" alt="Agendamento"> Consulta Validade</a>
                                </li>
                                ');
                            }
                        ?> 
                        <?php
                            if (isset($_SESSION['CheckRelatorio']) and ($_SESSION['CheckRelatorio'])) {
                                echo ('                                
                                <li class="nav-item dropdown ms-5">
                                <a type="button" class="rounded dropdown-toggle text-decoration-none fw-bold" id="DropRelatorios" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="icon/menu_book.svg" width="20" height="20" alt="Relatórios"> Relatórios</a>
                                <ul class="dropdown-menu" aria-labelledby="DropRelatorios">');
                            
                                if (isset($_SESSION['CheckRelAgenda']) and $_SESSION['CheckRelAgenda']) {
                                    echo('<li><a type="button" class="dropdown-item fw-bolder" Texto="Relatório -> Agendamento" Local="AgendaRelatorio.php">-> Agendamentos</a></li>');
                                } 
                                if (isset($_SESSION['CheckGerEncarte']) and $_SESSION['CheckGerEncarte']) {
                                    echo('<li><a type="button" class="dropdown-item fw-bolder" Texto="Relatório -> Encartes" Local="AgendaRelatorio.php">-> Encartes</a></li>');
                                } 
                                if (isset($_SESSION['CheckRelValidade']) and $_SESSION['CheckRelValidade']) {
                                    echo('<li><a type="button" class="dropdown-item fw-bolder" Texto="Relatório -> Validade" Local="AgendaRelatorio.php">-> Validade</a></li>');
                                } 
                                if (isset($_SESSION['CheckRelPortaria']) and $_SESSION['CheckRelPortaria']) {
                                    echo('<li><a type="button" class="dropdown-item fw-bolder" Texto="Relatório -> Portaria" Local="AgendaRelatorio.php">-> Portaria</a></li>');
                                } 
                            }

                            if (isset($_SESSION['CheckRelatorio']) and ($_SESSION['CheckRelatorio'])) {
                                echo('</ul></li>');
                            }
                        ?>  

                    </ul>
                    <ul class="navbar-nav justify-content-end">
                        <li class="nav-item dropdown me-3">
                            <a class="nav-link dropdown-toggle text-black fw-bold" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="icon/user.svg" width="20" height="20" alt="Configs">Bem Vindo <span class="fw-bold" id="Usuario"><?php echo $_SESSION['login'] ?></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                               <?php
                                    if (isset($_SESSION['login']) and ($_SESSION['admin'])) {
                                        echo ('<li><a type="button" class="dropdown-item" Texto="Gerenciamento de Usuários" Local="ConfiguracaoUsuarios.php"><img src="icon/manageUsers.svg" width="20" height="20" alt="Usuario"> Gerenciar Usuários</a></li><hr>');
                                    }
                                    if (isset($_SESSION['GerenciaAgenda']) and ($_SESSION['GerenciaAgenda'])) {
                                        echo ('<li><a type="button" class="dropdown-item" Local="ConfiguracaoAgenda.php">-> Agendamento</a></li><hr>');   
                                    }
                                    if (isset($_SESSION['GerenciaEncarte']) and ($_SESSION['GerenciaEncarte'])) {
                                        echo('<li><a type="button" class="dropdown-item" Local="#">-> Encartes</a></li><hr>');
                                    }
                                    if (isset($_SESSION['GerenciaValidade']) and ($_SESSION['GerenciaValidade'])) {
                                        echo('<li><a type="button" class="dropdown-item" Local="Configuracoes.php">-> Validade</a></li><hr>');
                                    }
                                    
                                ?>
                                <li id="Sair"><a type="button" class="dropdown-item" Local="#"><img src="icon/logout.svg" width="20" height="20" alt="Sair"> Sair</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="container-fluid d-flex justify-content-center d-print-none mb-2"><span id="NomedoMenu" class="text-secondary fw-bold text-decoration-underline"></span></div>
    <div id="Paginas"></div>
</body>

</html>

<script>
    $(document).ready(function() {
        $("#Menu").find("a").click(function() {
            if ($(this).attr("Local") != "#") {
                $("#NomedoMenu").html($(this).attr("Texto"));
                $("#Paginas").load($(this).attr("Local"));
            }

        });
    });
    $('#Sair').click(function() {
        window.location.href = ('../controller/logout.php');
    });
</script>