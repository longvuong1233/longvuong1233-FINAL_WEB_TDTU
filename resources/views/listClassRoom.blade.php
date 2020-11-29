<?php 

use App\Models\User;
?>

<div class="row">
    @if(isset($listClassroom))
    @foreach($listClassroom as $classroom)
    <div class="col-md-3 my-3">

        <div class="card">
            <div style="float: right; position: absolute; top:-5%; left:90%">
                <img class="h-17 w-17 rounded-full object-cover"
                    src="{{ User::find($classroom->id_owner)->profile_photo_url }}"
                    alt="{{ User::find($classroom->id_owner)->name }}"
                    title="{{ User::find($classroom->id_owner)->name }}" />
            </div>
            <img class="card-img-top h-20" src="{!! url("https://drive.google.com/thumbnail?id={$classroom->img}") !!}"
                alt="Card image">
            <div class="card-body">
                <h4 class="card-title">{{$classroom->nameclass}}</h4>
                <p class="card-text">{{$classroom->title}}</p>
                <a href="{{route('classroom.show',$classroom->id)}}" class="btn btn-primary">Open Class</a>
                @if(Auth::user()->role_user=="student"||(Auth::user()->role_user=="teacher"&&Auth::id()!=$classroom->id_owner))
                <form action="{{route('peopleAndClass.destroy',Auth::id())}}" method="post">
                    @csrf
                    <input type="hidden" name="_method" value="delete">
                    <input type="hidden" name="id_class" value="{{$classroom->id}}">
                    <button type="submit" title="Delete Class!" class="close">&times;</button>
                </form>
                @endif

            </div>

        </div>
    </div>
    @endforeach
    @endif

</div>