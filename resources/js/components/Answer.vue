<template>

</template>

<script>
    export default {
        props: ['answer'],

        data () {
            return {
                editing: false,
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                beforeEdit: null
            }
        },
        methods: {
            edit () {
                this.beforeEdit = this.body
                this.editing = true
            },
            cancel (){
                this.body = this.beforeEdit
                this.editing = false
            },
            update () {
                axios.patch(`/questions/${this.questionId}/answers/${this.id}`, {
                    body: this.body
                }).then(response => {
                     //console.log(response);
                    this.editing = false;
                    this.bodyHtml = response.data.body_html
                    alert(response.data.message)
                }).catch(error => {
                    // console.log("Ooops something went wrong");
                    alert(error.response.data.message)
                })
            }
        },
        computed: {
            isInvalid () {
                return this.body.length < 10
            }
        }
    }
</script>

<style scoped>

</style>
