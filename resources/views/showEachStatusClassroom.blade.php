<?php 
    use App\Models\User;
?>
<div id="detailsStatusClassroom">


    <div class="mb-4">
        @if(trim(Auth::user()->role_user)=="admin"||trim(Auth::user()->role_user)=="teacher")
        <div>
            <table>
                <tr>
                    <td><a href="{{route('peopleAndClass.show',$classroom->id)}}">Assigned:</a></td>
                    <td>{{$countPeopleClass}}</td>
                </tr>
                <tr>
                    <td><a href="#" @click="listUserSubmit('{{$status->id}}')" data-toggle="modal"
                            data-target="#listSubmit">Turned in:</a></td>
                    <td>On Time ({{$countSubmitOntime}})</td>
                    <td>Lated ({{$countSubmitLate}})</td>
                </tr>
            </table>
        </div>
        @elseif($isSubmitAssignment==false)
        <form action="{{route("submitassignment")}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{$status->id}}" name="id_status">
            <div class="form-group">
                <label for="">Submit assignment:</label>
                <input type="file" multiple class="form-control-file" name="my_files[]" id="sds">
            </div>
            <div class="form-group">
                <button class="btn btn-success" type="submit">Turned
                    in</button>
            </div>
        </form>
        @elseif($isSubmitAssignment==true)
        @if($inforSubmit->state=="late")
        <h3>Lated</h3>
        @else
        <h3>On Time</h3>
        @endif
        <form method="GET" action="{{route("submitagain",$status->id)}}">
            @csrf
            <button class="btn btn-danger" @click="submitAssignmentAgain($event)">Turn in again</button>
        </form>
        @endif
    </div>
    <div class="media mb-4 elementBorderAndShadow">
        <img class=" ml-3 mt-3  h-9 w-9 rounded-full object-cover"
            src="{{User::find($status->owner)->profile_photo_url }}" alt="{{ User::find($status->owner)->name}}" />
        <div class="media-body mt-1 px-4 py-3">
            <div class="">
                <h4>{{ User::find($status->owner)->name}}<small><i> {{$status->created_at}}</i></small></h4>

                <p>
                    <h4>{{$status->content}}</h4>
                    {{$status->description}}
                </p>

                <div class="row">
                    @if(isset($listStore))

                    @foreach($listStore as $ls)
                    @if($ls->type=="png"||$ls->type=="jpg")
                    <div>
                        @if(Auth::user()->role_user=="teacher"||Auth::user()->role_user=="admin")
                        <form action="{{route("classStore.destroy",$ls->id)}}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit" class="close" @click="confirmSubmitDelete($event)">&times;</button>
                        </form>
                        @endif
                        <a href="{{route('getfile',$ls->base_name)}}"> <img class="imgThumbnail h-15 w-15 ml-md-4"
                                src="{!! url("https://drive.google.com/thumbnail?id={$ls->base_name}") !!}"
                                alt="file" />
                        </a>
                    </div>
                    @elseif($ls->type=="pdf"||$ls->type=="html")
                    <div>
                        @if(Auth::user()->role_user=="teacher"||Auth::user()->role_user=="admin")
                        <form action="{{route("classStore.destroy",$ls->id)}}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit" class="close" @click="confirmSubmitDelete($event)">&times;</button>
                        </form>
                        @endif <a href="{{route('getfile',$ls->base_name)}}"> <img
                                class="imgThumbnail h-15 w-15 ml-md-4" src="{!! url("https://drive.google.com/thumbnail?id=1Sb8-tKWQOgHcwEMCqn7zGGrlZg_QK9yc") !!}"
                                alt="file" />

                        </a>
                    </div>

                    @elseif($ls->type=="doc"||$ls->type=="docx")
                    <div>
                        @if(Auth::user()->role_user=="teacher"||Auth::user()->role_user=="admin")
                        <form action="{{route("classStore.destroy",$ls->id)}}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit" class="close" @click="confirmSubmitDelete($event)">&times;</button>
                        </form>
                        @endif <a href="{{route('getfile',$ls->base_name)}}"> <img
                                class="imgThumbnail h-15 w-15 ml-md-4" src="{!! url("https://drive.google.com/thumbnail?id=1aNGEJg4UwhLW4sqRwlt0qz163Tkk6YQA") !!}"
                                alt="file" />
                        </a>
                    </div>

                    @elseif($ls->type=="zip"||$ls->type=="rar")
                    <div>
                        @if(Auth::user()->role_user=="teacher"||Auth::user()->role_user=="admin")
                        <form action="{{route("classStore.destroy",$ls->id)}}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit" class="close" @click="confirmSubmitDelete($event)">&times;</button>
                        </form>
                        @endif <a href="{{route('getfile',$ls->base_name)}}"> <img
                                class="imgThumbnail h-15 w-15 ml-md-4" src="{!! url("https://drive.google.com/thumbnail?id=1GAJVwTVoMc5QCV5Sx4YZ9_RqHkNBLOoH") !!}"
                                alt="file" />
                        </a>
                    </div>
                    @else
                    <div>
                        @if(Auth::user()->role_user=="teacher"||Auth::user()->role_user=="admin")
                        <form action="{{route("classStore.destroy",$ls->id)}}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit" class="close" @click="confirmSubmitDelete($event)">&times;</button>
                        </form>
                        @endif
                        <a href="{{route('getfile',$ls->base_name)}}">
                            <img class="imgThumbnail h-15 w-15 ml-md-4" src="{!! url("https://drive.google.com/thumbnail?id=1tWwHmWQwuKYZVKK7iyXF95AqesSxsqKR") !!}"
                                alt="file" />
                        </a>
                    </div>
                    @endif
                    @endforeach
                    @endif
                    <br>
                    @if(Auth::user()->role_user=="teacher"||Auth::user()->role_user=="admin")
                    <div class="ml-5">
                        <form action="{{route('classStore.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{$status->id}}" name="id_status">
                            <div class="form-group">
                                <input type="file" multiple class="form-control-file" name="my_files[]">

                            </div>
                            <div class="form-group">
                                <button class=" btn btn-success" type="submit">Add</button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>

            </div>

        </div>






    </div>
    <a href="#" @click="onclick('{{$status->id_class}}','{{$status->id}}')">
        <h5>Class Comments</h5>
    </a>
    <div v-if="displayComment==true">
        <div>
            <table v-if="listComment.length!=0">
                <tr v-for="comment in listComment" :key="comment.id">

                    <td>

                        <div class="media">
                            <img class=" ml-3 mt-3  h-7 w-7 rounded-full object-cover"
                                :src="comment.nameOwner.profile_photo_url" :alt="comment.nameOwner.name" />
                            <div class="media-body mt-1 px-4 py-3">

                                <h6>@{{comment.nameOwner.name}}<small><i>
                                            @{{comment.created_at|datetimeFormat}}
                                        </i></small>
                                </h6>
                                <div>
                                    <span>@{{comment.comment}}</span>
                                </div>

                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" data-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item" @click="deleteComment(comment.id)">Delete</button>
                            </div>
                        </div>
                    </td>

                </tr>

            </table>
        </div>
        <div class="media ">
            <img class=" ml-3 mt-3  h-7 w-7 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                alt="{{ Auth::user()->name }}" />
            <div class=" mt-1 px-4 py-3">

                <div class="form-group">

                    <div class="row">
                        <label for="" class="col-sm-3">Comment:</label>
                        <div class="col-sm-7"><input type="text" v-model="comment" class="form-control">
                        </div>
                        <div class="col-sm-2 "><button class="btn btn-danger rounded-circle"
                                @click="leaveComment('{{$status->id_class}}','{{$status->id}}')"><i
                                    class="fas fa-paper-plane"></i></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-xl" id="listSubmit">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">List Submit</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Turned in at</th>
                                <th>State</th>
                                <th>Files</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($listSubmit))
                            @foreach ($listSubmit as $item)
                            <tr>
                                <td>{{$item->username}}</td>
                                <td>{{$item->submitAt}}</td>
                                <td>{{$item->state}}</td>

                                <td>
                                    <table>
                                        @foreach($item->files as $fl)
                                        <tr>
                                            <td><a href="{{route("getfile",$fl)}}">download</a></td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Modal footer -->
                <div class=" modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

</div>