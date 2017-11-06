@foreach ($folder->files()->get() as $file)
<tr>
  <td width="5%"><i class="fa fa-file-o"></i></td>
  <td><a href="{{ route('download', [ 'filename' => $file->filename ]) }}">{{ $file->filename }}</a></td>
  <td><a class="button is-small is-primary" href="#">Action</a></td>
</tr>
@endforeach