<div id="headerClassroom">
  {{-- <div :style="{'background-image':'url(https://drive.google.com/thumbnail?id='+'{{$classroom->img}}'+')'}"> --}}
  @if(isset($classroom))
  <div class="row">
    <div class="col-md-4">
      <a href="{{route('classroom.show',$classroom->id)}}">{{$classroom->nameclass}}</a>

      <a type="button" class="text-success ml-md-3" data-toggle="modal" data-target="#modalSetting">
        <i class="fas fa-tools"></i>
      </a>

      <!-- The Modal -->
      <div class="modal" id="modalSetting">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title ">Classroom Information</h4>
              <div class="ml-3">
                @if(trim(Auth::user()->role_user)=="teacher"&&
                Auth::id()==$classroom->id_owner||trim(Auth::user()->role_user)=="admin")
                <form action="{{route('classroom.destroy',$classroom->id)}}" method="POST">
                  @csrf
                  <input type="hidden" name="_method" value="DELETE" />
                  <button title="Delete classroom" type="submit" class="text-danger close"
                    @click="deleteClass($event)"><i class="fas fa-trash"></i></button>
                </form>
                @endif
              </div>
              <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>


            <form method="POST" action="{{route("classroom.update",$classroom->id)}}" enctype="multipart/form-data">
              <!-- Modal body -->
              <div class="modal-body">


                @csrf
                <input type="hidden" name="_method" value="PATCH" />
                <div class="form-group">
                  <label for="nameClass">Name Class:</label>
                  <input type="text" @if(Auth::user()->role_user=="student"||(
                  Auth::id()!=$classroom->id_owner&&trim(Auth::user()->role_user)=="teacher"))
                  disable="disable"@endif
                  name="name_class" class="form-control" value="{{$classroom->nameclass}}"
                  id="nameClass">
                </div>
                <div class="form-group">
                  <label for="part">Part:</label>
                  <input type="text" @if(Auth::user()->role_user=="student"||(
                  Auth::id()!=$classroom->id_owner&&trim(Auth::user()->role_user)=="teacher"))
                  disable="disable"@endif name="part" class="form-control" value="{{$classroom->part}}" id="part">
                </div>
                <div class="form-group">
                  <label for="title">Title:</label>
                  <input type="text" @if(Auth::user()->role_user=="student"||(
                  Auth::id()!=$classroom->id_owner&&trim(Auth::user()->role_user)=="teacher"))
                  disable="disable"@endif name="title" class="form-control" value="{{$classroom->title}}" id="title">
                </div>
                <div class="form-group">
                  <label for="room">Room:</label>
                  <input type="text" @if(Auth::user()->role_user=="student"||(
                  Auth::id()!=$classroom->id_owner&&trim(Auth::user()->role_user)=="teacher"))
                  disable="disable"@endif name="room" class="form-control" value="{{$classroom->room}}" id="room">
                </div>
                <div class="form-group">
                  <label for="room">Image:</label>
                  <input type="file" @if(Auth::user()->role_user=="student"||(
                  Auth::id()!=$classroom->id_owner&&Auth::user()->role_user=="teacher"))
                  disable="disable"@endif name="img" class="form-control" id="file">
                </div>
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                @if(trim(Auth::user()->role_user)=="teacher"&&
                Auth::id()==$classroom->id_owner||trim(Auth::user()->role_user)=="admin")
                <button type="submit" class="btn btn-warning">Save</button>
                @endif
              </div>
            </form>

          </div>
        </div>
      </div>

    </div>
    <div class="col-md-2 offset-1">
      <ul class="nav nav-tabs justify-content-center">
        <li class="nav-item">
          <a class="nav-link {{isset($stream) ==true?"active":""}}"
            href="{{route('classroom.show',$classroom->id)}}">Steam</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{isset($people) ==true?"active":""}}"
            href="{{route('peopleAndClass.show',$classroom->id)}}">People</a>
        </li>
        @if(Auth::user()->role_user=="admin"||trim(Auth::user()->role_user)=="teacher")
        <li class="nav-item">
          <a class="nav-link " href="#" data-toggle="modal" data-target="#modalCreateAssignment">Assignment</a>
        </li>
        @endif

      </ul>
    </div>
    <div class="col-md-2 offset-md-3">
      <span>Code: <i class="text-danger">{{$classroom->id}}</i></span>
    </div>
  </div>
  @if(isset($status))
  @if($status->state=="assignment")
  <div>
    <span>Deadline:<i>{{$status->deadline}}</i></span>
  </div>
  @endif
  @endif
  <div class="modal fade" id="modalCreateAssignment">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Assignment</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="{{route("classDetails.store")}}" method="post" enctype="multipart/form-data">
          @csrf

          <!-- Modal body -->
          <div class="modal-body">
            <input type="hidden" value="yes" name="assignment">
            <input type="hidden" value="{{$classroom->id}}" name="id_class">
            <div class="form-group">
              <label for="title">Title:</label>
              <input type="text" class="form-control" placeholder="Enter title" name="content" required>
            </div>
            <div class="form-group">
              <label for="description">Description (optional):</label>
              <input type="text" class="form-control" placeholder="Enter description" name="description">
            </div>
            <div class="form-group">
              <input type="file" multiple class="form-control-file" name="my_files[]" id="">
            </div>
            <div class="form-group">
              <label for="deadline">Deadline:</label>
              <input type="date" class="form-control" name="deadline" required>

            </div>


          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Create</button>
          </div>
        </form>

      </div>
    </div>
  </div>
  @endif
  {{-- </div> --}}
</div>