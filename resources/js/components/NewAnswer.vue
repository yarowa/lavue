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
                                <textarea class="form-control" required v-model="body" name="body" rows="7"></textarea>
                            </div>
                            <div class="form-group">
                                <button :disabled="isInvalid" type="submit" class="btn btn-lg btn-outline-primary">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "NewAnswer",
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
