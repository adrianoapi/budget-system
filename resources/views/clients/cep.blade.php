<script>

function consultaCep(value)
{
    var cep = $("#cep").val();

    if(cep.length < 8){
        alert('Insira um CEP válido!');
        return false;
    }

    $.ajax({
        url : "http://cep.republicavirtual.com.br/web_cep.php",
        type : 'post',
        data : {
            cep : cep,
            formato :'json'
        },
        beforeSend : function(){
            $('a#a_cep').text('...');
        }
    })
    .done(function(msg){
        $('a#a_cep').text('Auto completar');
        $("#bairro").val(msg.bairro);
        $("#cidade").val(msg.cidade);
        $("#estado").val(msg.uf).change();
        $("#endereco").val(msg.logradouro);
        $("#numero").focus();
    })
    .fail(function(jqXHR, textStatus, msg){
        alert('Endereço não encontrado!');
        console.log('error');
        console.log(msg);
    });

}

</script>
