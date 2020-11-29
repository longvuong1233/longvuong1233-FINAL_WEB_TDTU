<?php 
    use App\Models\User;
?>

<div class="px-5" id="peopleClassroom">
    <div class="mb-5">
        <div class="row">
            <h3 class="col-md-3">Teacher</h3>
            <div class="col-md-1 offset-8"> <button class="btn btn-primary"><i class="fas fa-user-plus"></i></button>
            </div>
        </div>
        <div>
            <table>
                @if(isset($peopleAndClass))
                @foreach($peopleAndClass as $pal)
                @if(trim(User::find($pal->id_people)->role_user)=="teacher"||trim(User::find($pal->id_people)->role_user)=="admin")

                <tr>
                    <td>
                        <div class="media">
                            <img class=" ml-3 mt-3  h-7 w-7 rounded-full object-cover"
                                src="{{ User::find($pal->id_people)->profile_photo_url }}"
                                alt="{{ User::find($pal->id_people)->name }}" />
                            <div class="media-body mt-1 px-4 py-3">
                                <div>
                                    <span
                                        @if(User::find($pal->id_people)->role_user=='admin')class="text-danger"@endif>{{ User::find($pal->id_people)->name }}</span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endif
                @endforeach
                @endif
            </table>
        </div>
        <hr>
    </div>

    <div class="mb-4">
        <div class="row">
            <h3 class="col-md-3">Student</h3>

            <div class="col-md-1 offset-8"> <button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#myModal">
                    <i class="fas fa-user-plus"></i>
                </button></div>
        </div>
        <div>
            <table>
                @if(isset($peopleAndClass))
                @foreach($peopleAndClass as $pal)

                @if(trim(User::find($pal->id_people)->role_user)=="student")

                <tr>
                    <td>
                        <div class="media">
                            <img class=" ml-3 mt-3  h-7 w-7 rounded-full object-cover"
                                src="{{ User::find($pal->id_people)->profile_photo_url }}"
                                alt="{{ User::find($pal->id_people)->name }}" />
                            <div class="media-body mt-1 px-4 py-3">
                                <div class="dropup">
                                    <span class="dropdown-toggle"
                                        data-toggle="dropdown">{{ User::find($pal->id_people)->name }}</span>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Infor</a>
                                        @if(Auth::user()->role_user=="admin"||Auth::user()->role_user=="teacher")
                                        <form action="{{route('peopleAndClass.destroy',$pal->id_people)}}"
                                            method="post">
                                            @csrf
                                            <input type="hidden" name="_method" value="delete">
                                            <input type="hidden" name="id_class" value="{{$pal->id_class}}">
                                            <input type="submit" value="Delete" class="dropdown-item"
                                                @click="submitDelete($event)">
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>



                        </div>
        </div>
        </td>
        </tr>
        @endif
        @endforeach
        @endif
        </table>
    </div>
    <hr>
</div>


<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Invite Student</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form action="{{route("inviteClass")}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" value="{{$classroom->id}}" name="id_class">
                        <label>Email:</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Invite</button>
                </div>
            </form>

        </div>
    </div>
</div>
</div>