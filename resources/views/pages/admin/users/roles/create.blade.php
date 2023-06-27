<x-main-layout>
    <x-page.header title="Add New Role" />
    <div class="flex flex-col gap-5">
        <div class="form-input-container pl-5">
            <label for="role_name">Role Name</label>
            <input class="form-input w-1/2" type="text" name="role_name" id="role_name">
        </div>
        <p class="font-semibold text-2xl">Permissions</p>
        <div class="permissions-container flex gap-5">
            <div class="flex flex-col justify-between">
                <div class="module flex flex-col gap-5">
                    <div class=" perm-items flex px-5 items-center justify-between">
                        <div class="flex flex-col">
                            <p class="text-2xl font-medium">Information Management</p>
                            <p class="italic text-sm text-[#717171]">Users with this permission can manage all the
                                information for the scheduling system</p>
                        </div>
                        <button>Toggle</button>
                    </div>
                    <div class="submodule flex flex-col gap-3">
                        <div class=" perm-items flex px-10 items-center justify-between">
                            <div class="flex flex-col">
                                <p class="text-xl">School Year</p>
                                <p class="italic text-sm text-[#717171]">Users with this permission can manage school
                                    years.</p>
                            </div>
                            <button>Toggle</button>
                        </div>
                        <div class=" perm-items flex px-10 items-center justify-between">
                            <div class="flex flex-col">
                                <p class="text-xl">Buildings</p>
                                <p class="italic text-sm text-[#717171]">Users with this permission can manage
                                    buildings.</p>
                            </div>
                            <button>Toggle</button>
                        </div>
                        <div class=" perm-items flex px-10 items-center justify-between">
                            <div class="flex flex-col">
                                <p class="text-xl">Rooms</p>
                                <p class="italic text-sm text-[#717171]">Users with this permission can manage room
                                    information.</p>
                            </div>
                            <button>Toggle</button>
                        </div>
                        <div class=" perm-items flex px-10 items-center justify-between">
                            <div class="flex flex-col">
                                <p class="text-xl">Classrooms</p>
                                <p class="italic text-sm text-[#717171]">Users with this permission can manage
                                    classrooms.</p>
                            </div>
                            <button>Toggle</button>
                        </div>
                        <div class=" perm-items flex px-10 items-center justify-between">
                            <div class="flex flex-col">
                                <p class="text-xl">Schedule Templates</p>
                                <p class="italic text-sm text-[#717171]">Users with this permission can manage schedule
                                    templates.</p>
                            </div>
                            <button>Toggle</button>
                        </div>
                        <div class=" perm-items flex px-10 items-center justify-between">
                            <div class="flex flex-col">
                                <p class="text-xl">Teachers</p>
                                <p class="italic text-sm text-[#717171]">Users with this permission can manage teacher
                                    information.</p>
                            </div>
                            <button>Toggle</button>
                        </div>
                        <div class=" perm-items flex px-10 items-center justify-between">
                            <div class="flex flex-col">
                                <p class="text-xl">Subjects</p>
                                <p class="italic text-sm text-[#717171]">Users with this permission can manage subject
                                    information.</p>
                            </div>
                            <button>Toggle</button>
                        </div>
                    </div>
                </div>
                <hr>
            </div>

            <div class="flex flex-col justify-between">
                <div class="module flex flex-col gap-5">
                    <div class=" perm-items flex px-5 items-center justify-between">
                        <div class="flex flex-col">
                            <p class="text-2xl font-medium">Subject-Teacher Assignment</p>
                            <p class="italic text-sm text-[#717171]">Users with this permission can assign teachers to subjects.</p>
                        </div>
                        <button>Toggle</button>
                    </div>
                </div>
                <hr>
                <div class="module flex flex-col gap-5">
                    <div class=" perm-items flex px-5 items-center justify-between">
                        <div class="flex flex-col">
                            <p class="text-2xl font-medium">Schedules</p>
                            <p class="italic text-sm text-[#717171]">Users with this permission can create schedules.</p>
                        </div>
                        <button>Toggle</button>
                    </div>
                    <div class="submodule flex flex-col gap-3">
                        <div class=" perm-items flex px-10 items-center justify-between">
                            <div class="flex flex-col">
                                <p class="text-xl">Class Schedules</p>
                                <p class="italic text-sm text-[#717171]">Users with this permission can create class schedules.</p>
                            </div>
                            <button>Toggle</button>
                        </div>
                        <div class=" perm-items flex px-10 items-center justify-between">
                            <div class="flex flex-col">
                                <p class="text-xl">Exams</p>
                                <p class="italic text-sm text-[#717171]">Users with this permission can create exam schedules.</p>
                            </div>
                            <button>Toggle</button>
                        </div>
                        <div class=" perm-items flex px-10 items-center justify-between">
                            <div class="flex flex-col">
                                <p class="text-xl">Events</p>
                                <p class="italic text-sm text-[#717171]">Users with this permission can create event schedules.</p>
                            </div>
                            <button>Toggle</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="module flex flex-col gap-5">
                    <div class=" perm-items flex px-5 items-center justify-between">
                        <div class="flex flex-col">
                            <p class="text-2xl font-medium">Reports</p>
                            <p class="italic text-sm text-[#717171]">Users with this permission can manage and print reports.</p>
                        </div>
                        <button>Toggle</button>
                    </div>
                </div>
                <hr>
                <div class="module flex flex-col gap-5">
                    <div class=" perm-items flex px-5 items-center justify-between">
                        <div class="flex flex-col">
                            <p class="text-2xl font-medium">Accounts</p>
                            <p class="italic text-sm text-[#717171]">Users with this permission can manage accounts and their permissions.</p>
                        </div>
                        <button>Toggle</button>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
</x-main-layout>
