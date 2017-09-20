@extends('templates.default')

@section('stylesheets')
  <link href="{{ asset('css/parsley.css') }}" rel="stylesheet">
@endsection

@section('dados_pessoais')
<div class="row">
    <fieldset class="scheduler-border">
      <legend class="scheduler-border">Dados Pessoais</legend>
      {!! Form::open(array('route' => 'dados.pessoais', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
        
        <div class="row">
          {!! Form::label('nome', trans('dados_pessoais.nome'), ['class' => 'col-md-4 control-label'])!!}
          <div class="col-md-4">
            {!! Form::text('nome', $dados['nome'] ?: '' , ['class' => 'form-control input-md formhorizontal']) !!}
          </div>
        </div>

        <div class="row">
          {!! Form::label('data_nascimento', trans('dados_pessoais.data_nascimento'), ['class' => 'col-md-4 control-label'])!!}
          <div class="col-md-4">
            {!! Form::text('data_nascimento', $dados['data_nascimento'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'required' => '']) !!}
          </div>
        </div>

        <div class="row">
          {!! Form::label('numerorg', trans('dados_pessoais.rg'), ['class' => 'col-md-4 control-label'])!!}
          <div class="col-md-4">
            {!! Form::text('numerorg', $dados['numerorg'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'required' => '']) !!}
          </div>
        </div>
        
        <div class="row">
          {!! Form::label('endereco', trans('dados_pessoais.endereco'), ['class' => 'col-md-4 control-label'])!!}
          <div class="col-md-4">
            {!! Form::text('endereco', $dados['endereco'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'required' => '']) !!}
          </div>
        </div>

        <div class="row">
          {!! Form::label('cep', trans('dados_pessoais.cep'), ['class' => 'col-md-4 control-label'])!!}
          <div class="col-md-4">
            {!! Form::text('cep', $dados['cep'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'required' => '']) !!}
          </div>
        </div>

        <div class="row">
          {!! Form::label('country', trans('dados_pessoais.pais'), ['class' => 'col-md-4 control-label'])!!}
          <div class="col-md-4">
            {!! Form::select('country', ['' => 'Select'] +$countries,'',array('class'=>'form-control','id'=>'country','style'=>'width:350px;'));!!}
          </div>
        </div>

        <div class="row">
          {!! Form::label('state', trans('dados_pessoais.estado'), ['class' => 'col-md-4 control-label', 'required' => '']) !!}
          <div class="col-md-4">
            <select name="state" id="state" class="form-control" style="width:350px"></select>
          </div>
        </div>

        <div class="row">
          {!! Form::label('city', trans('dados_pessoais.cidade'), ['class' => 'col-md-4 control-label', 'required' => '']) !!}
          <div class="col-md-4">
            <select name="city" id="city" class="form-control" style="width:350px"></select>
          </div>
        </div>
        
        <div class="row">
          {!! Form::label('celular', trans('dados_pessoais.celular'), ['class' => 'col-md-4 control-label'])!!}
          <div class="col-md-4">
            {!! Form::text('celular', $dados['celular'] ?: '' , ['class' => 'form-control input-md formhorizontal', 'placeholder' => '(DD)#######', 'required' => '']) !!}
          </div>
        </div>
        
        <div class="form-group">
          <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
              {!! Form::submit(trans('dados_pessoais.menu_enviar'), ['class' => 'btn btn-primary btn-lg register-submit']) !!}
            </div>
          </div>
        </div>

      {!! Form::close() !!}
    </fieldset>
</div>
@endsection

@section('scripts')
  <script src="{{ asset('js/parsley.min.js') }}"></script>
  <script src="{{ asset('i18n/pt-br.js') }}"></script>
@endsection

@section('post-script')
<script type="text/javascript">
    $('#country').change(function(){
    var countryID = $(this).val();    
    if(countryID){
        $.ajax({
           type:"GET",
           url:"{{url('api/get-state-list')}}?country_id="+countryID,
           success:function(res){               
            if(res){
                $("#state").empty();
                $("#state").append('<option>Select</option>');
                $.each(res,function(key,value){
                    $("#state").append('<option value="'+key+'">'+value+'</option>');
                });
           
            }else{
               $("#state").empty();
            }
           }
        });
    }else{
        $("#state").empty();
        $("#city").empty();
    }      
   });
    $('#state').on('change',function(){
    var stateID = $(this).val();    
    if(stateID){
        $.ajax({
           type:"GET",
           url:"{{url('api/get-city-list')}}?state_id="+stateID,
           success:function(res){               
            if(res){
                $("#city").empty();
                $.each(res,function(key,value){
                    $("#city").append('<option value="'+key+'">'+value+'</option>');
                });
           
            }else{
               $("#city").empty();
            }
           }
        });
    }else{
        $("#city").empty();
    }
        
   });
</script>
    {{-- <script type="text/javascript">
        $('select[name=estado]').change(function () {
            var idEstado = $(this).val();

            $.get('{{URL::to('/')}}/get-cidades/' + idEstado, function (cidades) {
                $('select[name=cidade]').empty();
                $.each(cidades, function (key, value) {
                    $('select[name=cidade]').append('<option value=' + value.id + '>' + value.cidade + '</option>');
                });
            });
        });

    </script> --}}
@endsection