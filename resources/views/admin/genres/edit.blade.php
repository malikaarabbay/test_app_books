@extends('adminlte::page')

@section('title', 'Update genre')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title">Update genre</div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('genres.update', $genre) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $genre->name) }}">
                                </div>

                                <div class="form-group">
                                    <label for="books">Books</label>
                                    <select name="books[]" id="books" class="form-control select2" multiple>
                                        @foreach($books as $book)
                                            <option value="{{ $book->id }}" {{ in_array($book->id, $selectedBooks) ? 'selected' : '' }}>
                                                {{ $book->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select books",
                allowClear: true
            });
        });
</script>
@endsection
