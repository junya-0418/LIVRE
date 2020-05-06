<template>
    <div>
        <div><i class="fas fa-book-open mr-2"></i>本を探す</div>

        <div class="md-form" style="display: flex;">
            <input class="form-control" style="width: 250px; color: antiquewhite;" type="text" name="word" v-model="searchWord"　autocomplete="off" placeholder="キーワード検索">
            <button class="btn btn-outline-info btn-rounded waves-effect btn-sm" type="button" value="送信" @click="search" style="width: 80px;">検索</button>
        </div>

        <div style="text-align: center;">
            <div v-if="loading" class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>

            <div class="mt-3 search-books-card" v-for="(bookinformation, index) in booksInformations">
                <BookSearchChild
                    :bookinformation="bookinformation" :index="index">
                </BookSearchChild>
            </div>
        </div>
    </div>
</template>

<script>
    import BookSearchChild from './BookSearchChild.vue'

    export default {
        components: {
            BookSearchChild
        },
        data() {
            return {
                searchWord: '',
                booksInformations: [],
                loading: false
            }
        },
        methods: {
            async search() {
                this.booksInformations = []

                this.loading = true
                const response = await axios.post('api/search', {searchWord: this.searchWord})
                    .catch( error => { console.log(error); });

                this.booksInformations = response.data
                this.loading = false
            },
        }

    }
</script>
