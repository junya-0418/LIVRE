<template>
    <div class="pagination" style="justify-content: center;">
        <RouterLink
            v-if="!isFirstPage"
            :to="`${uri}?page=${currentPage - 1}`"
            class="page-link text-dark"
        >&laquo; prev</RouterLink>
        <RouterLink
            v-if="!isLastPage"
            :to="`${uri}?page=${currentPage + 1}`"
            class="page-link text-dark"
        >next &raquo;</RouterLink>
    </div>
</template>

<script>
    export default {
        props: {
            currentPage: {
                type: Number,
                required: true
            },
            lastPage: {
                type: Number,
                required: true
            },
            uri: {
                type: String,
                required: true,
                default: '/'
            }
        },
        computed: {
            isFirstPage () {
                return this.currentPage === 1
            },
            isLastPage () {
                return this.currentPage === this.lastPage
            }
        }
    }
</script>
