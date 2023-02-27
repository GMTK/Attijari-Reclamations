<script setup>
import PerfectScrollbar from '@/Components/PerfectScrollbar.vue'
import SidebarLink from '@/Components/Sidebar/SidebarLink.vue'
import { DashboardIcon } from '@/Components/Icons/outline'
import SidebarCollapsible from '@/Components/Sidebar/SidebarCollapsible.vue'
import SidebarCollapsibleItem from '@/Components/Sidebar/SidebarCollapsibleItem.vue'
import {LogoutIcon, UserIcon, DatabaseIcon, ExclamationCircleIcon, DownloadIcon, HandIcon} from '@heroicons/vue/outline'
</script>



<template>
    <PerfectScrollbar
        tagname="nav"
        aria-label="main"
        class="relative flex flex-col flex-1 max-h-full gap-4 px-3"
    >
        <SidebarLink
            title="Dashboard"
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            <template #icon>
                <DashboardIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>
        </SidebarLink>

        <SidebarLink
            title="Saisie"
            :href="route('saisir')"
            :active="route().current('saisir')"
        >
            <template #icon>
                <DownloadIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>
        </SidebarLink>

        <SidebarCollapsible
            title="Gestion"
            :active="route().current('gestion.*')"
        >
            <template #icon>
                <DatabaseIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>

            <SidebarCollapsibleItem
                :href="route('gestion.users')"
                title="Utilisateurs"
                :active="route().current('gestion.users')"
            />

            <SidebarCollapsibleItem
                :href="route('gestion.roles')"
                title="Roles"
                :active="route().current('gestion.roles')"
            />

            <SidebarCollapsibleItem
                :href="route('gestion.permissions')"
                title="Habilitations"
                :active="route().current('gestion.permissions')"
            />
        </SidebarCollapsible>

        <SidebarCollapsible
            title="Reclamations"
            :active="route().current('reclamations.*')"
        >
            <template #icon>
                <ExclamationCircleIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>

            <SidebarCollapsibleItem
                :href="route('reclamations.tout')"
                title="Tout"
                :active="route().current('reclamations.tout')"
            />

            <SidebarCollapsibleItem
                :href="route('reclamations.nontraite')"
                title="Non Traitée"
                :active="route().current('reclamations.nontraite')"
            />

            <SidebarCollapsibleItem
                :href="route('reclamations.encours')"
                title="En Cours Traitement"
                :active="route().current('reclamations.encours')"
            />

            <SidebarCollapsibleItem
                :href="route('reclamations.fini')"
                title="traitement fini"
                :active="route().current('reclamations.fini')"
            />

            <SidebarCollapsibleItem
                :href="route('reclamations.cloture')"
                title="Cloturée"
                :active="route().current('reclamations.cloture')"
            />

            <SidebarCollapsibleItem
                :href="route('reclamations.nontraiteretard')"
                title="Non Traitée Retard"
                :active="route().current('reclamations.nontraiteretard')"
            />

        </SidebarCollapsible>

        <SidebarLink
            title="Profile"
            :href="route('profile.edit')"
            :active="route().current('profile.edit')"
        >
            <template #icon>
                <UserIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>
        </SidebarLink>

        <SidebarLink
            title="Logout"
            :href="route('logout')"
            method="post"

        >
            <template #icon>
                <LogoutIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>
        </SidebarLink>

    </PerfectScrollbar>
</template>
