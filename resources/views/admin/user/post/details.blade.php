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
              <li class="breadcrumb-item active">Post Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Post Detail</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
        
          <div class="row">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
            <div class="row">
            @if($post->file_type==1)
            <div class="col-md-12 col-lg-6 col-xl-12">
                <div class="card mb-2">
                   @if(!empty($post->file))
                    <video   width="700" height="240"  controls>
                  <source src="{{url($post->file)}}" type="video/mp4">

                  </video>
                  @endif
                  <div class="card-img-overlay">
                    <h5 class="card-title text-white">{{$post->title}}</h5>
                    <br>
                    <a href="#" class="text-primary">{{date("d-M-Y h:i:sa", strtotime($post->created_at))}}</a>
                  </div>
                </div>
              </div>
            </div>
            @else
              <div class="col-md-12 col-lg-6 col-xl-12">
                <div class="card mb-2">
                   @if(!empty($post->file))
                  <img class="card-img-top" src="{{url($post->file)}}" alt="Dist Photo 3">
                  @endif
                  <div class="card-img-overlay">
                    <h5 class="card-title text-white">{{$post->title}}</h5>
                    <br>
                    <a href="#" class="text-primary">{{date("d-M-Y h:i:sa", strtotime($post->created_at))}}</a>
                  </div>
                </div>
              </div>
            </div>
          
            @endif

            
             
            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
              <h3 class="text-primary"><i class="fas fa-user"></i>  Post by :  {{$post->user_name}}</h3>
              <p class="text-muted"></p>
              <br>
              <div class="text-muted">
              <ul class="list-unstyled">
                <li>
                  <a href="#" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> Post title : <b >{{$post->title}}</b> </a>
                </li>

                <li>
                  <a href="#" class="btn-link text-secondary"><i class="fa fa-venus-mars"></i> Conversation : <b >{{$post->conversation}}</b> </a>
                </li>

                <li>
                  <a href="#" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> Pieces : <b >{{$post->	pieces}}</b> </a>
                </li>
                <li>
                  <a href="#" class="btn-link text-secondary"><i class="far fa-clock" aria-hidden="true"></i> Billing per minute : <b >{{$post->	billing_per_minute}}</b> </a>
                </li>

                <li>
                  <a href="" class="btn-link text-secondary"><i class="far fa-calendar" aria-hidden="true"></i> Post date : {{ date("d-m-Y h:i:sa" ,strtotime($post->created_at))}}</a>
                </li>
              </ul>

            <br>

             
              </div>
              <div class="row">
              <div class="col-md-6 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-thumbs-up"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Likes</span>
                  <span class="info-box-number">0</span>
                </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-6 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-comment" aria-hidden="true"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Comment</span>
                  <span class="info-box-number">0</span>
                </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-6 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-share" aria-hidden="true"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Share</span>
                  <span class="info-box-number">0</span>
                </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-md-6 col-sm-6 col-12">
              <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fa fa-flag" aria-hidden="true"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Report</span>
                  <span class="info-box-number">0</span>
                </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
               
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


@endsection