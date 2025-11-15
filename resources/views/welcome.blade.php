<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-custom">
    <!-- Navigation -->
    <nav class="bg-custom flex justify-between py-6 w-full lg:px-48 md:px-12 px-4 content-center bg-secondary border">
        <div class="flex items-center">
            {{-- <img src="{{ asset('img/Underline1.svg') }}" alt="Mi Imagen" class="h-4"> --}}
            <span class="italic font-semibold bg-left-bottom bg-no-repeat pb-4 bg-100%"
                style="background-image: url('{{ asset('img/Underline1.svg') }}');">
                DaImperium
            </span>

        </div>

        @if (Route::has('login'))
            <div class="sm:right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="font-semibold text-white bg-stone-800 hover:bg-stone-600 focus:outline-none focus:ring focus:ring-gray-400 focus:ring-opacity-50 rounded-md px-4 py-2 transition duration-300 ease-in-out">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="font-semibold text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:ring focus:ring-gray-400 focus:ring-opacity-50 rounded-md px-4 py-2 transition duration-300 ease-in-out">Login</a>

                    @if (Route::has('register'))
                        {{-- <a href="{{ route('register') }}" class="font-semibold text-white bg-stone-800 hover:bg-stone-600 focus:outline-none focus:ring focus:ring-gray-400 focus:ring-opacity-50 rounded-md px-4 py-2 transition duration-300 ease-in-out">Register</a> --}}

                        <a href="#"
                            class="font-semibold text-white bg-stone-800 hover:bg-stone-600 focus:outline-none focus:ring focus:ring-gray-400 focus:ring-opacity-50 rounded-md px-4 py-2 transition duration-300 ease-in-out">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>

    <section
        class="md:mt-0 md:h-screen flex flex-col md:flex-row md:justify-between md:items-center lg:px-24 md:px-6 p-4 text-center md:text-left">
        <div class="md:flex-1 md:mr-10">
            <h1 class="italic font-semibold text-5xl mb-7">
                Project
                <span class="italic font-semibold bg-left-bottom bg-no-repeat pb-4 bg-100%"
                    style="background-image: url('{{ asset('img/Underline1.svg') }}');">
                    Management
                </span>
            </h1>

            <p class="text-justify p-2">
                Efficient Industrial Project Management Software
                Our software streamlines industrial project management, simplifying every phase from planning to
                execution.
                Designed for various sectors, we offer tools for detailed planning, resource allocation, budget
                management, and real-time tracking.
            </p>

            <p class="text-justify p-2">
                Ensure projects meet deadlines and budgets with our platform. Maximize efficiency, minimize costs, and
                take your company to the next level.
            </p>
        </div>

        <div class="flex justify-around md:block mt-8 md:mt-0 md:flex-1">
            <img class="rounded shadow-xl object-contain" src="{{ asset('img/project_management.png') }}"
                alt="Project Management" />
        </div>
    </section>

    <!-- How it works -->
    <section class="bg-black text-white sectionSize py-4">
        <div class="text-center pt-2 pb-8">
            {{-- <h2 class="text-2xl font-extrabold italic bg-left-bottom bg-no-repeat pb-4 bg-100%" style="background-image: url('{{ asset('img/Underline2.svg') }}');">How it works</h2> --}}
            <span class="text-2xl italic font-extrabold bg-left-bottom bg-no-repeat pb-8 bg-100%"
                style="background-image: url('{{ asset('img/Underline2.svg') }}');">
                How it Works
            </span>
        </div>
        <div class="flex flex-col md:flex-row">
            <div class="flex-1 mx-8 flex flex-col items-center my-4">
                <div
                    class="bg-white border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
                    1
                </div>
                <h3 class="font-montserrat font-medium text-xl mb-2">Create</h3>
                <p class="text-center font-montserrat">
                    Begin by creating a project in our software. Input project details, objectives, and scope. Define
                    the timeline and allocate necessary resources
                </p>
            </div>
            <div class="flex-1 mx-8 flex flex-col items-center my-4">
                <div
                    class="bg-white border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
                    2
                </div>
                <h3 class="font-montserrat font-medium text-xl mb-2">Update</h3>
                <p class="text-center font-montserrat">
                    Continuously update and monitor your project's progress. Easily make changes, update schedules, and
                    adapt to any evolving requirements.
                </p>
            </div>
            <div class="flex-1 mx-8 flex flex-col items-center my-4">
                <div
                    class="bg-white border-2 rounded-full bg-secondary text-black h-12 w-12 flex justify-center items-center mb-3">
                    3
                </div>
                <h3 class="font-montserrat font-medium text-xl mb-2">Schedule</h3>
                <p class="text-center font-montserrat">
                    Effectively schedule tasks, deadlines, and milestones within our platform. Keep your project on
                    track with automated reminders and real-time updates
                </p>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="sectionSize bg-secondary">
        <div>
            <div class="text-center pt-2 pb-8">
                {{-- <h2 class="text-2xl font-extrabold italic bg-left-bottom bg-no-repeat pb-4 bg-100%" style="background-image: url('{{ asset('img/Underline2.svg') }}');">How it works</h2> --}}
                <span class="text-2xl italic font-extrabold bg-left-bottom bg-no-repeat pb-10 bg-100%"
                    style="background-image: url('{{ asset('img/Underline3.svg') }}');">
                    Software Features Description
                </span>
            </div>

            <div class="md:grid md:grid-cols-2 md:grid-rows-2">

                <div class="flex items-start font-montserrat my-6 mr-10">
                    <img src='dist/assets/logos/Heart.svg' alt='' class="h-7 mr-4" />
                    <div>
                        <h3 class="font-semibold text-2xl">Precise Planning and Tracking #1</h3>
                        <p class="text-justify py-2">
                            An effective project management software should offer detailed planning capabilities with
                            scheduling and task assignment tools.
                            Furthermore, it should enable real-time tracking of project progress through Gantt charts
                            and dashboards.
                            This ensures that teams can quickly adjust their activities to meet deadlines and
                            objectives.
                        </p>
                    </div>
                </div>

                <div class="flex items-start font-montserrat my-6 mr-10">
                    <img src='dist/assets/logos/Heart.svg' alt='' class="h-7 mr-4" />
                    <div>
                        <h3 class="font-semibold text-2xl">Integrated Collaboration and Communication #2</h3>
                        <p class="text-justify py-2">
                            Effective communication is crucial in project management.
                            The software should facilitate collaboration among team members through chats, online
                            comments, and document sharing.
                            Integration with email and video conferencing tools is also essential to keep all
                            stakeholders informed and connected.
                        </p>
                    </div>
                </div>

                <div class="flex items-start font-montserrat my-6 mr-10">
                    <img src='dist/assets/logos/Heart.svg' alt='' class="h-7 mr-4" />
                    <div>
                        <h3 class="font-semibold text-2xl">Resource and Cost Management #3</h3>
                        <p class="text-justify py-2">
                            To ensure proper resource allocation and cost control, project management software should
                            provide features to manage budget, time, and human resources.
                            This includes tracking working hours, expense management, and efficient resource scheduling
                            to avoid overloads and delays.
                        </p>
                    </div>
                </div>

                <div class="flex items-start font-montserrat my-6 mr-10">
                    <img src='dist/assets/logos/Heart.svg' alt='' class="h-7 mr-4" />
                    <div>
                        <h3 class="font-semibold text-2xl">Reporting and Analysis Generation #4</h3>
                        <p class="text-justify py-2">
                            Customizable reports and analytical capabilities are essential for assessing project
                            performance and making informed decisions.
                            Good software should provide clear data visualizations, status reports, and trend analysis
                            so that managers can identify areas for improvement and take corrective actions in a timely
                            manner.
                            These features help optimize the decision-making process in project management.
                        </p>
                    </div>
                </div>

            </div>
    </section>

    <!-- Footer -->
    <section class="bg-black sectionSize">
        <div class="text-white text-sm text-center py-4 font-extrabold italic">
            <a href="https://danilo-tech.com" target="_blank"
                class="text-white underline hover:opacity-75 transition duration-300">
                &copy; <?php echo date('Y'); ?> Danilo tech. All rights reserved
            </a>
        </div>
    </section>
</body>

</html>
