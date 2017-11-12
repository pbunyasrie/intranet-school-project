<thead>
	<tr>
		<th></th>
		<th>Filename</th>
		<th>Uploaded Date</th>
		<th></th>
	</tr>
</thead>
@foreach ($folder->files()->get() as $file)
<tr>
  <td width="5%"><i class="fa fa-file-o"></i></td>
  <td><a href="{{ route('download', [ 'filename' => $file->filename ]) }}">{{ $file->filename }}</a></td>
  <td>{{ $file->created_at }}</td>
  <td><a class="button is-small is-primary" href="#">Action</a></td>
</tr>
@endforeach