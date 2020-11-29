<?php 
    use App\Models\User;
    use App\Models\Classroom;
?>

<x-app-layout>
    <x-slot name="header">
        @include("headerLayoutPage")
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-5" id="content">
                @include("listClassRoom")
            </div>
        </div>
    </div>
    <div id="notify">



        <div id="invite">
            @if(isset($notifyJoinClass))

            @foreach($notifyJoinClass as $nt)
            @if($nt->type=="invite")
            @if(Classroom::find($nt->id_class)!=null)
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Heyy!</strong> Accept to join class <strong
                    class="text-primary">{{(Classroom::find($nt->id_class))->nameclass}}</strong>
                from
                <strong class="text-success"> {{(User::find($nt->sender))->name}}</strong>
                <br>
                <div class="d-flex justify-content-end">
                    <form action="{{route("peopleAndClass.store")}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$nt->id_class}}" class="form-control" name="id_class" />
                        <input type="hidden" value="yes" class="form-control" name="result" />
                        <input type="hidden" value="{{$nt->id}}" class="form-control" name="id_notify" />
                        <input type="hidden" value="invite" class="form-control" name="type" />
                        <input type="submit" class="btn btn-warning" value='Join'>
                    </form>
                    <form action="{{route("peopleAndClass.store")}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$nt->id}}" class="form-control" name="id_notify" />
                        <input type="hidden" value="no" class="form-control" name="result" />
                        <input type="submit" class="btn btn-danger" value='Cancel'>
                    </form>
                </div>
            </div>
            @else
            <div class="alert alert-dark alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Wrong!</strong> Class was deleted!!!
                <br>
                <div class="d-flex justify-content-end">
                    <form action="{{route("peopleAndClass.store")}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$nt->id}}" class="form-control" name="id_notify" />
                        <input type="hidden" value="no" class="form-control" name="result" />
                        <input type="submit" class="btn btn-danger" value='Ok'>
                    </form>
                </div>
            </div>
            @endif
            @endif
            @endforeach
            @endif
        </div>
        <div id="asking">
            @if(isset($notifyJoinClass))

            @foreach($notifyJoinClass as $nt)
            @if($nt->type=="asking")
            @if(Classroom::find($nt->id_class)!=null)
            <div class="alert alert-warning alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Heyy!</strong> <strong class="text-success"> {{(User::find($nt->sender))->name}}</strong> ask to
                join class <strong class="text-primary">{{(Classroom::find($nt->id_class))->nameclass}}</strong>
                <br>
                <div class="d-flex justify-content-end">
                    <form action="{{route("peopleAndClass.store")}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$nt->id_class}}" class="form-control" name="id_class" />
                        <input type="hidden" value="yes" class="form-control" name="result" />
                        <input type="hidden" value="asking" class="form-control" name="type" />
                        <input type="hidden" value="{{$nt->id}}" class="form-control" name="id_notify" />
                        <input type="submit" class="btn btn-warning" value='Accept'>
                    </form>
                    <form action="{{route("peopleAndClass.store")}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$nt->id}}" class="form-control" name="id_notify" />
                        <input type="hidden" value="no" class="form-control" name="result" />
                        <input type="submit" class="btn btn-danger" value='Cancel'>
                    </form>
                </div>
            </div>
            @else
            <div class="alert alert-dark alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Wrong!</strong> Class was deleted!!!
                <br>
                <div class="d-flex justify-content-end">
                    <form action="{{route("peopleAndClass.store")}}" method="post">
                        @csrf
                        <input type="hidden" value="{{$nt->id}}" class="form-control" name="id_notify" />
                        <input type="hidden" value="no" class="form-control" name="result" />
                        <input type="submit" class="btn btn-danger" value='Ok'>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @endif
        @endforeach
        @endif



    </div>

    </div>
</x-app-layout>