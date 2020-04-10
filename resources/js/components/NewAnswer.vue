<template>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>Your answer</h2>
                        <hr>
                        <form @submit.prevent="create">
                            <div class="form-group">
                                <Editor :body="body" name="new-answer">
                                    <textarea class="form-control" required v-model="body" name="body" rows="7"></textarea>
                                </Editor>
                            </div>
                            <div class="form-group">
                                <button :disabled="isInvalid" type="submit" class="btn btn-lg btn-outline-primary">
                                    <spinner :small="true" v-if="$root.loading"></spinner>
                                    <span :min-width="59.22" v-else>Submit</span>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import Editor from "./Editor";
    export default {
        name: "NewAnswer",
        components: {Editor},
        props: ['questionId'],
        methods: {
            create () {
                axios.post(`/questions/${this.questionId}/answers`, { body: this.body})
                    .then(({data}) =>{
                        this.$toast.success(data.message, 'Success', {timeout: 3000});
                        this.body = '';
                        this.$emit('created', data.answer);
                    })
                    .catch(error => {
                        this.$toast.error(error.response.data.message, 'Error', {
                            timeout: 3000,
                            position: 'bottomLeft'
                        })
                    })
            }
        },
        data () {
            return {
                body: ''
            }
        },
        computed: {
            isInvalid () {
                return ! this.signedIn || this.body.length < 10;
            }
        }
    }
</script>

<style scoped>

</style>
