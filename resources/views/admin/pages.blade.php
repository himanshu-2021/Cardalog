@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper" style="min-height: 1662.75px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item active">Pages Update</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!--About us-->
        <div class="row">
            <div class="col-md-4">
            <div class="form-group">
                <label>About-us Content</label>

                </div>
            </div>
            <div class="col-md-8">
                    <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">About Us  </h3>
                    <div class="card-tools">
                    <span><b> Note: </b> <small>(Only 2000 character length are allowed)</small></span>

                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                        </button>
                    </div>
                    </div>
                    <form action="{{route('admin.page.about-us-update')}}" method="post">
                    @csrf
                    <div class="card-body">
                    <div class="form-group">
                        <textarea class="form-control" name="content" maxlength="2000" required="">
                              <?= @$pages->about_us ?>
                        </textarea>
                    </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                       <button class="btn btn-primary float-right" type="submit">Update</button>

                    </div>
                    <!-- /.card-footer-->
                    </form>
                </div>
            <!-- /.card -->
            </div>

        </div>
        <!--/aboutus-->


        <!--Terms & Conditions-->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                <label>Terms & Conditions Content</label>

                </div>
            </div>
            <div class="col-md-8">
                    <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Terms & Conditions</h3>
                    <div class="card-tools">
                    <span><b> Note: </b> <small>(Only 2000 character length are allowed)</small></span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                        </button>
                    </div>
                    </div>
                    <form action="{{route('admin.page.content.terms-conditions-update')}}" method="post">
                    @csrf
                    <div class="card-body">
                    <div class="form-group">
                        <textarea class="form-control" name="content" maxlength="2000" required="">
                              <?= @$pages->terms_conditions ?>
                        </textarea>
                    </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                       <button class="btn btn-primary float-right" type="submit">Update</button>

                    </div>
                    <!-- /.card-footer-->
                    </form>
                    <!-- /.card-footer-->
                </div>
            <!-- /.card -->
            </div>

        </div>
        <!--//Terms & Conditions-->

         <!--Privacy-policy-->
         <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                <label>Privacy Policy Content</label>

                </div>
            </div>
            <div class="col-md-8">
                    <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Privacy Policy</h3>
                    <div class="card-tools">
                    <span><b> Note: </b> <small>(Only 2000 character length are allowed)</small></span>

                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                        </button>
                    </div>
                    </div>
                    <form action="{{route('admin.page.content.privacy-policy-update')}}" method="post">
                    @csrf
                    <div class="card-body">
                    <div class="form-group">
                        <textarea class="form-control" name="content" maxlength="2000" required="">
                              <?= @$pages->privacy_policy ?>
                        </textarea>
                    </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                       <button class="btn btn-primary float-right" type="submit">Update</button>

                    </div>
                    <!-- /.card-footer-->
                    </form>
                </div>
            <!-- /.card -->
            </div>

        </div>
         <!--/Privacy-policy-->

           <!--location_service policy-->
           <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                <label>Location Service Policy Content</label>

                </div>
            </div>
            <div class="col-md-8">
                    <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Location Service Policy</h3>
                    <div class="card-tools">
                    <span><b> Note: </b> <small>(Only 2000 character length are allowed)</small></span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                        </button>
                    </div>
                    </div>
                    <form action="{{route('admin.page.content.location-service-policy-update')}}" method="post">
                    @csrf
                    <div class="card-body">
                    <div class="form-group">
                        <textarea class="form-control" name="content" maxlength="2000" required="">
                              <?= @$pages->location_service_policy ?>
                        </textarea>
                    </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                       <button class="btn btn-primary float-right" type="submit">Update</button>

                    </div>
                    <!-- /.card-footer-->
                    </form>
                </div>
            <!-- /.card -->
            </div>

        </div>
         <!--/location_service policy-->

        </section>
    <!-- /.content -->
  </div>
  <script src="{{ url('public/tinymce/js/tinymce/tinymce.min.js')}}"></script>
<script src="{{ url('public/tinymce/tinymce.js')}}"></script>

@endsection
