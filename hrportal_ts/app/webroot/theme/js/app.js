(function($) {

	/*var options = {
		events_source: function () { return [{"id":"1731","title":"Attendance","url":"Attendance","class":"event-info","start"
:"1440043980000","end":"1440076560000"},{"id":"1732","title":"Attendance","url":"Attendance","class"
:"event-info","start":"1440388140000","end":"1440420660000"},{"id":"1733","title":"Attendance","url"
:"Attendance","class":"event-info","start":"1440993180000","end":"1441027200000"},{"id":"1734","title"
:"Attendance","url":"Attendance","class":"event-info","start":"1439957340000","end":"1439989380000"}
,{"id":"1735","title":"Attendance","url":"Attendance","class":"event-info","start":"1440561540000","end"
:"1440595620000"},{"id":"1736","title":"Attendance","url":"Attendance","class":"event-info","start":"1440303780000"
,"end":"1440334260000"},{"id":"1737","title":"Attendance","url":"Attendance","class":"event-info","start"
:"1440734760000","end":"1440766740000"},{"id":"1738","title":"Attendance","url":"Attendance","class"
:"event-info","start":"1440906840000","end":"1440939120000"},{"id":"1739","title":"Attendance","url"
:"Attendance","class":"event-info","start":"1439871120000","end":"1439903160000"},{"id":"1740","title"
:"Attendance","url":"Attendance","class":"event-info","start":"1440475320000","end":"1440508980000"}
,{"id":"1741","title":"Attendance","url":"Attendance","class":"event-info","start":"1440820500000","end"
:"1440853680000"},{"id":"1742","title":"Attendance","url":"Attendance","class":"event-info","start":"1440216600000"
,"end":"1440247500000"},{"id":"1743","title":"Attendance","url":"Attendance","class":"event-info","start"
:"1440647880000","end":"1440679500000"},{"id":"1744","title":"Attendance","url":"Attendance","class"
:"event-info","start":"1440130020000","end":"1440161100000"},{"id":"2073","title":"Attendance","url"
:"Attendance","class":"event-info","start":"1438747680000","end":"1438779360000"},{"id":"2074","title"
:"Attendance","url":"Attendance","class":"event-info","start":"1439612820000","end":"1439643180000"}
,{"id":"2075","title":"Attendance","url":"Attendance","class":"event-info","start":"1438575420000","end"
:"1438607280000"},{"id":"2076","title":"Attendance","url":"Attendance","class":"event-info","start":"1439178360000"
,"end":"1439211600000"},{"id":"2077","title":"Attendance","url":"Attendance","class":"event-info","start"
:"1439437800000","end":"1439470980000"},{"id":"2078","title":"Attendance","url":"Attendance","class"
:"event-info","start":"1439526300000","end":"1439558280000"},{"id":"2079","title":"Attendance","url"
:"Attendance","class":"event-info","start":"1439698620000","end":"1439730480000"},{"id":"2080","title"
:"Attendance","url":"Attendance","class":"event-info","start":"1439006100000","end":"1439039880000"}
,{"id":"2081","title":"Attendance","url":"Attendance","class":"event-info","start":"1439094540000","end"
:"1439126880000"},{"id":"2082","title":"Attendance","url":"Attendance","class":"event-info","start":"1438487820000"
,"end":"1438519860000"},{"id":"2083","title":"Attendance","url":"Attendance","class":"event-info","start"
:"1438921440000","end":"1438952340000"},{"id":"2084","title":"Attendance","url":"Attendance","class"
:"event-info","start":"1438402680000","end":"1438434000000"},{"id":"2085","title":"Attendance","url"
:"Attendance","class":"event-info","start":"1438662120000","end":"1438694100000"},{"id":"2086","title"
:"Attendance","url":"Attendance","class":"event-info","start":"1439266920000","end":"1439297460000"}
,{"id":"2087","title":"Attendance","url":"Attendance","class":"event-info","start":"1438835040000","end"
:"1438866780000"},{"id":"2088","title":"Attendance","url":"Attendance","class":"event-info","start":"1439351880000"
,"end":"1439385900000"},{"id":"2089","title":"Attendance","url":"Attendance","class":"event-info","start"
:"1439784240000","end":"1439816220000"}] },
		view: 'month',
		tmpl_path: 'http://localhost/hrconnect/theme/js/tmpls/',
		tmpl_cache: false,onAfterEventsLoad: function(events) {
			if(!events) {
				return;
			}
			var list = $('#eventlist');
			list.html('');

			$.each(events, function(key, val) {
				$(document.createElement('li'))
					.html('<a href="' + val.url + '">' + val.title + '</a>')
					.appendTo(list);
			});
		},
		onAfterViewLoad: function(view) {
			$('.page-header h4').text(this.getTitle());
			$('.btn-group button').removeClass('active');
			$('button[data-calendar-view="' + view + '"]').addClass('active');
		},
		classes: {
			months: {
				general: 'label'
			}
		}
	};

	var calendar = $('#calendar').calendar(options);

	$('.btn-group button[data-calendar-nav]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.navigate($this.data('calendar-nav'));
		});
	});

	$('.btn-group button[data-calendar-view]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.view($this.data('calendar-view'));
		});
	});

	$('#first_day').change(function(){
		var value = $(this).val();
		value = value.length ? parseInt(value) : null;
		calendar.setOptions({first_day: value});
		calendar.view();
	});

	$('#language').change(function(){
		calendar.setLanguage($(this).val());
		calendar.view();
	});

	$('#events-in-modal').change(function(){
		var val = $(this).is(':checked') ? $(this).val() : null;
		calendar.setOptions({modal: val});
	});
	$('#format-12-hours').change(function(){
		var val = $(this).is(':checked') ? true : false;
		calendar.setOptions({format12: val});
		calendar.view();
	});
	$('#show_wbn').change(function(){
		var val = $(this).is(':checked') ? true : false;
		calendar.setOptions({display_week_numbers: val});
		calendar.view();
	});
	$('#show_wb').change(function(){
		var val = $(this).is(':checked') ? true : false;
		calendar.setOptions({weekbox: val});
		calendar.view();
	});
	$('#events-modal .modal-header, #events-modal .modal-footer').click(function(e){
	});
*/


}(jQuery));