@extends('dashboard.main')

@section('title', 'Modello email: ' . $template->name)

@section('body')
  <div class="container-xl">
    <div class="row row-deck row-cards">
      <div class="col-md-6">
        <div class="card">
          <div class="card-status-top bg-primary"></div>
          <h2 class="card-header">Modello</h2>
          <form method="post">
            <div class="card-body">
              <div class="mb-3">
                <label class="form-label">Oggetto</label>
                <input type="text" name="subject" class="form-control" value="{{ $template->subject }}" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Corpo HTML</label>
                <textarea name="body" id="html" cols="30" rows="20" class="form-control" oninput="$('#preview').attr('srcdoc', $('#html').val());">{{ $template->body }}</textarea>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Salva</button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-status-top bg-success"></div>
          <h2 class="card-header">Preview</h2>
          <div class="card-body">
            <iframe id="preview" class="col-12 h-100" srcdoc=""></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
      $('#preview').attr('srcdoc', $('#html').val());
  </script>
@endsection