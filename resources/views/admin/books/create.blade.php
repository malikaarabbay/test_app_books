@extends('adminlte::page')

@section('title', 'Create book')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title">Create book</div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                                </div>

                                <div class="form-group">
                                    <label for="cover_image">Cover</label>
                                    <input type="file" class="form-control" id="cover_image" name="cover_image">
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
