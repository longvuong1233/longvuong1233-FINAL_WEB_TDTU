<x-app-layout>
    <x-slot name="header">
        @include("headerLayoutClassroom")
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-5" id="content">
                <div class="mt-5">
                    @if(isset($stream))
                    @if($stream==true)
                    @include("streamClassroom")
                    @endif
                    @elseif(isset($people))
                    @if($people==true)
                    @include("peopleClassroom")
                    @endif
                    @elseif(isset($showStatus))
                    @if($showStatus==true)
                    @include("showEachStatusClassroom")
                    @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>