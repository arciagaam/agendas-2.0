<nav id="side_nav" class="fixed max-w-[3.5rem] h-full top-0 left-0 bg-black text-white z-50 overflow-x-hidden transition-all ease-in-out duration-500 delay-0">
    <div class="flex flex-col w-full items-start pl-4 gap-5">
        <div id="nav-chevron" class="flex items-center justify-center cursor-pointer min-h-[3.5rem] transition-all ease-in-out duration-500 delay-0 ml-0">
            <box-icon name='chevrons-right' type='solid' color="white"></box-icon>
        </div>

        <div class="flex flex-col gap-6 pr-4">
            <x-navigation.navlink name="home-alt" label="Dashboard" url="{{route('admin.dashboard')}}"/>

            <x-navigation.nav-accordion label="Information Management" name="info-circle">
                <x-navigation.navlink name="buildings" label="Buildings" url="{{route('admin.information.buildings.index')}}"/>
                <x-navigation.navlink name="door-open" label="Rooms" url="{{route('admin.information.rooms.index')}}"/>
                <x-navigation.navlink name="chalkboard" label="Classrooms" url="{{route('admin.information.classrooms.index')}}"/>
                <x-navigation.navlink name="calendar" label="Schedule Templates" url="{{route('admin.information.schedule-templates.index')}}"/>
                <x-navigation.navlink name="user-check" label="Teachers" url="{{route('admin.information.teachers.index')}}"/>
                <x-navigation.navlink name="book-content" label="Subjects" url="{{route('admin.information.subjects.index')}}"/>
            </x-navigation.nav-accordion>

            <x-navigation.nav-accordion label="Assignment Module" name="message-square-add">
                <x-navigation.navlink name="user-plus" label="Teachers" url="{{route('admin.assignments.teachers.index')}}"/>
            </x-navigation.nav-accordion>

            <x-navigation.nav-accordion label="Schedules" name="time-five">
                <x-navigation.navlink name="spreadsheet" label="Class Schedules" url="{{route('admin.schedules.classes.index')}}"/>
                <x-navigation.navlink name="notepad" label="Exams" url="{{route('admin.schedules.exams.index')}}"/>
                <x-navigation.navlink name="calendar-star" label="Events" url="{{route('admin.schedules.events.index')}}"/>
            </x-navigation.nav-accordion>

            <x-navigation.navlink name="file" label="Reports" url="{{route('admin.reports.index')}}"/>

            <x-navigation.nav-accordion label="User Management" name="user-circle">
                <x-navigation.navlink name="user-pin" label="Accounts" url="{{route('admin.user-management.accounts.index')}}"/>
                <x-navigation.navlink name="check-shield" label="Roles" url="{{route('admin.user-management.roles.index')}}"/>    
            </x-navigation.nav-accordion>
            
            <x-navigation.navlink name="cog" label="System Variables" url="{{route('admin.dashboard')}}"/>
        </div>
    </div>
</nav>

@vite('resources/js/navbar.js')