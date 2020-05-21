<template>
    <div style="text-align: center;">
        <div class="message-main">
            <div class="message text-light" v-show="message">
                {{ message }}
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        computed: {
            ...mapState({
                message: state => state.message.content
            })
        }
    }
</script>

<style scoped>

    @media (min-width: 980px) {
        .message-main {
            background-color: black;
            display: inline-flex;
            margin-top: 50px;
        }

        .message {
            width: 300px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 20px;
            padding-right: 20px;
            background-color: #0C9A9A;
        }
    }

    @media (max-width: 479px) {
        .message-main {
            background-color: black;
            display: inline-flex;
        }

        .message {
            width: 300px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 20px;
            padding-right: 20px;
            background-color: #0C9A9A;
        }
    }
</style>
