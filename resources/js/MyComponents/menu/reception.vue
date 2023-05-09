<script setup>
    import {ref, onMounted} from 'vue';
    import {initFlowbite} from 'flowbite';
    import NavLink from '../../Components/NavLink.vue';

    import UserPlusIcon from '../../Components/icons/UserPlusIcon.vue';
    import ChevronDownIcon from '../../Components/icons/ChevronDownIcon.vue';

    onMounted(() => {
        initFlowbite()
    });

    //const showingNavigationDropdown = ref(false)

</script>

<template>
    <li>

        <button id="mega-menu-reception-dropdown-button"
            data-dropdown-toggle="reception-menu-dropdown"
            class="flex items-center 
                justify-between 
                w-full py-2 pl-3 pr-4 
                font-medium 
                text-gray-900 
                border-b border-gray-100 
                md:w-auto 
                hover:bg-gray-50 
                md:hover:bg-transparent 
                md:border-0 
                md:hover:text-blue-600 
                md:p-0 dark:text-white 
                md:dark:hover:text-blue-500 
                dark:hover:bg-gray-700 
                dark:hover:text-blue-500 
                md:dark:hover:bg-transparent 
                dark:border-gray-700"
        >
            Recepció
            <ChevronDownIcon class="w-5 h-5" />
        </button>

        <div id="reception-menu-dropdown" 
            class="absolute 
                z-10 grid hidden w-auto 
                grid-cols-2 
                text-sm 
                bg-white 
                border border-gray-100 
                rounded-lg 
                shadow-md 
                dark:border-gray-700 
                md:grid-cols-3 
                dark:bg-gray-700"
        >
            <!-- 1. oszlop -->
            <div class="p-4 pb-0 text-gray-900 md:pb-4 dark:text-white">
                <ul class="space-y-4" 
                    aria-labelledby="mega-menu-reception-dropdown-button">

                    <!-- 1. oszlop 1. menu -->
                    <li>
                        <!--<a href="#"><span>Felvétel</span></a>-->
                        <NavLink :href="route('patients')" 
                            :active="route().current('patients')">
                            <UserPlusIcon class="w-5 h-5" />&nbsp;
                            <span>Betegek</span>
                        </NavLink>
                    </li>
                </ul>
            </div>
            <!-- ./1. oszlop -->

        </div>
    </li>
</template>