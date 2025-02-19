@extends('adminlte::page')

@section('title', 'Create genre')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title">Create genre</div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('genres.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                                </div>

                                <div class="form-group">
                                    <label for="books">Books</label>
                                    <select name="books[]" id="books" class="form-control select2" multiple>
                                        @foreach($books as $book)
                                            <option value="{{ $book->id }}"}}>
                                                {{ $book->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Create</button>
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
