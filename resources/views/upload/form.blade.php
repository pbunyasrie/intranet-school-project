@if(!Auth::user()->hasRole("Surveyor"))
<form action="{{ route('upload', ['folder' => $folder]) }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    Files (can attach more than one):
    <br />
    <div class="file is-boxed has-name">
      <label class="file-label">
        <input class="file-input" id="file" type="file" name="files[]" multiple />
        <span class="file-cta">
          <span class="file-icon">
            <i class="fa fa-upload"></i>
          </span>
          <span class="file-label">
            Choose a file…
          </span>
        </span>
      <span id="filename" class="file-name">
       
      </span>
      </label>
    </div>
    <br /><br />
    <button class="button is-primary">Upload</button>
</form>
@else
Sorry, surveyors do not have permission to upload files.
@endif