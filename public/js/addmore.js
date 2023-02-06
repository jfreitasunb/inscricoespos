var i = 0;

$("#add").click(function(){
  ++i;
  $("#dynamicTable").append('<tr><td><input type="text" name="discplinas_destaque['+i+'][nome_disciplina]" placeholder="Nome Disciplina" class="form-control" /></td><td><select id="select_mencao_'+i+'" name="discplinas_destaque['+i+'][mencao]" class="form-control" /></select></td><td><button type="button" class="btn btn-danger remove-tr">Remover</button></td></tr>');
  $('#select_mencao_'+i+'').append(new Option('Selecione', ''));
  $('#select_mencao_'+i+'').append(new Option('SS', 'SS'));
  $('#select_mencao_'+i+'').append(new Option('MS', 'MS'));
  $('#select_mencao_'+i+'').append(new Option('MM', 'MM'));
});

$(document).on('click', '.remove-tr', function(){  
     $(this).parents('tr').remove();
});
