@extends('layouts.dashboard')
@section('content')
<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
      <div class="header-body">
        <div class="row align-items-center py-4">
          <div class="col-lg-6 col-7">
            <h6 class="h2 text-white d-inline-block mb-0">Books</h6>
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
              <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Books</li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-6 col-5 text-right">
            <a href="#" class="btn btn-sm btn-neutral">New</a>
            <a href="#" class="btn btn-sm btn-neutral">Filters</a>
          </div>
        </div>
      </div>
    </div>
  </div>
 <!-- Page content -->
 <div class="container-fluid mt--6">
  
</div>
<a href="#" class="btn btn-neutral" data-toggle="modal" data-target="#defaultDurationModal" data-whatever="@mdo"><i class="fa fa fa-plus"></i> Add Book</a>
    <!-- Dark table -->
    <div class="row">
      <div class="col">
        @include('include.messages')
        <div class="card">
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-hover table-sm">
                      <thead>
                      <tr class="solid-header">
                          <th>#</th>
                          <th>Book Title</th>
                          <th>ISBN</th>
                          <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      @if($books->count() < 1)
                          <tr><td colspan="8" class="text-center">No record found.</td></tr>
                      @else
                          @php $count = method_exists($books, 'links') ? 1 : 0; @endphp
                          @foreach($books as $book)
                              @php $count = method_exists($books, 'links') ? ($books->currentpage()-1) * $books->perpage() + $loop->index + 1 : $count + 1; @endphp
                              <tr>
                                  <td>{{ $count }}</td>
                                  <td>
                                         {{$book->title}} 
                                      
                                      </td>
                                  <td>{{ $book->isbn }}</td>
                                  <td>
                                      <div class="dropdown dropleft">
                                          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                              <i class="fa fa-ellipsis-v"></i>
                                          </button>
                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                              <a class="dropdown-item" data-toggle="modal" data-target="#deleteBook{{$book->id}}" href="#">Delete</a>
                                              <a class="dropdown-item" data-toggle="modal" data-target="#editBook{{$book->id}}" href="#">Edit</a>
                                              <a class="dropdown-item" data-toggle="modal" data-target="#archiveBook{{$book->id}}" href="#">Archieve</a>

                                          </div>
                                      </div>

                                  </td>
                      {{-------------------------------------------Edit Book--------------------------------}}
                      <div class="modal fade" id="editBook{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="newUserModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="newUserModalLabel">Edit Book</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{ route('update', $book->id) }}" method="POST" id="submitForm">
                                      @csrf
                                     
                                      <div class="form-group">
                                          <label for="recipient-name" class="col-form-label">Title *</label>
                                      <input type="text" class="form-control" name="title" value="{{ $book->title }}" >
                                      </div>
                  
                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">ISBN *</label>
                                        <input type="number" class="form-control" name="isbn" value="{{ $book->isbn }}" >
                                    </div>
                                      <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Description </label>
                                        <textarea rows="4" class="form-control" name='description' >{{ $book->description }}</textarea>
                                    </div>
                                    <div class="form-group">
                                      <label for="recipient-name" class="col-form-label">About Author *</label>
                                      <textarea rows="4" class="form-control" name='about_author' >{{ $book->about_author }}</textarea>
                                  </div>
                                      <hr/>
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-neutral">Add book</button>
                                  </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                                  {{-- Archive a book           --}}

                                  <div class="modal fade" id="archiveBook{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="newUserModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="newUserModalLabel">Archive Book</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <form action="{{ route('archive', $book->id) }}" method="POST" id="submitForm">
                                                      @csrf
                                                      @method('DELETE')
                                                      <div class="form-group">
                                                          <i style="font-style: normal;">Are you sure about this decision?</i>
                                                      </div>
                                                      <div class="form-group">
                                                          {{--                                                                    <label for="recipient-name" class="col-form-label">Category Name *</label>--}}
                                                          <input type="hidden" class="form-control" name="name" value="{{$book->id}}">
                                                      </div>

                                                      {{--                                                                <hr/>--}}
                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                      <button type="submit" class="btn btn-primary">Yes</button>
                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  {{-- Archive a book           --}}

                                  <div class="modal fade" id="deleteBook{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="newUserModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="newUserModalLabel">Delete Book</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('delete', $book->id) }}" method="POST" id="submitForm">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="form-group">
                                                        <i style="font-style: normal;">Are you sure about this decision?</i>
                                                    </div>
                                                    <div class="form-group">
                                                        {{--                                                                    <label for="recipient-name" class="col-form-label">Category Name *</label>--}}
                                                        <input type="hidden" class="form-control" name="name" value="{{$book->id}}">
                                                    </div>

                                                    {{--                                                                <hr/>--}}
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Yes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
          </tr>
      @endforeach
  @endif
  </tbody>
</table>
  <div class="irs_pagination">
      {{ $books->links() }}
  </div>
              </div>

          </div>
      </div>
      </div>
    </div>
    <!-- Footer -->
    <footer class="footer pt-0">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg-6">
          <div class="copyright text-center  text-lg-left  text-muted">
            &copy; 2020 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative Tim</a>
          </div>
        </div>
        <div class="col-lg-6">
          <ul class="nav nav-footer justify-content-center justify-content-lg-end">
            <li class="nav-item">
              <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
            </li>
            <li class="nav-item">
              <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
            </li>
            <li class="nav-item">
              <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link" target="_blank">MIT License</a>
            </li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
{{-- Modal for adding of book --}}
  <div class="modal fade" id="defaultDurationModal" tabindex="-1" role="dialog" aria-labelledby="newUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newUserModalLabel">Add a Book</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="{{ ('/store') }}" method="POST" id="submitForm">
                    @csrf
                   
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Title *</label>
                        <input type="text" class="form-control" name="title" >
                    </div>

                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">ISBN *</label>
                      <input type="number" class="form-control" name="isbn" >
                  </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Description </label>
                      <textarea rows="4" class="form-control" name='description' placeholder="A detail description of the book..." ></textarea>
                  </div>
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">About Author *</label>
                    <textarea rows="4" class="form-control" name='about_author' placeholder="About the author..." ></textarea>
                </div>
                    <hr/>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-neutral">Add book</button>
                </form>
            </div>
        </div>
    </div>
</div>
    
@endsection