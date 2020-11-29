<div id="headerLayout">
    <div class="d-flex justify-content-start">
        <div class="dropdown">
            <button type="button" class="btn btn-success dropdown-toggle  rounded-circle" data-toggle="dropdown">
                <i class="fas fa-plus"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#" title="Join Class" data-toggle="modal"
                    data-target="#modalJoinClass">Join New
                    Class</a>
                @if(trim(Auth::user()->role_user)=="admin"|trim(Auth::user()->role_user)=="teacher")
                <a class="dropdown-item" href="#" title="Create Class" data-toggle="modal"
                    data-target="#modalCreateClass">Create
                    New Class</a>
                @endif

            </div>
        </div>

    </div>


    @if(trim(Auth::user()->role_user)=="admin")

    <div class="d-flex justify-content-center">
        <div class="btn-group">
            <a type="button" class="btn btn-primary" href="{{route('user.index')}}">List Users</a>
            <a type="button" class="btn btn-warning" href="{{route('listClassroomPermission')}}">List Class Room</a>
        </div>

    </div>
    @endif
    @if(trim(Auth::user()->role_user)=="teacher")
    <div class="d-flex justify-content-center">
        <div class="btn-group">
            <a type="button" class="btn btn-warning" href="{{route('listClassroomPermission')}}">My Class Room</a>
        </div>

    </div>
    @endif





    <!-- The Modal -->
    <div class="modal" id="modalJoinClass">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route("askingJoinClass")}}" method="post">
                    @csrf
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Join New Class</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="codeClass">Code Class:</label>
                            <input type="text" v-model="codeClass" class="form-control" id="codeClass" name="id_class"
                                required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-danger" value='Join' @click="submitJoin($event)">
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal" id="modalCreateClass">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Create New Class</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('classroom.store')}}" method="post">
                    @csrf

                    <!-- Modal body -->
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="nameClass">Name Class:</label>
                            <input type="text" v-model="nameClass" class="form-control" id="nameClass" name="nameClass"
                                required>
                            <label for="partClass">Part:</label>
                            <input type="text" v-model="partClass" name="part" class="form-control" id="partClass"
                                required>
                            <label for="titleClass">Title:</label>
                            <input type="text" v-model="titleClass" name="title" class="form-control" id="titleClass"
                                required>
                            <label for="numberRonumberRoomClassom">Room:</label>
                            <input type="text" v-model="roomNumber" name="room" class="form-control"
                                id="numberRoomClass" required>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-danger" value="Create" @click="submitCreate($event)" />
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>