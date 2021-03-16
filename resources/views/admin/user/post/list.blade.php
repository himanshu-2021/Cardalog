@extends('admin.layouts.app')
@section('content')
    
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item active">Post</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
          @if(count($errors->all())>0)
          <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
          </button>
          <ul class="error">
          @foreach($errors->all() as $error)
          <li>{{ $error }}</li> 
          @endforeach 
          </ul>

          </div>
          @endif

            <!-- /.card -->
            @if (session('success'))
            <div class="alert alert-success" role="alert">
            {{ session('success') }}

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true"><i class="fas fa-close"></i></span>
            </button>
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="fas  fa-close"></i></span>
             </button>
            </div>
          @endif
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Posts</h3>
                      <div class="form-group">
                <input id="myInput" class="form-control" type="text"  placeholder="Search..">
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" >
                <table id="myTable" class="table table-bordered table-striped"  >
                  <thead>
                    <tr>
                  <th>Sr No</th>
                  <th>Post Title</th>
                  <th>Post by User</th>
                  <th>Media</th>
                  
                  <th>Status</th>
                 
                 
                  <th>Created At</th>
                  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                @php 
                $i=1
                @endphp
                @if(!empty($post) && $post->count())
                @foreach($post as $data)
                <tr>
                <td> {{$i++}}</td>
                <td> <a href="{{url('admin/user/post/details')}}/{{base64_encode($data->id)}}">{{$data->title}}</a></td>
                <td> <a href="{{url('admin/user/profile')}}/{{base64_encode($data->user_id)}}"><span class="badge badge-info"><i class="fa fa-user"></i> {{$data->user_name}}</span></a></td>
                <td> <a href="{{url('admin/user/post/details')}}/{{base64_encode($data->id)}}"><span class="badge badge-warning">Click to view</span></a></td>
              
               
                <td>@if($data->status==1)<span class="badge badge-success">Active</span>@else 
                 <span class="badge badge-danger">Deactive</span>@endif</td>
                
                <td><span class="badge badge-warning">{{ date('d-M-Y h:i:sa', strtotime($data->created_at))}}</span> </td>
                <td> </td>
                </tr>
                @endforeach

                @else
                <tr>
                <td colspan="10">There are no data.</td>
                </tr>
                @endif
                </tbody>

                </table>

                   {!! $post->links() !!}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection