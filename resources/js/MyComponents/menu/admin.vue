<script setup>
    import { onMounted } from 'vue';
    import { initFlowbite } from 'flowbite';

    import { AcademicCapIcon, EyeDropperIcon, UsersIcon } from '@heroicons/vue/24/solid';

    import NavLink from '../../Components/NavLink.vue';

    import CompaniesIcon from '../../Components/icons/CompaniesIcon.vue';
    import OfficeIcon from '../../Components/icons/OfficeIcon.vue';
    import BookIcon from '../../Components/icons/BookIcon.vue';
    import ChevronDownIcon from '../../Components/icons/ChevronDownIcon.vue';
    import BugAntIcon from '../../Components/icons/BugAntIcon.vue';

    onMounted(() => {
        initFlowbite();
    });
</script>

<template>
    <li>
        <button id="mega-menu-icons-dropdown-button" 
            data-dropdown-toggle="mega-menu-icons-dropdown"
            class="flex items-center justify-between 
                w-full py-2 pl-3 pr-4 
                font-medium 
                text-gray-900 
                border-b border-gray-100 
                md:w-auto 
                hover:bg-gray-50 
                md:hover:bg-transparent 
                md:border-0 md:p-0 
                md:hover:text-blue-600 
                dark:text-white 
                md:dark:hover:text-blue-500 
                dark:hover:bg-gray-700 
                dark:hover:text-blue-500 
                md:dark:hover:bg-transparent 
                dark:border-gray-700"
        >
            Admin
            <ChevronDownIcon />
        </button>
        <div id="mega-menu-icons-dropdown"
            class="absolute z-10 grid hidden w-auto 
                grid-cols-2 text-sm 
                bg-white border 
                border-gray-100 
                rounded-lg 
                shadow-md 
                dark:border-gray-700 
                md:grid-cols-3 
                dark:bg-gray-700">

            <!-- 1. oszlop -->
            <div class="p-4 pb-0 text-gray-900 md:pb-4 dark:text-white">
                <ul class="space-y-4" 
                    aria-labelledby="mega-menu-icons-dropdown-button">

                    <!-- BOOKS -->
                    <li>
                        <NavLink :href="route('books')" 
                            :active="route().current('books')">
                            <BookIcon class="w-4 h-4" />
                            <span>Books</span>
                        </NavLink>
                    </li>

                    <!-- BOOKS 2 -->
                    <li>
                        <NavLink :href="route('books2')" 
                            :active="route().current('books2')">
                            <BookIcon class="w-4 h-4" />
                            <span>Books2</span>
                        </NavLink>
                    </li>

                    <!-- ROLES -->
                    <li>
                        <NavLink :href="route('roles')" 
                            :active="route().current('roles')">
                            <BookIcon class="w-4 h-4" />
                            <span>Roles</span>
                        </NavLink>
                    </li>

                    <!-- CLIENTS -->
                    <li>
                        <NavLink :href="route('clients')" 
                            :active="route().current('clients')">
                            <BookIcon class="w-4 h-4" />
                            <span>Clients</span>
                        </NavLink>
                    </li>

                    <!-- CLIENTS GRID -->
                    <li>
                        <NavLink :href="route('clients_grid')" 
                            :active="route().current('clients_grid')">
                            <BookIcon class="w-4 h-4" />
                            <span>Client grids</span>
                        </NavLink>
                    </li>

                    <!-- COMPANIES -->
                    <li v-if="$page.props.policies.company_view">
                        <NavLink :href="route('companies')" 
                            :active="route().current('companies')">
                            <CompaniesIcon class="w-4 h-4" />
                            <span>Companies</span>
                        </NavLink>
                    </li>

                    <!-- OFFICES -->
                    <li>
                        <NavLink :href="route('offices')" 
                            :active="route().current('offices')">
                            <OfficeIcon class="w-4 h-4" />
                            <span>Offices</span>
                        </NavLink>
                    </li>

                    <!-- ADDRESSES -->
                    <li>
                        <NavLink :href="route('addresses')" 
                            :active="route().current('addresses')">
                            <AcademicCapIcon class="w-4 h-4 mr-2" />
                            <span>Addresses</span>
                        </NavLink>
                    </li>

                    <!-- HUMANS -->
                    <li>
                        <NavLink :href="route('humans')" 
                            :active="route().current('humans')">
                            <UsersIcon class="w-4 h-4 mr-2" />
                            <span>Humans</span>
                        </NavLink>
                    </li>
                </ul>
            </div>

            <!-- 2. oszlop -->
            <div class="p-4 pb-0 text-gray-900 md:pb-4 dark:text-white">
                <ul class="space-y-4">

                    <!-- ANIMALS -->
                    <li>
                        <NavLink :href="route('animals')" 
                            :active="route().current('animals')">
                            <BugAntIcon class="w-4 h-4 mr-2"/>
                            Animals
                        </NavLink>
                    </li>
                    
                    <!-- EXAMINATIONS -->
                    <li>
                        <NavLink :href="route('examinations')" 
                            :active="route().current('examinations')">
                            <BugAntIcon class="w-4 h-4 mr-2"/>
                            Kezelések
                        </NavLink>
                    </li>

                </ul>
            </div>
            
            <!-- 3. oszlop -->
            <!--<div class="p-4 text-gray-900 dark:text-white">
                <ul class="space-y-4">
                    <li>
                        <a href="#"
                            class="flex items-center text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500 group">
                            <span class="sr-only">Contact Us</span>
                            <svg class="w-4 h-4 mr-2 text-gray-400 dark:text-gray-500 group-hover:text-blue-600 dark:group-hover:text-blue-500"
                                aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                </path>
                            </svg>
                            Contact Us
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500 group">
                            <span class="sr-only">Support Center</span>
                            <svg class="w-4 h-4 mr-2 text-gray-400 dark:text-gray-500 group-hover:text-blue-600 dark:group-hover:text-blue-500"
                                aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C15.802 8.249 16 9.1 16 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-2.516-.552l1.562-1.562a4.006 4.006 0 001.789.027zm-4.677-2.796a4.002 4.002 0 01-.041-2.08l-.08.08-1.53-1.533A5.98 5.98 0 004 10c0 .954.223 1.856.619 2.657l1.54-1.54zm1.088-6.45A5.974 5.974 0 0110 4c.954 0 1.856.223 2.657.619l-1.54 1.54a4.002 4.002 0 00-2.346.033L7.246 4.668zM12 10a2 2 0 11-4 0 2 2 0 014 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Support Center
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500 group">
                            <span class="sr-only">Terms</span>
                            <svg class="w-4 h-4 mr-2 text-gray-400 dark:text-gray-500 group-hover:text-blue-600 dark:group-hover:text-blue-500"
                                aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd"
                                    d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Terms
                        </a>
                    </li>
                </ul>
            </div>-->
        </div>
    </li>
</template>