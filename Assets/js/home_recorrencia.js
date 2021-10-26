var theme = {
	color: [ 
	'#ff730c', '#056a86'
	],
};

var myChart = echarts.init(document.getElementById('recorrencia'), theme);

var option = {
title: {text: 'Recorrência de sistemas', subtext: ''},
	toolbox: {
		show: true,
		feature: {			
			saveAsImage: {
				show: true,
				title: 'Salvar como imagem'
			}
		}
	},
	tooltip: {
		trigger: 'item'
	},
	legend: {
		top: '5%',
		left: 'center'
	},
	series: [								
	{
		name: 'Recorrência de sistemas',
		type: 'pie', 
		radius: ['40%', '70%'],
		avoidLabelOverlap: false,
		label: {
			show: false,
			position: 'center'
		},
		emphasis: {
			label: {
				show: true,
				fontSize: '40',
				fontWeight: 'bold'
			}
		},
		labelLine: {
			show: false
		},
		data: [
		{value: 700, name: 'Não vendidos'},
		{value: 600, name: 'Meta atingida'}
		]
	}
	]
};

myChart.setOption(option);