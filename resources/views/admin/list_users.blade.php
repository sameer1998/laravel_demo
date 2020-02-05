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
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                       	@foreach($users as $key =>  $val)
										<tr>
											<td>{{$val['name']}}</td>
											<td>{{$val['email']}}</td>
											<td>{{$val['mobile']}}</td>
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