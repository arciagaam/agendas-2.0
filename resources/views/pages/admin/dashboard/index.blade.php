<x-main-layout>
    <div class="flex flex-col">
        
        <div class="flex flex-col gap-5">
            <div class="flex flex-col">
                <h1 class="text-lg font-bold text-project-accent-600 z-20 mt-5">Welcome, Admin!</h1>
                <h1 class="text-4xl font-bold z-20 my-5">Sorry for the inconvenience, this page is still under development.</h1>
                <p class="text-lgz-20">For now, you may only use the following functions:</p>
            </div>

            <div class="lg:w-1/2 sm:w-full flex flex-row my-5 gap-5">
                <div class="ring-1 ring-project-gray-default p-5 rounded-lg flex flex-col gap-3 text-project-primary-700 hover:ring-project-accent-500 transition-all duration-200">
                    <h1 class="text-lg font-bold">Information Management</h1>
                    <ul class="ml-5 list-disc pl-3 flex flex-col gap-2">
                        <li><a class="hover:text-project-accent-500 duration-100" href="{{route('admin.information.buildings.index')}}">Buildings</a></li>
                        <li><a class="hover:text-project-accent-500 duration-100" href="{{route('admin.information.buildings.index')}}">Rooms</a></li>
                        <li><a class="hover:text-project-accent-500 duration-100" href="{{route('admin.information.buildings.index')}}">Classrooms</a></li>
                        <li><a class="hover:text-project-accent-500 duration-100" href="{{route('admin.information.buildings.index')}}">Schedule Templates</a></li>
                        <li><a class="hover:text-project-accent-500 duration-100" href="{{route('admin.information.buildings.index')}}">Teachers</a></li>
                        <li><a class="hover:text-project-accent-500 duration-100" href="{{route('admin.information.buildings.index')}}">Subjects</a></li>
                    </ul>
                </div>
                <div class="ring-1 ring-project-gray-default p-5 rounded-lg flex flex-col gap-3 text-project-primary-700 hover:ring-project-accent-500 transition-all duration-200">
                    <h1 class="text-lg font-bold">Assignment Module</h1>
                    <ul class="ml-5 list-disc pl-3 flex flex-col gap-2">
                        <li><a class="hover:text-project-accent-500 duration-100" href="{{route('admin.assignments.teachers.index')}}">Teacher Assignment</a></li>
                    </ul>
                </div>
                <div class="ring-1 ring-project-gray-default p-5 rounded-lg flex flex-col gap-3 text-project-primary-700 hover:ring-project-accent-500 transition-all duration-200">
                    <h1 class="text-lg font-bold">Schedules</h1>
                    <ul class="ml-5 list-disc pl-3 flex flex-col gap-2">
                        <li><a class="hover:text-project-accent-500 duration-100" href="{{route('admin.schedules.classes.index')}}">Class Schedules</a></li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col">
                <p class="text-lgz-20">...and these are the modules that you can expect in the near future:</p>
            </div>

            <div class="w-full flex flex-col my-5 gap-5">
                <div class="ring-1 ring-project-gray-default p-5 rounded-lg flex flex-col gap-3 text-project-primary-700 hover:ring-amber-500 transition-all duration-200">
                    <h1 class="text-lg font-bold">Schedules</h1>
                    <ul class="ml-5 list-disc pl-3 flex flex-col gap-2">
                        <li><a class="hover:text-amber-500 duration-100">Exam Schedules</a></li>
                        <li><a class="hover:text-amber-500 duration-100">Events</a></li>
                    </ul>
                </div>
                <div class="ring-1 ring-project-gray-default p-5 rounded-lg flex flex-col gap-3 text-project-primary-700 hover:ring-amber-500 transition-all duration-200">
                    <h1 class="text-lg font-bold">Reports</h1>
                    <ul class="ml-5 list-disc pl-3 flex flex-col gap-2">
                        <li><a class="hover:text-amber-500 duration-100">Generate Reports</a></li>
                    </ul>
                </div>
                <div class="ring-1 ring-project-gray-default p-5 rounded-lg flex flex-col gap-3 text-project-primary-700 hover:ring-amber-500 transition-all duration-200">
                    <h1 class="text-lg font-bold">User Management</h1>
                    <ul class="ml-5 list-disc pl-3 flex flex-col gap-2">
                        <li><a class="hover:text-amber-500 duration-100">Manage Accounts</a></li>
                        <li><a class="hover:text-amber-500 duration-100">Manage Roles</a></li>
                    </ul>
                </div>
                <div class="ring-1 ring-project-gray-default p-5 rounded-lg flex flex-col gap-3 text-project-primary-700 hover:ring-amber-500 transition-all duration-200">
                    <h1 class="text-lg font-bold">System Variables</h1>
                    <ul class="ml-5 list-disc pl-3 flex flex-col gap-2">
                        <li><a class="hover:text-amber-500 duration-100">Manage System Variables</a></li>
                    </ul>
                </div>
            </div>
            
        </div>

    </div>
</x-main-layout>