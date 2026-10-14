<x-app-layout>

    <div class="py-6 sm:py-8 bg-pink-50/30 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- ====================================== --}}
            {{-- 1. PAGE HEADER --}}
            {{-- ====================================== --}}

            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-pink-600 via-rose-600 to-pink-700 p-6 sm:p-8 text-white shadow-lg">

                <!-- Decorative Background Blobs -->
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-xl pointer-events-none" aria-hidden="true"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-pink-400/20 rounded-full blur-xl pointer-events-none" aria-hidden="true"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div class="space-y-2">

                        <div class="flex items-center space-x-2 text-pink-100 text-xs sm:text-sm font-medium tracking-wide uppercase">
                            <svg
                                class="w-4 h-4 text-pink-200"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true"
                            >
                                <path d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L10.582 17.13a4.5 4.5 0 0 1-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"/>
                                <path d="M19.5 7.125 16.875 4.5"/>
                            </svg>
                            <span>Healthcare Workforce</span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">
                            Edit Midwife
                        </h1>

                        <p class="text-sm sm:text-base text-pink-100/90 max-w-xl">
                            Update the midwife's profile and account information.
                        </p>

                    </div>

                    <div class="inline-flex items-center space-x-2 bg-white/15 backdrop-blur-md border border-white/20 px-3.5 py-1.5 rounded-full text-xs sm:text-sm font-medium text-white self-start md:self-auto">
                        <svg
                            class="w-4 h-4"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z"/>
                            <path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-1.42 1.42-.06-.06a1.7 1.7 0 0 0-1.88-.34 1.7 1.7 0 0 0-1.03 1.56V20H13.4v-.48a1.7 1.7 0 0 0-1.03-1.56 1.7 1.7 0 0 0-1.88.34l-.06.06-1.42-1.42.06-.06A1.7 1.7 0 0 0 9.41 15a1.7 1.7 0 0 0-1.56-1.03H7.36V11.9h.49A1.7 1.7 0 0 0 9.41 10a1.7 1.7 0 0 0-.34-1.88l-.06-.06 1.42-1.42.06.06a1.7 1.7 0 0 0 1.88.34 1.7 1.7 0 0 0 1.03-1.56V5h2.01v.48A1.7 1.7 0 0 0 16.44 7a1.7 1.7 0 0 0 1.88-.34l.06-.06 1.42 1.42-.06.06A1.7 1.7 0 0 0 19.4 10a1.7 1.7 0 0 0 1.56 1.03h.49v2.01h-.49A1.7 1.7 0 0 0 19.4 15Z"/>
                        </svg>
                        <span>Account Management</span>
                    </div>

                </div>
            </div>


            {{-- ====================================== --}}
            {{-- 2. MAIN FORM CARD --}}
            {{-- ====================================== --}}

            <div class="bg-white rounded-2xl shadow-sm border border-pink-100 overflow-hidden">

                <div class="border-b border-gray-100 bg-gray-50/50 p-5 sm:p-6">

                    <div class="flex items-center space-x-3">

                        <div class="p-2.5 bg-pink-100 text-pink-700 rounded-xl">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L10.582 17.13a4.5 4.5 0 0 1-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19.5 7.125 16.875 4.5"
                                />
                            </svg>
                        </div>

                        <div class="min-w-0">

                            <h2 class="text-lg font-semibold text-gray-900">
                                Midwife Information
                            </h2>

                            <p class="text-xs sm:text-sm text-gray-500">
                                Review and update the registered midwife's account information.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="p-6 sm:p-8">

                    <form action="{{ route('midwives.update', $midwife->id) }}" method="POST">

                        @csrf
                        @method('PUT')

                        @include('admin.midwives._form')


                        {{-- ====================================== --}}
                        {{-- 3. ACTION BUTTONS --}}
                        {{-- ====================================== --}}

                        <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end">

                            <div class="flex items-center space-x-3">

                                <a
                                    href="{{ route('midwives.index') }}"
                                    class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 text-gray-500"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.75 19.5 8.25 12l7.5-7.5"
                                        />
                                    </svg>
                                    <span>Cancel</span>
                                </a>


                                <button
                                    type="submit"
                                    class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors shadow-sm"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L8.25 19.463 3.75 20.25l.787-4.5L16.862 4.487Z"
                                        />
                                    </svg>

                                    <span>Update Midwife</span>
                                </button>

                            </div>
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>