<x-app-layout>
    <x-slot name="header">
        @include("headerLayoutPage")
    </x-slot>

    <div class="py-12" id="findClassroom">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-5" id="content">
                <div class="d-flex justify-content-center my-4">
                    <button class="btn btn-primary " @click="find=!find">
                        <span v-if="find==false">
                            Search Class Room
                        </span>
                        <span v-else>
                            List Class Room
                        </span>
                    </button>
                </div>
                <div v-if="find==true">

                    <div>
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Part</th>
                                    <th>Title</th>
                                    <th>Room</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" v-model="id">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" v-model="name">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" v-model="part">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" v-model="title">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" v-model="room">
                                        </div>
                                    </td>
                                    <td>
                                        Save/Delete
                                    </td>
                                </tr>
                                <tr v-for="(classroom,i) in listFindClass" :key="i">
                                    <form action="" method="" v-on:submit.prevent="onSubmit">
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="id" :value="classroom.id "
                                                    disabled>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name_class"
                                                    v-model="classroom.nameclass ">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="part"
                                                    v-model="classroom.part">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="title"
                                                    v-model="classroom.title">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="room"
                                                    v-model="classroom.room">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <input type="button" class="btn btn-warning" value="Save"
                                                    @click="updateClassroom(i)" />
                                                <input type="button" class="btn btn-danger" value="delete"
                                                    @click="deleteClassroom(i)" />
                                            </div>
                                    </form>



                                </tr>



                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-else>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Part</th>
                                <th>Title</th>
                                <th>Room</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(classroom,i) in listClass" :key="i">
                                <form action="" method="" v-on:submit.prevent="onSubmit">
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="id_class"
                                                :value="classroom.id " disabled>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name_class"
                                                v-model="classroom.nameclass ">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="part"
                                                v-model="classroom.part">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="title"
                                                v-model="classroom.title">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="room"
                                                v-model="classroom.room">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <input type="button" class="btn btn-warning" value="Save"
                                                @click="updateClassroom(i)" />
                                            <input type="button" class="btn btn-danger" value="delete"
                                                @click="deleteClassroom(i)" />
                                        </div>
                                </form>



                            </tr>



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>