<x-app-layout>
    <x-slot name="header">
        @include("headerLayoutPage")
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-5" id="content">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($listUser))
                        @foreach($listUser as $user)
                        <tr>


                            <td>{{$user->name}}</td>
                            <td>{{$user->phone_number}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>
                                <form action="{{route('user.update',$user->id)}}" method="POST">
                                    <div class="form-group">
                                        @csrf
                                        <input type="hidden" name="_method" value="PATCH">
                                        <select class="form-control" id={{$user->id}} name="role_user">
                                            <option value="teacher" @if($user->role_user=="teacher") selected
                                                @elseif($user->role_user=="admin") disabled="disabled"@endif >Teacher
                                            </option>
                                            <option value="admin" @if($user->role_user=="admin") selected @endif
                                                >Admin
                                            </option>
                                            <option value="student" @if($user->role_user=="student") selected
                                                @elseif($user->role_user=="admin") disabled="disabled"@endif>Student
                                            </option>

                                        </select>
                                    </div>
                            </td>
                            <td><input type="submit" value="Save" class="btn btn-warning" @if($user->role_user=="admin")
                                disabled="disabled"@endif></td>
                            </form>
                        </tr>
                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>