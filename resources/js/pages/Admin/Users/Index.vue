<template>
    <div class="px-4 flex flex-col">
        <h1 class="font-bold text-xl inline-flex items-center">
            {{ $tc('menu.user', 2) }}
        </h1>
        <Breadcrumb :page-routes="pagesRoutes" :active-link="activeLink"/>
        <div class="grid grid-cols-12 gap-2 md:gap-4 my-5">
            Users content
        </div>
    </div>
</template>

<script>
import AdminDashboardLayout from "../../../layouts/AdminDashboardLayout.vue"
import i18n from "../../../i18n"

export default {
    name: "AdminUserIndex",
    layout: AdminDashboardLayout,
    metaInfo: {
        title: i18n.tc('menu.user', 1)
    },
    data() {
        return {
            pagesRoutes: [
                {
                    title : i18n.t('menu.dashboard'),
                    link : this.route('admin.dashboard')
                },
            ],
            activeLink: i18n.tc('menu.user', 1),
        }
    },
}
</script>

<style scoped>

</style>
