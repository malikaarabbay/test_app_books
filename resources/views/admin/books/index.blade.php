@extends('adminlte::page')

@section('title', 'All books')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title">All books</div>
                            <div class="card-tools">
                                <a href="{{ route('books.create') }}" class="btn btn-block bg-gradient-success btn-sm">
                                    Create book
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="books-table" class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Cover</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($books as $book)
                                    <tr data-id="{{ $book->id }}">
                                        <td>{{ $book->id }}</td>
                                        <td>{{ $book->title }}</td>
                                        <td>
                                            <img src="{{ $book->cover_url }}" alt="Cover" width="50">
                                        </td>
                                        <td>
                                            <input type="checkbox" class="status-switch"
                                                   data-id="{{ $book->id }}"
                                                {{ $book->status === 'published' ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-danger delete-btn" data-id="{{ $book->id }}">
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
            let table = $('#books-table').DataTable({
                "fnDrawCallback": function() {
                    // Инициализируем Bootstrap Switch
                    $('.status-switch').bootstrapSwitch({
                        onText: "published",
                        offText: "not published",
                        onColor: "success",
                        offColor: "danger",
                        size: "small",
                    });

                    // Обработчик переключения статуса
                    $(".status-switch").on("switchChange.bootstrapSwitch", function (event, state) {
                        let bookId = $(this).data("id");

                        $.ajax({
                            url: "{{ route('admin.books.changeStatus', '') }}" + "/" + bookId,
                            type: "PATCH",
                            data: {
                                _token: "{{ csrf_token() }}",
                                status: state ? "published" : "not_published"
                            },
                            success: function (response) {
                                toastr.success("Status changed to " + response.status);
                            },
                            error: function (xhr) {
                                toastr.error("Error: " + xhr.responseJSON.message);
                            }
                        });
                    });
                }
            });

            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                let id = $(this).data('id');

                if (confirm('Are you sure you want to delete the book?')) {
                    $.ajax({
                        url: "{{ route('books.destroy', '') }}" + "/" + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            toastr.success(response.message);
                            let row = $(`#books-table tr[data-id="${id}"]`);
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


