@extends('admin.layouts.app')
@section('content')

    
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item active">Users List</li>
            </ol>
          </div>
          

        </div>
      </div><!-- /.container-fluid -->
    </section>

   
    <!-- Main content -->
    <section class="content">

      <!--filter-start-->
      <div class="card card-solid">
        <div class="card-body pb-0">
        <form action="{{route('admin.user.search')}}" method="post">
       @csrf
        <div class="row">
             <div class="col-8 col-sm-6 col-md-8">
                <div class="form-group"><input type="text" name="keyword" class="form-control" placeholder="Search for: Name / Mobile / Email / Dob / Location"></div>
              
            </div>
            <div class="col-4 col-sm-6 col-md-4">
                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Search by fillter</button>
            </div>
          </div>
        </form>
          
<hr><br>
        <!--filter-close-->
          <div class="row d-flex align-items-stretch">
      
            @if(count($users)>0)
            @foreach($users as $details)
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
              <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0">
                <i class="ionicons ion-ios-person"></i> {{$details->name}} ({{$details->nick_name}})
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                  
                    <div class="col-7">
                    
                  
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                      <li class="small"><span class="fa-li"><i class="ionicons ion-email"></i></span>
                          {{$details->email}}
                        </li>
                        <li class="small"><span class="fa-li"><i class="ionicons ion-male"></i></span>
                          {{$details->gender}}
                        </li>

                        <li class="small"><span class="fa-li"><i class="ionicons ion-ios-calendar"></i></span>
                          {{date("d-m-Y",strtotime($details->dob))}}
                        </li>
                        <li class="small"><span class="fa-li"><i class="ionicons ion-location"></i></span>
                           Madhay / India 
                        </li>
                        
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>
                         Contact Details: {{$details->contact_details}}
                        </li>
                        <li class="small">
                        <span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                         Phone #: {{$details->mobile}}</li>

                         
                      </ul>
                    </div>
                    <div class="col-5 text-center">
                     @if(empty($details->avatar))
                      <img src="{{ url('public/admin/images/profile_av.png')}}" alt="user-avatar" class="img-circle img-fluid">
                      @else
                      <img src="{{ url($details->avatar)}}" alt="user-avatar" class="img-circle img-fluid">
                      @endif
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                  @if($details->login_status !=0)
                  <span class="badge bg-success navbar-badge">Online</span>
                  @else
                  <span class="badge badge-danger navbar-badge">off Online</span>
                  @endif
                 
                        @if($details->account_status ==0)
                             <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="customSwitch3">
                                <label class="custom-control-label" for="customSwitch3">Account status</label>
                                </div>
                            </div>
                            @else
                            <div class="form-group">
                                <div class="custom-control custom-switch custom-switch-off-success custom-switch-on-danger">
                                <input type="checkbox" class="custom-control-input" id="customSwitch4">
                                <label class="custom-control-label" for="customSwitch4">Account status</label>
                                </div>
                            </div>
                            @endif
                            
                 
                    <a href="{{route('admin.user.videos')}}" class="btn btn-sm bg-teal">
                    <i class="ionicons ion-videocamera"></i>
                    </a>
                    <a href="{{url('admin/user/profile')}}/{{ base64_encode($details->id) }}" class="btn btn-sm btn-primary">
                      <i class="fas fa-user"></i> View Profile
                    </a>
                    <a href="#" data-toggle="modal" data-target="#edit-profile{{$details->id}}" class="btn btn-sm btn-info">
                    <i class="ionicons ion-edit"></i>
                    </a>
                    <a href="{{url('admin/user/acount-delete') }}/{{ base64_encode($details->id) }}" onclick="return confirm('Are you sure you want to delete this user account ?');"
			            class="btn btn-sm btn-danger " >
                      <i class="fas fa-trash"></i> 
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <!--EEdit profile model-->
            <form method="POST" action="{{ route('admin.user.account-update') }}" >
                  @csrf
                  <div class="modal fade" id="edit-profile{{$details->id}}">
               
              <div class="modal-dialog modal-lg">
            
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">User edit profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                  <input type="hidden" name="userId" value="{{$details->id}}">
                     <div class="row">
                      <div class="col-md-6 form-group">
                        <label>Name</label>
                          <input type="text" class="form-control" name="name" maxlength="50" placeholder="Enter your name" value="{{$details->name}}">
                      </div>
                      <div class="col-md-6 form-group">
                        <label>Nick name</label>
                          <input type="text" class="form-control" name="nick_name" maxlength="50" placeholder="Enter nick name" value="{{$details->nick_name}}">
                      </div>

                      <div class="col-md-6 form-group">
                        <label>Gender</label>
                         <select name="gender" class="form-control">
                         <option value="">Select Gender</option>
                          <option value="male"  @if($details->gender=='male')selected @endif>Male</option>
                          <option value="female" @if($details->gender=='female')selected @endif>Female</option>
                         </select>
                      </div>

                      <div class="col-md-6 form-group">
                        <label>Mobile</label>
                         <input type="text" class="form-control"  name="mobile" maxlength="50" placeholder="Enter mobile number" value="{{$details->mobile}}">
                      </div>

                      <div class="col-md-6 form-group">
                        <label>Email</label>
                         <input type="text" class="form-control" name="email" maxlength="50" placeholder="Enter email " value="{{$details->email}}">
                      </div>

                      <div class="col-md-6 form-group">
                        <label>Acount status</label>
                         <select name="account_status" class="form-control">
                         <option value="">select acount status</option>
                          <option value="1"@if($details->account_status==1) selected @endif>Active</option>
                          <option value="0"@if($details->account_status==0) selected @endif>Suspend</option>
                         </select>
                      </div>

                      
                      <div class="col-md-12 form-group">
                        <label>Contact details</label>
                         <textarea name="contact_details" class="form-control">{{$details->contact_details}}</textarea>
                      </div>

                     </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" onclick="this.form.submit()" class="btn btn-primary">Update profile</button>
                  </div>
                </div>
                <!-- /.modal-content -->
               
              </div>
              <!-- /.modal-dialog -->
              
            </div>
            </form>
            <!--Edit profile close-->
             @endforeach
             @else
             <div class="card-body">
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i>Users Status !</h5>Users List not found
                </div>
        
              </div>

            
              @endif
           
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <nav aria-label="Contacts Page Navigation">
           {{ $users->links() }}
          </nav>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
 
  <!-- /.content-wrapper -->

</div>


@endsection