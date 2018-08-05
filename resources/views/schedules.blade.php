@extends('layouts.frontlayout')


@section('frontcontent')

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
 
    <!-- Page Content -->
    <div class="container">
        @if ($message = session()->get('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>{{ $message }}</p>
            </div>
        @endif
        @if ($message = session()->get('error'))
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>{{ $message }}</p></div>
        @endif

        <div class="row">
          <div class="col-md-12">
		  
		  <button style='margin-top:12px;' id="addSchedule" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Add Schedule</button>

		  <div class="row" id="scheduleRow">
		  <div class="col-sm-12">
		   <h2>Add Schedule</h2>
		  </div>
		  <div class="col-md-2">
                        <div class="form-group">
						<label for="destination">Destination</label>
						<input type="text" name="destination" class="sinput form-control" id="destination" placeholder="Destination" require />
						<p class="error" style='color:red;'>Destination Field is required.</p>
						</div>
						</div>
						
							
 <div class="col-md-3">
                        <div class="form-group">
						<label for="etb_date">Estimated Birth Date</label>
						<input type="datetime-local" name="etb_date" class="sinput form-control" id="etb_date" placeholder="Estimated Birth Date" require />
						<p class="error" style='color:red;'>EBD Field is empty or incorrect date in enetered.</p>
						</div>
						</div>	


 <div class="col-md-3">
                        <div class="form-group">
						<label for="etd_date">Estimated Departure Date</label>
						<input type="datetime-local" name="etd_date" class="sinput form-control" id="etd_date" placeholder="Estimated Departure Date" require />
						<p class="error" style='color:red;'>EDD Field is empty or incorrect date in enetered.</p>
						</div>
						</div>	


 <div class="col-md-3">
                        <div class="form-group">
						<label for="eta_date">Estimated Arrival Date</label>
						<input type="datetime-local" name="eta_date" class="sinput form-control" id="eta_date" placeholder="Estimated Arrival Date" require />
						<p class="error" style='color:red;'>EAD Field is empty or incorrect date in enetered.</p>
						</div>
						</div>	

 <div class="col-md-1">
 <input type="hidden" id="ship_id" value="{{$ship->id}}" />
                        <div class="form-group">
						<label>Proceed</label>
						<input type="button" name="submit" class="sinput form-control btn-sm btn-success" id="submit" Value="Submit"/>
						</div>
						</div>							
		  </div>
		  
		  <h2 class="mt-4">{{$ship->name}} : schedules</h2>
		  	<table  class="table" id="dataTableBuilder">
			<thead>
			<tr>
			<th>Id</th>
			<th>Destination</th>
			<th>ETA</th>
			<th>ETB</th>
			<th>ETD</th>
			<th>Action</th>
			</tr>
			</thead>
			<tbody id="tbody">
			<?php $Amodulation = ""; ?>
			<?php $Bmodulation = ""; ?>
			<?php $Dmodulation = ""; ?>
			@foreach($schedules as $s)
			<tr>
			<td>{{$s->id}}</td>
			<td>{{$s->destination}}</td>


			<?php $x =  substr($s->eta_date,11,16);  ?>
			@if(substr($x, 0,2)>= 12 )
					<?php $Amodulation = "PM"; ?>
			@else
						<?php $Amodulation = "AM"; ?>
			@endif	

			<td><?php echo substr($s->eta_date,0,10). " ".substr($s->eta_date, 11); ?>  {{$Amodulation}}</td>
			
			<?php $y =  substr($s->etb_date,11,16);  ?>
			@if(substr($y, 0,2)>= 12 )
					<?php $Bmodulation = "PM"; ?>
			@else
						<?php $Bmodulation = "AM"; ?>
			@endif	

			<td><?php echo substr($s->etb_date,0,10). " ".substr($s->etb_date, 11); ?> {{$Bmodulation}}</td>
		
		<?php $z =  substr($s->etd_date,11,16);  ?>
			@if(substr($z, 0,2)>= 12 )
					<?php $Dmodulation = "PM"; ?>
			@else
						<?php $Dmodulation = "AM"; ?>
			@endif	

			<td><?php echo substr($s->etd_date,0,10). " ".substr($s->etd_date, 11); ?> {{$Dmodulation}}</td>
			<td>
					<button class="btn-sm btn-info" onclick="editMe({{$s->id}})">Edit</button> 
					<button class="btn-sm btn-danger" onclick="deleteMe({{$s->id}});">Delete</a>
					</td>
			</tr>
			@endforeach
			</tbody>
			</table>
			
		  </div>

        </div>
        <!-- /.row -->

    </div>
	<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <div class="row">
        <div class="col-md-12">
                        <div class="form-group">
						<label for="destination">Destination</label>
						<input type="text" name="destination" class="msinput form-control" id="mdestination" placeholder="Destination" require />
						</div>
						</div>
						
 <div class="col-md-12">
                        <div class="form-group">
						<label for="etb_date">Estimated Birth Date</label>
						<input type="datetime-local" name="etb_date" class="msinput form-control" id="metb_date" placeholder="Estimated Birth Date" require />
						</div>
						</div>	




 <div class="col-md-12">
                        <div class="form-group">
						<label for="etd_date">Estimated Depart Date</label>
						<input type="datetime-local" name="etd_date" class="msinput form-control" id="metd_date" placeholder="Estimated Departure Date" require />
						</div>
						</div>	




 <div class="col-md-12">
  <input type="hidden" id="msid" value="" />
                        <div class="form-group">
						<label for="eta_date">Estimated Arrival Date</label>
						<input type="datetime-local" name="eta_date" class="msinput form-control" id="meta_date" placeholder="Estimated Arrival Date" require />
						</div>
						</div>	
</div>
      </div>
      <div class="modal-footer">
        <button type="button" id="mBtn" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
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
		var etb_date = $('#etb_date').val();

		var etd_date = $('#etd_date').val();

		var eta_date = $('#eta_date').val();
		
		var shipID  = $('#ship_id').val();
		//alert(destination+ " : "+etb+ " : "+etb_date+" : "+etd+" : "+etd_date+": "+eta+" : "+eta_date+" : "+shipID);
		var token = "{{ csrf_token() }}";
			$.post("{{URL::to('/ship/processSchedule')}}", {"destination": destination,  "etb_date" : etb_date, "etd_date" : etd_date, "eta_date": eta_date,
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
		var url = "{{URL::to('/ship/getSchedule/')}}/"+id;
		$.get(url,function(data){
			if(data)
			{
		$('#mdestination').val(data.destination);

		$('#metb_date').val(data.etb_date);
		

		$('#metd_date').val(data.etd_date);

		$('#meta_date').val(data.eta_date);
		
		$('#msid').val(data.id);
				$('.modal-title').text(data.destination+ " Schedule");
					$('.modal').modal('show');
			}
		});
	
	}
	
	$('#mBtn').click(function(){
		var j = 0;
		var error = [];
		$('.msinput ').each(function(index,element){
			if($(element).val() == "")
			{
				//error.push("can not be empty");
				$(element).css('border-color','red');
				j++;
				
			}
			else
			{
				
				$(element).css('border-color','green');
			}
		});
		
		if(j == 0)
		{
				var destination = $('#mdestination').val();
		var etb_date = $('#metb_date').val();

		var etd_date = $('#metd_date').val();
		

		var eta_date = $('#meta_date').val();
		
		var sid = $('#msid').val();
		$.post("{{URL::to('/ship/updateSchedule')}}", {"destination": destination, "etb_date" : etb_date, "etd_date" : etd_date, "eta_date": eta_date,
			"sid": sid, "_token": "{{ csrf_token() }}"}, function(data){
				loadRows();
				if(data > 0){
					$('.msinput ').each(function(index,element){
					
						$(element).val("");
						
						
			
				});
				
		
			$('.modal').modal('hide');
		alert('Schedule Update');
						//loadRows();
		}
		else
		{
			alert('error occurred in updating the schedule. Try again.');
		}
			});
		}			
		else
		{
			alert('Input Fields are empty');
		}
	});
</script>
@endsection