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
            <div style="display: flex;">
                <h3 class="h4 newbooks-book-title text-light">
                    <span>{{ book.title  }}</span>
                </h3>
                <div v-if="userId === book.owner.id" style="margin:0 0 0 auto;">
                    <a class="nav-link dropdown-toggle text-light p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                    <div class="dropdown-menu p-0" style="border: solid 1px #ccc">
                        <a class="nav-link text-danger bg-dark" data-toggle="modal" :data-target='`#modal-delete-${book.id}`'>
                            削除する
                        </a>
                        <div v-if="book.comment">
                            <a href="javascript:void(0);"  class="nav-link text-light bg-dark" data-toggle="modal" :data-target='`#modal-comment-${book.id}`'>
                                コメントを編集する
                            </a>
                        </div>
                        <div v-else>
                            <a href="javascript:void(0);"  class="nav-link text-light bg-dark" data-toggle="modal" :data-target='`#modal-comment-${book.id}`'>
                                コメントする
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- deleteModal -->
            <div class="modal fade" :id='`modal-delete-${book.id}`' tabindex="-1" role="dialog" style="text-align: center; top: 100px !important;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            この本をマイライブラリから削除しますか？
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">キャンセル</button>
                            <button type="button" class="btn btn-danger" @click="deleteBook(book.id)">削除</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- commentModal -->
            <div class="modal fade" :id='`modal-comment-${book.id}`' tabindex="-1" role="dialog" style="text-align: center; top: 100px !important;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>推薦コメント</div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div v-if="commentErrors" class="errors card-text text-left alert alert-danger">
                                <ul v-if="commentErrors.content">
                                    <li v-for="msg in commentErrors.content" :key="msg">{{ msg }}</li>
                                </ul>
                            </div>
                            <div class="basic-textarea rounded-corners">
                                <textarea v-model="commentContent" class="form-control z-depth-1" id="exampleFormControlTextarea345" rows="3" placeholder="Write your comment..." style="height: 150px !important;"> {{ commentContent }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">キャンセル</button>
                            <button type="button" class="btn btn-info" @click="addComment()">投稿する</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="newbooks-book-author text-light mr-2" style="margin-bottom: 10px;">
                <div>{{ book.author1 || '' }}</div>
            </div>
            <div class="newbooks-book-publisher text-light mr-2" style="margin-bottom: 10px;">
                <div>{{ book.publisher || '' }}</div>

            </div>
            <div class="book-detail-description text-light">
                <span>{{ book.description  }}</span>
            </div>

            <div v-if="book.comment" class="text-light mt-2" style="font-size: 14px;">
                <div style="opacity: 0.6;">ユーザーコメント</div>
                <div class="p-2" style="border: solid 1px #ccc; border-radius: 5px;">
                    {{ book.comment.content }}
                </div>
            </div>

            <WantButton :id="id"></WantButton>
        </div>
    </div>
</div>
</template>

<script>
    import WantButton from "./WantButton";
    import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'

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
                book: [],
                commentContent: '',
                commentErrors: null,
                comment: ''
            }
        },
        computed: {
          userId() {
              return this.$store.getters['auth/userId']
          }
        },
        methods: {
            async fetchBook () {
                const response = await axios.get(`/api/books/${this.id}`)
                this.book = response.data
                if (this.book.comment) {
                    this.commentContent = this.book.comment.content
                } else {
                    this.commentContent = ''
                }
            },
            async deleteBook(id) {

                const response = await axios.delete(`/api/delete/${id}`)

                $('.modal-backdrop').remove();
                this.$router.push(`/user/${response.data}`)
            },
            async addComment() {

                const response = await axios.post(`/api/book/${this.id}/comment`, {content: this.commentContent})

                // バリデーションエラー
                if (response.status === UNPROCESSABLE_ENTITY) {
                    this.commentErrors = response.data.errors
                    return false
                }

                $('.modal-backdrop').remove();
                $(`#modal-comment-${this.id}`).modal('hide');

                // エラーメッセージをクリア
                this.commentErrors = null

                this.book.comment = response.data
            }
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
