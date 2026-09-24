var counter = null;
var counter_stop = null;

	function chapter_test(minutes_original)
	{	
		//var ts = new Date(2012, 0, 1),
		var ts = new Date();
			newYear = true;
		ts.setMinutes(ts.getMinutes() + minutes_original);
		
		if((new Date()) > ts){
			// The new year is here! Count towards something else.
			// Notice the *1000 at the end - time must be in milliseconds
			ts = (new Date()).getTime() + 1000 * 60 * 60 * 2;//10*24*60*60*1000;
			newYear = false;
		}
			
		 counter_stop = $('#countdown_stop').countdown({
			timestamp	: ts,
			callback	: function(days, hours, minutes, seconds){
			},
			stopeed : true
		});
		
		counter = $('#countdown').countdown({
			timestamp	: ts,
			callback	: function(days, hours, minutes, seconds){
				
				var curr_time = (hours*60*60)+(minutes*60)+seconds;
				$("#tss").val((minutes_original*60)-(curr_time));
				if(minutes== 0 && seconds == 0)
				{
					$("#chapter_form").submit();
				}
			}
		});
	
	}		
	
	function final_test(minutes_original)
	{	
		//var ts = new Date(2012, 0, 1),
		var ts = new Date();
			newYear = true;
		ts.setMinutes(ts.getMinutes() + minutes_original);
		
		if((new Date()) > ts){
			// The new year is here! Count towards something else.
			// Notice the *1000 at the end - time must be in milliseconds
			ts = (new Date()).getTime() + 1000 * 60 * 60 * 2;//10*24*60*60*1000;
			newYear = false;
		}
			
		 counter_stop = $('#countdown_stop').countdown({
			timestamp	: ts,
			callback	: function(days, hours, minutes, seconds){
			},
			stopeed : true
		});
		
		counter = $('#countdown').countdown({
			timestamp	: ts,
			callback	: function(days, hours, minutes, seconds){
				
				var curr_time = (hours*60*60)+(minutes*60)+seconds;
				$("#tss").val((minutes_original*60)-(curr_time));
				if(minutes== 0 && seconds == 0)
				{
					$("#wizard").submit();
				}
			}
		});
	
	}
	
