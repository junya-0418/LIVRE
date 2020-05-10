<template>
<div>
<!--    <RouterLink to="">-->
<!--        <div><i class="fa fa-arrow-left" style="margin-top: 30px; margin-left: 50px; color: #ccc;"></i></div>-->
<!--    </RouterLink>-->
    <div class="book-detail-main">
        <div>
            <img class="card-img book-detail-img_size" :src="book.imageLinks" />
            <RouterLink class="book-detail-username" :to="`/user/${book.owner.id}`">
                <div class="text-light" style="font-size: 14px; margin-top: 20px;">{{ book.owner.name }}</div>
            </RouterLink>
        </div>

        <div style="width: 400px;">
            <h3 class="h4 newbooks-book-title text-light">
                <span>{{ book.title  }}</span>
            </h3>
            <div class="newbooks-book-author text-light mr-2" style="margin-bottom: 10px;">
                <div>{{ book.author1 || '' }}</div>
            </div>
            <div class="newbooks-book-publisher text-light mr-2" style="margin-bottom: 10px;">
                <div>{{ book.publisher || '' }}</div>

            </div>
            <div class="book-detail-description text-light">
                <span>{{ book.description  }}</span>
            </div>

            <WantButton :id="id"></WantButton>
        </div>
    </div>
</div>
</template>

<script>
    import WantButton from "./WantButton";

    export default {
        props: {
            id: {
                type: String,
                required: true,
            }
        },
        components: {
            WantButton
        },
        data() {
            return {
                book: []
            }
        },
        methods: {
            async fetchBook () {
                const response = await axios.get(`/api/books/${this.id}`)
                this.book = response.data
            },
        },
        watch: {
            $route: {
                async handler () {
                    await this.fetchBook()
                },
                immediate: true
            }
        }

    }
</script>

<style>
    .book-detail-main {
        display: flex;
        width: 600px;
        margin-left: auto;
        margin-right: auto;
        padding-top: 100px;
        justify-content: center;
    }

    .book-detail-description {
        font-size: 14px;
        display: contents;
    }

    .book-detail-img_size {
        max-height: 144px;
        width: 90% !important;
        padding-right: 70px;
    }

    .book-detail-username:hover {
        text-decoration: underline;
    }

</style>
