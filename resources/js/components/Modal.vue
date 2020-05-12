<template>
    <div>
        <div id="overlay" @click="closeModal">
            <div id="content" @click="stopEvent">
                <button type="button" class="close text-light" aria-label="Close" @click="closeModal">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="modal-title pb-2 text-light">{{ title }}</div>
                <div v-for="item in items" class="modal-card" style="display: flex;">
                    <RouterLink :to="`/user/${item.id}`" class="text-light modal-item p-2">
                        {{ item.name }}
                    </RouterLink>
                    <follow-button class="ml-auto"
                                   :id="item.id">
                    </follow-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import FollowButton from "./FollowButton";

    export default {
        name: "Modal",
        props: {
            title: {
                type: String,
                required: true
            },
            items: {
                type: Array,
                required: true
            }
        },
        components: {
            FollowButton
        },
        methods: {
            closeModal() {
              this.$emit('close-modal')
            },
            stopEvent() {
                event.stopPropagation()
            }
        }
    }
</script>

<style scoped>
    #overlay{
        /*　要素を重ねた時の順番　*/
        z-index:2;

        /*　画面全体を覆う設定　*/
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background-color:rgba(110, 118, 125, 0.4);

        /*　画面の中央に要素を表示させる設定　*/
        display: flex;
        align-items: center;
        justify-content: center;

    }

    #content{
        z-index:3;
        width:50%;
        padding: 1em;
        background: black;
    }

    .modal-title {
        border-bottom: solid 1px #fff;
    }

    .modal-card {
        border-bottom: solid 1px #fff;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .modal-item:hover {
        cursor: pointer;
        text-decoration: underline;
    }
</style>
