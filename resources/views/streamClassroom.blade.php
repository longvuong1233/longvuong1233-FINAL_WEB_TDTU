<?php 
    use App\Models\User;
?>
<div id="streamClassroom">
    <div class="mb-4">
        <div class="media elementBorderAndShadow">
            <img class=" ml-3 mt-3  h-9 w-9 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                alt="{{ Auth::user()->name }}" />
            <div class="media-body  mt-1 px-4 py-3">
                <form action="{{route("classDetails.store")}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="text" value="{{ $classroom->id}}" hidden name="id_class">
                        <label for="comment">Say something:</label>
                        <textarea class="form-control" rows="3" id="comment" name="content" required></textarea>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="file" multiple class="form-control-file" name="my_files[]" id="">

                            </div>
                        </div>
                        <div class="col-md-3 offset-md-5">
                            <button class="btn btn-danger rounded-circle" type="submit"><i
                                    class="fas fa-paper-plane"></i></button>

                        </div>
                    </div>
                </form>




            </div>


        </div>
    </div>

    <div class="mb-4">
        @if(isset($classDetails))
        @foreach($classDetails->reverse() as $cd)
        <div class="media mb-4 elementBorderAndShadow">

            <img class=" ml-3 mt-3  h-9 w-9 rounded-full object-cover"
                src="{{ User::find($cd->owner)->profile_photo_url }}" alt="{{ User::find($cd->owner)->name }}" />

            <div class="media-body mt-1 px-4 py-3">
                @if(Auth::id() == $cd->owner)
                <form action="{{route('classDetails.destroy',$cd->id)}}" method="post">
                    @csrf
                    <input type="hidden" name="_method" value="delete">
                    <button type="submit" class="close">&times;</button>
                </form>
                @endif

                @if($cd->state=="none")
                <div style="border-bottom:1px solid #c0c0c0">
                    <h4>{{User::find($cd->owner)->name}}<small><i> {{$cd->created_at}}</i></small></h4>
                    <p>{{$cd->content}}</p>

                </div>
                @else
                <a href="{{route("classDetails.show",$cd->id)}}" class="statusItem ">
                    <div>
                        <h4>{{User::find($cd->owner)->name}}<small><i> {{$cd->created_at}}</i></small></h4>
                        @if($cd->state=="item")
                        <p>Posted a new material...</p>
                        @else
                        <p>Posted a new assignment...</p>
                        @endif

                    </div>
                </a>
                @endif
                <a href="#" data-toggle="modal" data-target="#myModal{{$cd->id}}"
                    @click="getComment('{{$cd->id_class}}','{{$cd->id}}')">{{$cd->numComment}}
                    {{($cd->numComment)<= 1?" comment":" comments"}}
                </a>

                <!-- The Modal -->
                <div class="modal" id="myModal{{$cd->id}}">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Class Comments</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <div>
                                    <table v-if="listComment.length!=0">
                                        <tr v-for="comment in listComment" :key="comment.id">

                                            <td>

                                                <div class="media">
                                                    <img class=" ml-3 mt-3  h-7 w-7 rounded-full object-cover"
                                                        :src="comment.nameOwner.profile_photo_url"
                                                        :alt="comment.nameOwner.name" />
                                                    <div class="media-body mt-1 px-4 py-3">
                                                        <div>
                                                            <h6>@{{comment.nameOwner.name}}<small><i>
                                                                        @{{comment.created_at|datetimeFormat}}
                                                                    </i></small>
                                                            </h6>
                                                            <div>
                                                                <span>@{{comment.comment}}</span>
                                                            </div>
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
                                                        <button
                                                            v-if="checkPemission('{{Auth::id()}}','{{trim(Auth::user()->role_user)}}',comment)==true"
                                                            class=" dropdown-item"
                                                            @click="deleteComment(comment.id)">Delete</button>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                    </table>
                                </div>
                                <div class="media ">
                                    <img class=" ml-3 mt-3  h-7 w-7 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    <div class="media-body mt-1 px-4 py-3">

                                        <div class="form-group">

                                            <div class="row">
                                                <label for="" class="col-sm-3">Comment:</label>
                                                <div class="col-sm-7"><input type="text" v-model="comment"
                                                        class="form-control">
                                                </div>
                                                <div class="col-sm-2 "><button class="btn btn-danger rounded-circle"
                                                        @click="leaveComment(' {{$cd->id_class}}','{{$cd->id}}')"><i
                                                            class="fas fa-paper-plane"></i></button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>


            </div>


        </div>
        @endforeach
        @endif
    </div>

</div>