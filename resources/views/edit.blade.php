<!-- resources/views/upload.blade.php -->

@include('partials.header')
<div>
  <a href="{{ route('index') }}" class="btn">Liste des fichiers</a>
</div>
<form action="{{ route('update', $file->token) }}" method="post" enctype="multipart/form-data">
  @csrf
  <h1>Mise à jour de fichier</h1>
  <div class="input-group">
    <label for="file" class="btn">Sélectionner un fichier</label>
    <span id="displayName"></span>
    <input type="file" name="file" id="file">
  </div>
  <div class="input-group">
    <label for="url">Téléverser à partir d'une URL :</label>
    <input type="text" name="url" id="url">
  </div>
  <div class="input-group">
    <label for="name">Nom de fichier :</label>
    <input type="text" name="name" id="name" value="{{ $file->name }}">
  </div>
  <button type="submit" class="btn">Mettre à jour</button>
</form>
@if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif



@include('partials.file-form-script')
@include('partials.footer')
