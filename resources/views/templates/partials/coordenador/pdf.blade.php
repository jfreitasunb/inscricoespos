<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        h2 {text-align:center;}
        label {font-weight: bold;}
    </style>
</head>

<body>
    <h2>Ficha de Inscrição - {{ $dados_candidato_para_relatorio['programa_pretendido'] }} {{ $dados_candidato_para_relatorio['area_pos'] ? ' - '.$dados_candidato_para_relatorio['area_pos']: '' }}</h2>
    <footer></footer>
    <div>
        <div class="form-group"></div>
    </div>
    <form>
        <div class="row">
            <label class="control-label">Nome </label>{{ $dados_candidato_para_relatorio['nome'] }}
        </div>
            <div class="col-md-3 col-sm-4">
                <div class="form-group">
                    <label class="control-label">Data de nascimento</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="form-group">
                    <label class="control-label">Idade </label>
                    <input class="form-control" type="text">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label class="control-label">Label</label>
                    <input class="form-control" type="text">
                </div>
            </div>
        </div>
    </form>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>