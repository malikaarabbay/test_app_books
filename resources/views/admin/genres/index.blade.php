@extends('adminlte::page')

@section('title', 'All genres')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title">All genres</div>
                            <div class="card-tools">
                                <a href="{{ route('genres.create') }}" class="btn btn-block bg-gradient-success btn-sm">
                                    Create genre
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="genres-table" class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($genres as $genre)
                                    <tr data-id="{{ $genre->id }}">
                                        <td>{{ $genre->id }}</td>
                                        <td>{{ $genre->name }}</td>
                                        <td>
                                            <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-danger delete-btn" data-id="{{ $genre->id }}">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            let table = $('#genres-table').DataTable();

            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                let id = $(this).data('id');

                if (confirm('Are you sure you want to delete a genre?')) {
                    $.ajax({
                        url: "{{ route('genres.destroy', '') }}" + "/" + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            toastr.success(response.message);
                            let row = $(`#genres-table tr[data-id="${id}"]`);
                            table.row(row).remove().draw(false);
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON.message);
                        }
                    });
                }
            });
        });
    </script>
@endsection


