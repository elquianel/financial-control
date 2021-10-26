var theme = {
	color: [ 
	'#ff730c', '#056a86'
	],
};
var myChart = echarts.init(document.getElementById('vendas_equipamentos'), theme);

var option = {
	title: {text: 'Venda de Equipamentos', subtext: ''},
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
		name: 'Venda de Equipamentos',
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
		{value: 18700, name: 'R$ Não vendido'},
		{value: 1300, name: 'R$ vendidos'}
		]
	}
	]
};

myChart.setOption(option);					