@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row " style=" margin-bottom: 20px; margin-left:10px">
                    <label for ="search" style="display: flex; align-items: center;"></label>
                    <input type="text" name="search" id="searchh" value="" placeholder="   Tìm kiếm bằng Tên, Nội dung,.." style="width: 500px; height:40px; margin-right: 10px; border-radius: 25px;">
                    <button id="search-submit" class="btn btn-primary" style= " color:white">Tìm kiếm</button>
            
                <div class="row " style=" margin-left: 100px">
                <a href="{{ url('cms/post/create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm bài viết
                </a>
            </div>
        </div>
            <!-- /.row -->
@include('admin.layouts.alert')
                <!-- Main content -->
                <div class="row">
                    <div class="col-12">
                      <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            
                            <li class="nav-item">
                              <a class="nav-link" id="post-tab-first">Tất cả bài viết</a>
                            </li>
                          </ul>
                        </div>
                        <div class="card-body">
                        
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                          
                            <div>
                                <!-- Appointment content -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <!-- <h3 class="card-title">Tất cả cuộc hẹn</h3> -->

                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0 loadAjax">
                                                <table class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Stt</th>
                                                            <th>Name</th>
                                                            <th>Image</th>
                                                            <th>Content</th>
                                                            <th>View</th>
                                                            <th>Created</th> 
                                                            <th>Updated</th> 
                                                        </tr>
                                                    </thead>
                                                     <tbody>
                                                        {{-- @foreach ($post as $key => $p)
                                                       <tr class="tr-shadow">
                                                            <td>
                                                                {{ ++$key }}
                                                            </td>
                                                            <td>
                                                                {{ $p->name }}
                                                            </td>
                                                            <td>
                                                                <img src="{{ asset('assets/uploads/post/' . $p->image) }}" alt="Image here"
                                                                    class="image-custom">
                                                            </td>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-primary"><a class="text-white" href="{{url('blog/'. $p->slug)}}">View
                                                                        detail</a></button>
                                                            </td>
                                                            <td>
                                                                {{ $p->view }}
                                                            </td>
                                                            <td>
                                                                {{ $p->created_at }}
                                                            </td>
                                                            <td>
                                                                <div class="table-data-feature">
                                                                    <a href="{{ url('cms/post/' . $p->id . '/edit') }}"><button class="item"
                                                                            data-toggle="tooltip" data-placement="top" title="Edit">
                                                                            <i class="zmdi zmdi-edit"></i>
                                                                        </button></a>
                                                                    <form method="POST" action="{{ url('cms/post/' . $p->id) }}">
                                                                        @method('DELETE')
                                                                        @csrf
                                                                        <button onclick="return confirm('Are you sure you want to delete?')" class="item"
                                                                            data-toggle="tooltip" data-placement="top" title="Delete" type="submit"><i
                                                                                class="zmdi zmdi-delete"></i></button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="spacer"></tr>
                                                        @endforeach--}}
                                                    </tbody> 
                                                </table>
                                            </div>

                                            {{-- @if (count($paginateVerifieds) != 0)
                                                {{ $paginateVerifieds->links() }}
                                            @endif --}}
                                            <!-- /.card-body -->
                                        </div>

                                        <!-- /.card -->
                                    </div>
                                </div>
                                <!-- /.content -->
                            </div>
                            </div>
                            
                            </div>
                        <!-- /.card -->
                      </div>
                    </div>
                </div>
                <!-- /.content -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    </div>
@endsection