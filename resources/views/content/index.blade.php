@extends('admin.master_layout')
@section('content')

                       <!-- page title area end -->
            <div class="main-content-inner">
                <div class="row">
                    <!-- data table start -->
                    <!-- Primary table end -->
                    <!-- Dark table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Manage {{Request::segment(1)}}</h4>
                                <div class="data-tables datatable-dark">
                                    <table id="dataTable3" class="text-center">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                       	@foreach($content as $key =>  $val)
										<tr>
                                            <td>{{$val['id']}}</td>
											<td>{{$val['title']}}</td>
											<td><a href="{{route('content.edit',['flag'=>$val['flag']])}}"><i class="ti-pencil"></i></a></td>
										</tr>
                                       	@endforeach
                                       </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dark table end -->
                </div>
            </div>
        </div>
@endsection