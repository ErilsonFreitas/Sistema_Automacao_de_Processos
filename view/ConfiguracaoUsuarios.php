<?php
require('../controller/VerificaLogado.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Usuarios</title>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col col-2 border p-2">
                <div class="container bg-success text-center shadow p-2 rounded" type="button" style="height: 50px;" id="AdicionaUser">
                    <span class="text text-white">Adicionar Usuário</span>
                </div>
                <div class="container bg-primary text-center mt-2 p-2 rounded" type="button" style="height: 50px;" id="PermissaoUser">
                    <span class="text text-white">Gerenciar Permissões</span>
                </div>
            </div>
            <div class="col border p-2" id="DivCadastro">
                <span class="fw-bold">Cadastro de Usuário:</span>
                <hr>
                <div id="camposCadastro" class="mt-2">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="InputUser">Usuario</span>
                        <input type="text" class="form-control" id="user" aria-label="Tipo" aria-describedby="InputUser">
                    </div>
                    <fieldset id="inputSenhas" disabled>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="InputSenha">informe a Senha</span>
                            <input type="password" class="form-control" id="pass1" aria-label="Tipo" aria-describedby="InputSenha">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="InputSenha">Confirme a Senha</span>
                            <input type="password" class="form-control " id="pass2" aria-label="Tipo" aria-describedby="InputSenha">
                        </div>
                    </fieldset>
                    <div class="d-flex justify-content-end ">
                        <button type="button" id="ConsultarUsuario" class="btn btn-success mt-2 d-none">Buscar Usuário</button>
                    </div>
                </div>
            </div>

            <div class="col border p-2" id="DivPermissoes">
                <span class="fw-bold">Permissões:</span>
                <hr>
                <fieldset id="blocodePermissoes" disabled>
                    <div id="permissoes" class="mt-4">
                        <div class="row">
                            <div class="col">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="UsuarioAtivo" checked>
                                    <label class="form-check-label" for="UsuarioAtivo">Usuário Ativo ?</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="UsuarioAdm">
                                    <label class="form-check-label" for="UsuarioAdm">Usuário Administrador ?</label>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <a href="#collapseBodyAgenda" class="card-header collapse-indicator-plus" id="NameColAgenda" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseIndicatorPlus">
                                Agendamento
                            </a>

                            <div id="collapseBodyAgenda" class="collapse" aria-labelledby="NameColAgenda" data-bs-parent="#permissoes">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="CheckAgenda" id="CheckAgenda">
                                        <label class="form-check-label fw-bold" for="CheckAgenda">
                                            Ativa Agendamento
                                        </label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="CheckAgendaInclusao" id="CheckAgendaInclusao">
                                            <label class="form-check-label" for="CheckAgendaInclusao">Inclusão</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="CheckAgendaAlteracao">
                                            <label class="form-check-label" for="CheckAgendaAlteracao">Consulta</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <a href="#collapseBodyPortaria" class="card-header collapse-indicator-plus" id="NameColPortaria" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseIndicatorPlus">
                                Portaria
                            </a>

                            <div id="collapseBodyPortaria" class="collapse" aria-labelledby="NameColPortaria" data-bs-parent="#permissoes">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="CheckPortaria" id="CheckPortaria">
                                        <label class="form-check-label fw-bold" for="CheckPortaria">
                                            Ativa Portaria
                                        </label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="CheckPortariaInclusao" id="CheckPortariaInclusao">
                                            <label class="form-check-label" for="CheckPortariaInclusao">Inclusão</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="CheckPortariaAlteracao">
                                            <label class="form-check-label" for="CheckPortariaAlteracao">Consulta</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-2">
                            <a href="#collapseBodyEncarte" class="card-header collapse-indicator-plus" id="NameColEncarte" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseIndicatorPlus">
                                Encartes
                            </a>

                            <div id="collapseBodyEncarte" class="collapse p-2" aria-labelledby="NameColEncarte" data-bs-parent="#permissoes">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="CheckEncartes">
                                    <label class="form-check-label fw-bold" for="CheckEncartes">
                                        Encartes
                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="CheckEncartesInclusao">
                                        <label class="form-check-label" for="CheckEncartesInclusao">Inclusão</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="CheckEncartesAlteracao">
                                        <label class="form-check-label" for="CheckEncartesAlteracao">Consulta</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-2">
                            <a href="#collapseBodyValidade" class="card-header collapse-indicator-plus" id="NameColValidade" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseIndicatorPlus">
                                Validade
                            </a>

                            <div id="collapseBodyValidade" class="collapse p-2" aria-labelledby="NameColValidade" data-bs-parent="#permissoes">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="CheckValidade">
                                    <label class="form-check-label fw-bold" for="CheckValidade">
                                        Validade
                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="CheckValidadeInclusao">
                                        <label class="form-check-label" for="CheckValidadeInclusao">Inclusão</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="CheckValidadeAlteracao">
                                        <label class="form-check-label" for="CheckValidadeAlteracao">Consulta</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-2">
                            <a href="#collapseBodyGerencia" class="card-header collapse-indicator-plus" id="NameColGerencia" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseIndicatorPlus">
                                Gerencia
                            </a>

                            <div id="collapseBodyGerencia" class="collapse p-2" aria-labelledby="NameColGerencia" data-bs-parent="#permissoes">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="CheckGerencia">
                                    <label class="form-check-label fw-bold" for="CheckGerencia">
                                        Gerenciamento
                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="CheckGerAgenda">
                                        <label class="form-check-label" for="CheckGerAgenda">Agendamento</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="CheckGerEncarte">
                                        <label class="form-check-label" for="CheckGerEncarte">Encartes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="CheckGerValidade">
                                        <label class="form-check-label" for="CheckGerValidade">Validade</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-2">
                            <a href="#collapseBodyRelatorio" class="card-header collapse-indicator-plus" id="NameColRelatorio" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapseIndicatorPlus">
                                Relatório
                            </a>

                            <div id="collapseBodyRelatorio" class="collapse p-2" aria-labelledby="NameColRelatorio" data-bs-parent="#permissoes">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="CheckRelatorio">
                                    <label class="form-check-label fw-bold" for="CheckRelatorio">
                                        Relatórios
                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="CheckRelAgenda">
                                        <label class="form-check-label" for="CheckRelAgenda">Agendamento</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="CheckRelEncarte">
                                        <label class="form-check-label" for="CheckRelEncarte">Encartes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="CheckRelPortaria">
                                        <label class="form-check-label" for="CheckRelPortaria">Portaria</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="CheckRelValidade">
                                        <label class="form-check-label" for="CheckRelValidade">Validade</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" id="SalvarUsuario" class="btn btn-success mt-2 d-none">Salvar</button>
                        <button type="button" id="AtualizarUsuario" class="btn btn-success mt-2 d-none">Atualizar Usuário</button>
                    </div>
                </fieldset>
            </div>


        </div>

    </div>

    </div>
</body>

</html>

<script>
    $(document).ready(function() {
        var inputs = [];
        cheks = [];
    });
    $('#AdicionaUser').click(function() {
        $('#AtualizarUsuario').addClass('d-none');
        $('#ConsultarUsuario').addClass('d-none');
        $('#SalvarUsuario').removeClass('d-none');
        $('#blocodePermissoes').removeClass('d-none');
        $("#blocodePermissoes").prop('disabled', false);
        $("#inputSenhas").prop('disabled', false);
    });
    $('#PermissaoUser').click(function() {
        $('#SalvarUsuario').addClass('d-none');
        $('#ConsultarUsuario').removeClass('d-none');
        $('#AtualizarUsuario').removeClass('d-none');
        $("#inputSenhas").prop('disabled', true);
        $("#blocodePermissoes").prop('disabled', true);
    });
    $('#ConsultarUsuario').click(function() {
        usuario = $('#user').val();
        User("consulta", usuario);
    })
    $('#AtualizarUsuario').click(function() {
        if ($('#pass1').val() == "" && $('#pass2').val() == "") {
            if ($('#pass1').val() === $('#pass2').val()) {
                pass = $('#pass1').val();
                PegaDadoFormulario("update", pass);
            } else {
                alert("As senhas não correspondem.");
            }
        } else {
            PegaDadoFormulario("update", pass);
        }
    })

    function PegaDadoFormulario(metodo, pass = null) {
        permissoes = {
            "agenda": {
                "ativo": $('#CheckAgenda').is(':checked'),
                "permissao": {
                    "inclusao": $('#CheckAgendaInclusao').is(':checked'),
                    "alteracao": $('#CheckAgendaAlteracao').is(':checked'),
                }
            },
            "portaria": {
                "ativo": $('#CheckPortaria').is(':checked'),
                "permissao": {
                    "inclusao": $('#CheckPortariaInclusao').is(':checked'),
                    "alteracao": $('#CheckPortariaAlteracao').is(':checked'),
                }
            },
            "encartes": {
                "ativo": $('#CheckEncartes').is(':checked'),
                "permissao": {
                    "inclusao": $('#CheckEncartesInclusao').is(':checked'),
                    "alteracao": $('#CheckEncartesAlteracao').is(':checked'),
                }
            },
            "validade": {
                "ativo": $('#CheckValidade').is(':checked'),
                "permissao": {
                    "inclusao": $('#CheckValidadeInclusao').is(':checked'),
                    "alteracao": $('#CheckValidadeAlteracao').is(':checked'),
                }
            },
            "gerencia": {
                "ativo": $('#CheckGerencia').is(':checked'),
                "permissao": {
                    "Agenda": $('#CheckGerAgenda').is(':checked'),
                    "encarte": $('#CheckGerEncarte').is(':checked'),
                    "validade": $('#CheckGerValidade').is(':checked')
                }
            },
            "relatorio": {
                "ativo": $('#CheckRelatorio').is(':checked'),
                "permissao": {
                    "Agenda": $('#CheckRelAgenda').is(':checked'),
                    "encarte": $('#CheckRelEncarte').is(':checked'),
                    "validade": $('#CheckRelValidade').is(':checked'),
                    "portaria": $('#CheckRelPortaria').is(':checked')
                }


            }
        }
        ativo = $('#UsuarioAtivo').is(':checked') ? 1 : 0;
        admin = $('#UsuarioAdm').is(':checked') ? 1 : 0;
        usuario = $('#user').val();
        User(metodo, usuario, permissoes, admin, ativo, pass);
    }
    $('#SalvarUsuario').click(function() {
        if ($('#pass1').val() === $('#pass2').val()) {
            pass = $('#pass1').val();

            PegaDadoFormulario("inclusao", pass);
        } else {
            alert("As senhas não correspondem.");
        }
    });
    function Check(id, bool) {
        $("#" + id).prop("checked", JSON.parse(bool));
    }

    function CheckPermissoes(id, bool) {
        $("#" + id).prop("checked", JSON.parse(bool));
    }

    function User(metodo, usuario, acesso = null, admin = null, ativo = null, pass = null) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../controller/ConfiguracoesUsuarios.php',
            data: {
                metodo: metodo,
                acesso: acesso,
                admin: admin,
                ativo: ativo,
                user: usuario,
                pass: pass
            },
            cache: false,
            success: function(dado) {
                console.log(dado)
                if (metodo == 'consulta') {
                    if (dado.msg == "") {
                        $('#SalvarUsuario').addClass('d-none');
                        $('#AtualizarUsuario').removeClass('d-none');
                        Check("UsuarioAtivo", dado.dados['ativo']);
                        Check("UsuarioAdm", dado.dados['useradmin']);

                        permissoes = JSON.parse(dado.dados['moduloAcesso']);

                        CheckPermissoes("CheckAgenda", permissoes['agenda']['ativo'])
                        CheckPermissoes("CheckAgendaInclusao", permissoes['agenda']['permissao']['inclusao'])
                        CheckPermissoes("CheckAgendaAlteracao", permissoes['agenda']['permissao']['alteracao'])

                        CheckPermissoes("CheckPortaria", permissoes['portaria']['ativo'])
                        CheckPermissoes("CheckPortariaInclusao", permissoes['portaria']['permissao']['inclusao'])
                        CheckPermissoes("CheckPortariaAlteracao", permissoes['portaria']['permissao']['alteracao'])

                        CheckPermissoes("CheckEncartes", permissoes['encartes']['ativo'])
                        CheckPermissoes("CheckEncartesInclusao", permissoes['encartes']['permissao']['inclusao'])
                        CheckPermissoes("CheckEncartesAlteracao", permissoes['encartes']['permissao']['alteracao'])

                        CheckPermissoes("CheckValidade", permissoes['validade']['ativo'])
                        CheckPermissoes("CheckValidadeInclusao", permissoes['validade']['permissao']['inclusao'])
                        CheckPermissoes("CheckValidadeAlteracao", permissoes['validade']['permissao']['alteracao'])

                        CheckPermissoes("CheckGerencia", permissoes['gerencia']['ativo'])
                        CheckPermissoes("CheckGerAgenda", permissoes['gerencia']['permissao']['Agenda'])
                        CheckPermissoes("CheckGerEncarte", permissoes['gerencia']['permissao']['encarte'])
                        CheckPermissoes("CheckGerValidade", permissoes['gerencia']['permissao']['validade'])

                        CheckPermissoes("CheckRelatorio", permissoes['relatorio']['ativo'])
                        CheckPermissoes("CheckRelAgenda", permissoes['relatorio']['permissao']['Agenda'])
                        CheckPermissoes("CheckGerEncarte", permissoes['relatorio']['permissao']['encarte'])
                        CheckPermissoes("CheckRelValidade", permissoes['relatorio']['permissao']['validade'])
                        CheckPermissoes("CheckRelPortaria", permissoes['relatorio']['permissao']['portaria'])

                        $("#blocodePermissoes").prop('disabled', false);
                        $("#inputSenhas").prop('disabled', false);

                    } else {
                        alert(dado.msg);
                    }

                } else {
                    alert(dado.msg);
                }

            }
        });
    }

</script>