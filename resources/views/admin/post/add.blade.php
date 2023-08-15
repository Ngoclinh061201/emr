@extends('admin.layouts.master')

@section('content')
    <div class="content-wrapper" >
        <div class style="margin-left:5px; ">
            <form action="{{ url('cms/post/store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                @csrf
                <div class="card">
                    <div class="card-header" style= "background-color:#f7f7f7">
                        <strong>Add post</strong>
                    </div>
                    <div class="card-body card-block">
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="name" class=" form-control-label">Name</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="slug" class=" form-control-label">Slug</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="text" id="slug" name="slug" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="image" class=" form-control-label">Image</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="file" id="image" name="image" class="form-control-file">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3">
                                <label for="content" class=" form-control-label">Content</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <textarea id="myeditorinstance" name = "content" cols="124" rows="13"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fa fa-dot-circle-o"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-danger btn-sm">
                            <i class="fa fa-ban"></i> Reset
                        </button>
                    </div>
                </div>
            </form>
        </div> 
    </div>
@endsection