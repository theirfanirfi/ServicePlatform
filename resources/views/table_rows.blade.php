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