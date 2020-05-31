<template>
    <div class="accordion" id="accordionExample">
        <div class="d-flex flex-row" style="justify-content: center;">
            <div class="font-weight-lighter">
                <input type="hidden" v-bind:id="'bookId' + index" v-bind:value="bookinformation.id">

                <div>
                    <img class="search-book-imgSize" v-bind:src="bookinformation.volumeInfo.imageLinks.thumbnail | changehttps" />
                    <input type="hidden" v-bind:id="'imageLinks' + index" v-bind:value="bookinformation.volumeInfo.imageLinks.thumbnail | changehttps">
                    <button class="btn btn-link　btn-sm text-light" type="button" data-toggle="collapse" v-bind:data-target="'#collapse' + index"
                            aria-expanded="true" aria-controls="collapseOne">
                        詳細を見る
                    </button>
                    <button type="submit" class="btn btn-rounded btn-sm mt-3" :class="AddLibraryButtonColor" @click="AddLibrary(index)">{{ AddLibraryText }}</button>
                </div>

                <div v-bind:id="'collapse' + index" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="search-book-title text-light">
                        <div>{{ bookinformation.volumeInfo.title }}</div>
                        <input type="hidden" v-bind:id="'title' + index" v-bind:value="bookinformation.volumeInfo.title">
                    </div>

                    <div class="search-book-author text-light">
                        <div v-for="author in bookinformation.volumeInfo.authors">
                            <div>{{ author }}</div>
                            <input type="hidden" v-bind:id="'authors' + index" v-bind:value="bookinformation.volumeInfo.authors">
                        </div>
                    </div>

                    <div class="search-book-publisher text-light">
                        <div>{{ bookinformation.volumeInfo.publisher }}</div>
                        <input type="hidden" v-bind:id="'publisher' + index" v-bind:value="bookinformation.volumeInfo.publisher">
                    </div>

                    <div class="search-book-description text-light">
                        <div>{{ bookinformation.volumeInfo.description }}</div>
                        <input type="hidden" v-bind:id="'description' + index" v-bind:value="bookinformation.volumeInfo.description">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import { mapState } from 'vuex'
    import {UNAUTHORIZED} from "../util";

    export default {
        props: {
            bookinformation: Object,
            index: Number,
        },
        filters: {
          changehttps(val) {
                return val.replace('http', 'https')
          }
        },
        data() {
            return {
                isAddedBy: false,
                bookId: '',
                title: '',
                imageLinks: '',
                authors: [],
                publisher: '',
                description: '',
                loading: false,
            }
        },
        computed: {
            AddLibraryButtonColor() {
                return this.isAddedBy
                    ? 'bg-primary text-white button-event'
                    : 'bg-light text-dark'
            },
            AddLibraryText() {
                return this.isAddedBy
                    ? 'マイライブラリに追加済み'
                    : 'マイライブラリに追加'
            },
        },
        methods: {
            async AddLibrary(index) {

                this.bookId = document.getElementById('bookId' + index).value
                this.title = document.getElementById('title' + index).value
                this.imageLinks = document.getElementById('imageLinks' + index).value
                this.authors = document.getElementById('authors' + index).value
                this.publisher = document.getElementById('publisher' + index).value
                this.description = document.getElementById('description' + index).value

                const response = await axios.post('api/store',
                    {
                        bookId: this.bookId,
                        imageLinks: this.imageLinks,
                        title: this.title,
                        authors: this.authors,
                        publisher: this.publisher,
                        description: this.description });

                if (response.status === UNAUTHORIZED) {
                    this.$store.commit('message/setContent', {
                        content: 'ライブラリに追加するにはログインをしてください',
                        timeout: 8000
                    })
                    return false
                }

                this.isAddedBy = true
                this.$store.commit('message/setContent', {
                    content: 'ライブラリに追加されました',
                    timeout: 6000
                })

                this.$store.dispatch('book/fetchBooks', 1)

            },
        }

    }
</script>

<style scoped>

    .search-book-imgSize {
        max-height: 120px;
        width: 90px !important;
    }
    .search-book-title {
        margin-top: 15px;
        margin-bottom: 3px;
        font-size: 13px;
    }

    .search-book-publisher {
        margin-top: 3px;
        margin-bottom: 3px;
        font-size: 13px;
    }

    .search-book-author {
        font-size: 13px;
    }

    .search-book-description {
        font-size: 13px;
    }

    .button-event {
        pointer-events: none;
    }
</style>
