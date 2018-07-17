$(document).ready(function(){
	$.ajax({
		url: "https://hospiweb.novacdan.ro/panel/profil/js/Data_HeartPulseU",
		method: "GET",
		success: function(data) {
			var day = [];
			var sistola = [];
			var diastola = [];
			var pulse = [];
		    var options = {
                    
                    title: {
                        display: true,
                        text: 'Tensiune & Puls pacient'
                    },
                    tooltips: {
                        display:false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                };	

			for(var i in data) 
			{
				day.push("Ziua " + data[i].day);
				sistola.push(data[i].sistola);
				diastola.push(data[i].diastola);
				pulse.push(data[i].pulse);
			}

			var chartdata = {
				labels: day,
				datasets : [
					{
					    label: 'Puls',
						backgroundColor: 'rgba(178,34,34, 0.8)',
						borderColor: 'rgba(178,34,34, 1)',
						borderWidth: 1,
						data: pulse
					},
				    {
                        label: 'Diastola',
						backgroundColor: 'rgba(0,0,205, 0.8)',
						borderColor: 'rgba(0,0,205, 1)',
						borderWidth: 1,
						data: diastola
					},
					{
						label: 'Sistola',
						backgroundColor: 'rgba(75,0,130, 0.8)',
						borderColor: 'rgba(75,0,130, 1)',
						borderWidth: 1,
						data: sistola
					}
				]
			};

			var ctx = $("#myChartU");
			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata,
				options: options
			});
		}
	});
});