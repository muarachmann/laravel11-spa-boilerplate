<template>
    <div v-if="pagination && pagination.total !== 0" class="w-full mx-2 py-4 flex items-center justify-between mt-4">
        <div class="flex-1 flex justify-between sm:hidden">
            <button @click="previousPage()" type="button" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Previous
            </button>
            <button @click="nextPage()" type="button" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Next
            </button>
        </div>
        <div class="mx-2 hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    {{ ' ' }}
                    <span class="font-medium">{{ pagination.from }}</span>
                    {{ ' ' }}
                    to
                    {{ ' ' }}
                    <span class="font-medium">{{ pagination.to }}</span>
                    {{ ' ' }}
                    of
                    {{ ' ' }}
                    <span class="font-medium">{{ pagination.total }}</span>
                    {{ ' ' }}
                    results
                </p>
            </div>
            <div>
                <ul class="relative bg-white z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <li>
                        <button
                            :disabled="!links.prev"
                            @click="previousPage()"
                            type="button"
                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <icon name="arrow-narrow-left" class="h-5 w-5" aria-hidden="true" />
                        </button>
                    </li>
                    <template v-if="showNumbers">
                        <li v-for="(page, key) in pageRange" :key="key">
                            <button
                                @click="selectPage(page)"
                                type="button"
                                :class="{'bg-theme-1 text-white': page === pagination.current_page}"
                                class="z-10 relative inline-flex items-center px-4 py-2 border-y border-r text-sm font-medium">
                                {{ page }}
                                <span class="sr-only" v-if="page === pagination.current_page">(current)</span>
                            </button>
                        </li>
                    </template>
                    <li>
                        <button @click="nextPage()" :disabled="!links.next" type="button" class="relative inline-flex items-center px-2 py-2 rounded-r-md border-y border-r border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Next</span>
                            <icon name="arrow-narrow-right" class="h-5 w-5" aria-hidden="true" />
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "GlobalPagination",
    props: {
        pagination: Object,
        links: Object,
        limit: {
            type: Number,
            default: 0
        },
        showNumbers: {
            type: Boolean,
            default: true
        }
    },
    computed: {
        pageRange() {
            if (this.limit === 0) {
                return [1, this.pagination.last_page]
            }

            const current = this.pagination.current_page
            const last = this.pagination.last_page
            const delta = this.limit
            const left = current - delta
            const right = current + delta + 1
            const range = []
            const pages = []
            let l = null

            for (let i = 1; i <= last; i++) {
                if (i === 1 || i === last || (i >= left && i < right)) {
                    range.push(i);
                }
            }

            range.forEach((i) => {
                if (l) {
                    if (i - l === 2) {
                        pages.push(l + 1)
                    } else if (i - l !== 1) {
                        pages.push('...')
                    }
                }
                pages.push(i)
                l = i
            })

            return pages
        }
    },
    data() {
        return {

        }
    },
    methods: {
        previousPage() {
            this.selectPage(this.pagination.current_page - 1)
        },
        nextPage() {
            this.selectPage(this.pagination.current_page + 1)
        },
        selectPage(page) {
            if (page === '...') {
                return
            }
            this.$emit('page-changed', page)
        }
    }
}
</script>


<style scoped>

</style>
