@layout('layouts/main')
@section('navigation')
@parent
<li class="active"><a href="/customer">Customer</a></li>
@endsection
@section('content')
	<div class="hero-unit">
		<div class="row">
			<h1>customer.index</h1>
			
			
		</div>
	</div>
	<div class="btn-group pull-right">
		<a class="btn btn-large" href="/customer/new">New Customer</a>
	</div>
	<h1>Customers List</h1>
	<table class="table table-bordered">
		<thead>
			<tr class="success">
				<th>Name</th>
				<th>Age</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		@foreach ( $customers as $customer )
			<tr>
				<td><strong>Name:</strong> {{ $customer->name }} </td>
				<td><strong>Age:</strong> {{ $customer->age }}</td>
				<td class="span1">
					<div class="btn-group pull-right">
						<a class="btn status-btn <?php echo $statusURL[$customer->active] ?>" rel="/customer/<?php echo $statusURL[$customer->active] ?>/<?php echo $customer->hash_id ?>" ><img src="<?php echo URL::to_asset("img/".$status[$customer->active] .'.png'); ?>" alt="" width="14" /></a>
						<a href="/customer/update/{{ $customer->hash_id }}" class="btn" title="Edit"><i class="icon-edit"></i></a>
						<a href="javascript:;" rel="{{ $customer->_id }}" class="btn btn-danger btn-remove" title="Remove"><i class="icon-remove icon-white"></i></a>
					</div>
				</td>
			</tr>
		</tbody>
		@endforeach
	</table>

@endsection



