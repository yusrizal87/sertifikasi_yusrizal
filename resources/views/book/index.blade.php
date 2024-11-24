@extends('layouts.app')
@section('content')

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h2 class="admin-heading">All Books</h2>
            </div>
            <div class="col-md-5">
                <form action="{{ route('books') }}" method="GET">
                    <div class="input-group">
                        <!-- Filter by Category -->
                        <select name="category" class="form-control">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        

                        <!-- Filter by Status -->
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="Y" {{ request('status') == 'Y' ? 'selected' : '' }}>Available</option>
                            <option value="N" {{ request('status') == 'N' ? 'selected' : '' }}>Issued</option>
                        </select>

                        <!-- Submit Button -->
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="offset-md-2 col-md-2">
                <a class="add-new" href="{{ route('book.create') }}">Add Book</a>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="message"></div>
                <table class="content-table">
                    <thead>
                        <th>S.No</th>
                        <th>Book Name</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                            <tr>
                                <td class="id">{{ $book->id }}</td>
                                <td>{{ $book->name }}</td>
                                <td>{{ $book->category->name }}</td>
                                <td>{{ $book->auther->name }}</td>
                                <td>{{ $book->publisher->name }}</td>
                                <td>
                                    @if ($book->status == 'Y')
                                        <span class='badge badge-success'>Available</span>
                                    @else
                                        <span class='badge badge-danger'>Issued</span>
                                    @endif
                                </td>
                                <td class="edit">
                                    <a href="{{ route('book.edit', $book) }}" class="btn btn-success">Edit</a>
                                </td>
                                <td class="delete">
                                    <form action="{{ route('book.destroy', $book) }}" method="post" class="form-hidden">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger delete-book">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No Books Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
