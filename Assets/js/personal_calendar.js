document.addEventListener('DOMContentLoaded', function() {
	var calendarEl = document.getElementById('calendar');

	var calendar = new FullCalendar.Calendar(calendarEl, {
		// aspectRatio: 2.8,
		stickyHeaderDates: true,

		expandRows: true,
		slotMinTime: '08:00',
		slotMaxTime: '20:00',
		locale: 'pt-br',
		eventLimit: true,
		headerToolbar: {
			left: 'prev,next today',
			center: 'title',
			right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
		},
		initialView: 'timeGridWeek',
		// initialDate: '2020-09-12',
		navLinks: true, // can click day/week names to navigate views
		editable: false,
		selectable: true,
		nowIndicator: true,
		dayMaxEvents: true, // allow more link when too many events
		events: data_events,
		eventTimeFormat: { // like '14:30:00'
		hour: '2-digit',
		minute: '2-digit',
		meridiem: false
	},
	eventClick: function(info) {
		info.jsEvent.preventDefault();//não deixa o navegador carregar url
		$('#detalhes-evento #id').text(info.event.id);		
		$("#detalhes-evento #start").val(moment(info.event.start).format('YYYY-MM-DDTHH:mm'));  	
		$("#detalhes-evento #end").val(moment(info.event.end).format('YYYY-MM-DDTHH:mm'));  
		$('#detalhes-evento #title').text(info.event.title);
		$('#detalhes-evento #title').val(info.event.title);
		$('#detalhes-evento #description').text(info.event.description);
		$('#detalhes-evento #description').val(info.event.extendedProps.description);
		$('#detalhes-evento #backgroundColor').val(info.event.backgroundColor);
		$('#editEvent #id_form').val(info.event.id);
		
		$('#detalhes-evento').modal('show');
	},
	select: function(info) {
		// alert('Inicio do evento ' + moment(info.start).format('YYYY-MM-DD HH:mm:ss'));
		$('#new_event #start').val(moment(info.startStr).format('YYYY-MM-DDTHH:mm:ss'));
		$('#new_event #end').val(moment(info.startStr).format('YYYY-MM-DDT18:00:00'));
		$('#new_event').modal('show');
	}
});
	calendar.render();

	$('.btn-edit').on("click", function(){
		$('.list').slideToggle();
		$('.edit_event').slideToggle();
	});

	$('.btn-list').on("click", function(){
		$('.edit_event').slideToggle();
		$('.list').slideToggle();
	});
});