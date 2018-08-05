		$('#scheduleRow').hide();
		$('.error').hide();
	$("#dataTableBuilder").DataTable();
	$('#addSchedule').click(function(){
		$('#scheduleRow').toggle('slow');
	});
	
	
	//add Schedule
	
	$('#submit').click(function(){
		var i = 0;
		var error = [];
		$('.sinput ').each(function(index,element){
			if($(element).val() == "")
			{
				//error.push("can not be empty");
				$(element).next('.error').show("slow");
				i++;
				
			}
			else
			{
				$(element).next('.error').hide("slow");
			}
		});
		if(i == 0){
		var destination = $('#destination').val();
		var etb = $('#etb').val();
		var etb_date = $('#etb_date').val();
		
		var etd = $('#etd').val();
		var etd_date = $('#etd_date').val();
		
		var eta = $('#eta').val();
		var eta_date = $('#eta_date').val();
		
		var shipID  = $('#ship_id').val();
		//alert(destination+ " : "+etb+ " : "+etb_date+" : "+etd+" : "+etd_date+": "+eta+" : "+eta_date+" : "+shipID);
		var token = "{{ csrf_token() }}";
			$.post("{{URL::to('/ship/processSchedule')}}", {"destination": destination, "etb" : etb, "etb_date" : etb_date, "etd" : etd,"etd_date" : etd_date, "eta": eta, "eta_date": eta_date,
			"ship_id": shipID, "_token": "{{ csrf_token() }}"}, function(data){
				loadRows();
				if(data > 0){
					$('.sinput ').each(function(index,element){
						$(element).val("");
			
		});
		$('#scheduleRow').toggle('slow');
				alert("New Schedule Added.");
				}
				else
				{
					alert("Error occurred in Adding the Schedule. Try again");
				}
			});
		}
		else
		{
			//alert('all fields are required');
		}
	});
	
	function loadRows()
	{
		var id = "{{$ship->id}}";
		var url = "{{URL::to('/ship/rows/')}}/"+id;
		$.get(url,function(data){
			$('#tbody').html(data);
		});
	}
	
	function deleteMe(id)
	{
		var url = "{{URL::to('/ship/deleteSchedule/')}}/"+id;
		$.get(url,function(data){
			if(data > 0)
			{
				loadRows();
			}
			else
			{
				alert('error occurred in deleting the schedule. Try Again');
			}
		});
	}
	
	function editMe(id)
	{
		$('.modal').modal('show');
	}