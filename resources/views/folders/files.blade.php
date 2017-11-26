@if($folder && $folder->files()->count() > 0)

@if($folder->id == 1)
	<form action="{{ route('recycleFiles') }}" method="POST">
@else
	<form action="{{ route('deleteFiles') }}" method="POST">
@endif
	<input type="hidden" name="_method" value="DELETE">
	{{ csrf_field() }}
	<table class="table is-fullwidth is-striped">
		<thead>
			<tr>
				<th><input class="checkbox" onClick="toggle(this,'file[]')" name="checkall" type="checkbox"></th>
				<th></th>
				<th>Filename</th>
				<th>Uploaded Date</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($folder->files()->get()->sortBy('name') as $file)
			<tr>
			  <td width="5%"><input class="checkbox" name="file[]" value="{{ $file->id }}" type="checkbox"></td>
			  <td width="5%"><i class="fa fa-file-o"></i></td>
			  <td><a href="{{ route('download', [ 'filename' => $file->filename ]) }}">{{ $file->filename }}</a></td>
			  <td>{{ $file->created_at }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
@else
<div style="padding:15px">
	<p>No files in here yet</p>
</div>
@endif

@if($folder && $folder->files()->count() > 0 && !Auth::user()->hasRole("Surveyor"))
<div style="padding: 15px">
	<button class="button is-danger is-small" onclick="return confirm('@if($folder->id == 1) Are you sure you want to permanently delete these selected items? @else Are you sure you want to delete the selected items? They will be moved to the trash, which only a Site Manager can undo @endif');">
	@if($folder->id == 1)
		Permanently delete
	@else
		Move to trash
	@endif
	</button>
</div>
</form>
@endif