@extends('admin.master_layout')
@section('content')
<div class="col-12">
                                <div class="card mt-5">
                                    <div class="card-body">
                                        <h4 class="header-title">Edit Content</h4>
                                        <form class="needs-validation" novalidate="" action="{{route('content.update',['id'=>$content->id])}}" method="post">
                                            <div class="form-row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom01">Title</label>
                                                    <input type="text" class="form-control" id="validationCustom01" name="title" placeholder="Title" value="{{$content->title}}" required="">
                                                    <div class="valid-feedback">
                                                        Looks good!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <div class="col-md-6 mb-3">
                                                    <label for="validationCustom01">Title</label>
                                                 <textarea name="content" class="form-control">{{$content->content}}</textarea>
                                                 </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit">Submit form</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
@endsection