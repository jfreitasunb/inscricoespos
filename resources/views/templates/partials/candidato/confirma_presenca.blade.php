@extends('templates.default')

@section('stylesheets')
  {!! Html::style( asset('css/parsley.css') ) !!}
  {!! Html::style( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ) !!}
  {!! Html::style( asset('bower_components/moment/locale/fr.js') ) !!}
@endsection

@section('confirma_presenca')

  <fieldset class="scheduler-border">
    <legend class="scheduler-border">{{trans('tela_confirma_presenca.confirma_presenca')}}</legend>

    <p>{!! trans('tela_confirma_presenca.mensagem_inicio').'<strong>'.$dados_para_template['nome'].'</strong>'.trans('tela_confirma_presenca.mensagem_meio').'<strong>'.$dados_para_template['programa_pretendido'].'</strong>'.trans('tela_confirma_presenca.departamento')!!}</p>
    @if (sizeof($meses_inicio) > 0)
      <p>{!! trans('tela_confirma_presenca.escolha_mes')!!}</p>
      @foreach ($meses_inicio as $key => $mes_escolha)
      <div class="col-md-4">
       <label class="radio-inline">{{ Form::radio('mes_escolha', $key) }}{{ $mes_escolha }}</label>
      </div>
      @endforeach
    @endif
  </fieldset>

  {!! Form::open(array('route' => 'confirma.presenca', 'class' => 'form-horizontal', 'data-parsley-validate' => '' )) !!}
    {!! Form::hidden('id_inscricao_pos', $dados_para_template['id_inscricao_pos'], []) !!}
    {!! Form::hidden('id_candidato', $dados_para_template['id_candidato'], []) !!}
    {!! Form::hidden('programa_pretendido', $dados_para_template['programa_pretendido'], []) !!}
    <div class="form-group">
      <div class="row">
        <div class="col-md-6 col-md-offset-3 text-center">
          {!! Form::submit(trans('tela_confirma_presenca.confirma'), ['class' => 'btn btn-success btn-lg submit-aceita', 'name' =>'confirma']) !!}
          {!! Form::button(trans('tela_confirma_presenca.declina'), ['class' => 'btn btn-danger btn-lg submit-declina', 'onclick' => 'return archiveFunction(event)', 'id' => 'declina']) !!}
        </div>
      </div>
    </div>
  {!! Form::close() !!}

@endsection

@section('post-script')
<script>
function archiveFunction(event) {
event.preventDefault(); // prevent form submit
var form = event.target.form; // storing the form
        swal({
  title: '{{ trans('tela_confirma_presenca.confirma_envio') }}',
  text: '{{ trans('tela_confirma_presenca.texto_confirma_envio') }}',
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: '{{ trans('tela_confirma_presenca.sim_envia') }}',
  cancelButtonText: '{{ trans('tela_confirma_presenca.nao_envia') }}',
}).then(function () {
  form.submit();          // submitting the form when user press yes
},function(dismiss){
  if (dismiss === 'cancel') {
    swal(
      '{{ trans('tela_confirma_presenca.envio_cancelado') }}'
    )
  } 
});
}
</script>

@section('scripts')
  {!! Html::script( asset('bower_components/moment/min/moment.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/pt-br.js') ) !!}
  {!! Html::script( asset('bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') ) !!}
  {!! Html::script( asset('bower_components/moment/locale/fr.js') ) !!}
  {!! Html::script( asset('js/datepicker.js') ) !!}
  {!! Html::script( asset('js/parsley.min.js') ) !!}
@endsection