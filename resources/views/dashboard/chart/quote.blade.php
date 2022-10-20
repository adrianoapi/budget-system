<?php
$mes   = NULL;
$valor = NULL;
$mesD   = NULL;
$valorD = NULL;

$i=0;
$dataC = $aprove;
foreach($dataC as $value):

  $virgula = $i > 0 ? "," : NULL;

  $mes   .= "{$virgula}'{$value->dt_lancamento}'";
  $valor .= $virgula.$value->total;

  $i++;

 endforeach;

$i=0;
$dataD = $quote;
foreach($dataD as $value):

  $virgula = $i > 0 ? "," : NULL;

  $mesD   .= "{$virgula}'{$value->dt_lancamento}'";
  $valorD .= $virgula.($value->total);

  $i++;

 endforeach;
 ?>


    <canvas id="myChart2"></canvas>

<script>
  const labels = [
    <?php echo $mes;?>
  ];

  const data1 = {
    labels: labels,
    datasets: [{
      label: 'Cotações',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: [<?php echo $valorD;?>],
    }]
  };

  const data2 = {
    labels: labels,
    datasets: [{
      label: 'Finalizadas',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: [<?php echo $valor;?>],
    },
    {
      label: 'Abertas',
      backgroundColor: 'rgb(102, 102, 255)',
      borderColor: 'rgb(102, 102, 255)',
      data: [<?php echo $valorD;?>],
    }]
  };

  const config = {
    type: 'line',
    data: data2,
    options: {}
  };

  const myChart = new Chart(
    document.getElementById('myChart2'),
    config
  );
</script>