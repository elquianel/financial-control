var theme = {
	color: [ 
	'#ff730c', '#056a86'
	],
};
var myChart = echarts.init(document.getElementById('adesao_qnt'), theme);

var option = {
	title: {text: 'Adesão Sistemas (QNT)', subtext: ''},
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
		name: 'Adesão Sistemas (QNT)',
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
		{value: 5, name: 'Não vendido'},
		{value: 5, name: 'Vendidos'}
		]
	}
	]
};

myChart.setOption(option);					