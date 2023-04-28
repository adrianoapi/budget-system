@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid" id="content">

    @include('layouts.navigation')

    <div id="main">
        <div class="container-fluid">

            <div class="row-fluid">
                <div class="span12">
                    <div class="box box-bordered box-color">
                        <div class="box-title">
                            <h3><i class="icon-th-list"></i> Upload</h3>
                        </div>
                        <div class="box-content nopadding">
                            <form action="{{route('arquivos.store')}}" method="post" enctype="multipart/form-data">
                                <h3 class="text-center mb-5">Upload File in Laravel</h3>
                                  @csrf
                                  @if ($message = Session::get('success'))
                                  <div class="alert alert-success">
                                      <strong>{{ $message }}</strong>
                                  </div>
                                @endif
                                @if (count($errors) > 0)
                                  <div class="alert alert-danger">
                                      <ul>
                                          @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                          @endforeach
                                      </ul>
                                  </div>
                                @endif
                                  <div class="custom-file">
                                      <input type="file" name="file" class="custom-file-input" id="chooseFile">
                                      <label class="custom-file-label" for="chooseFile">Select file</label>
                                  </div>
                                  <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                                      Upload Files
                                  </button>
                              </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script>

(function( $ ) {
    $(function() {
        $('.money').mask('#.##0,00', {reverse: true});
        $('.decimal').mask('##########.##', {reverse: true});
    });
})(jQuery);

</script>

@endsection
