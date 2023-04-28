<div class="card ">
   
    <div class="card-body ">
    <canvas id="myChart4"></canvas>
    </div>
    <div class="card-footer ">
        <div class="legend">
        </div>
    </div>
</div>
<script>
 var data4 = {
  labels: ["Espaço livre",  "Espaço usado"],
  datasets: [{
    data: [
      {{str_replace(",","",number_format(100*10 - $size/1000000, 2))}},
      {{str_replace(",","",number_format($size/1000000, 2))}}],
  
    hoverOffset: 2
  }]
};
</script>

<script>

  
var option = {
  responsive: false,
  scales: {
    y: {
      stacked: true,
      grid: {
        display: true,
        color: "rgba(255,99,132,0.2)"
      }
    },
    x: {
      grid: {
        display: false
      }
    }
  }
};

var config4 = {
  type: 'pie',
  data: data4,
  options: option
};

var myChart4 = new Chart(
    document.getElementById('myChart4'),
    config4
  );
</script>