function view_graph(canvas_id, data_id){

	//折れ線グラフ
	var ctx = document.getElementById(canvas_id);
	var data_elm = document.getElementById(data_id);
	var data = JSON.parse(data_elm.value);
	
	var myLineChart = new Chart(ctx, {
	  //グラフの種類
	  type: 'line',
	  //データの設定
	  data: {
		  //データ項目のラベル
		  labels: data.labels,
		  //データセット
		  datasets: data.dataset_list
	  },
	  //オプションの設定
	  options: {
		  scales: {
			  //縦軸の設定
			  yAxes: [{
				  ticks: {
					  //最小値を0にする
					  beginAtZero: true
				  }
			  }]
		  }
	  }
	});
  }