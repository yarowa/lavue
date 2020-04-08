<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-item-center">
                            <h2>Ask Questions</h2>
                            <div class="ml-auto">
                                <router-link :to="{name: 'questions'}" class="btn btn-outline-secondary">Back to Questions</router-link>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <!--Question form -->
                        <question-form @Submitted="create"></question-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import QuestionForm from "../QuestionForm";
    import EventBus from "../../event-bus";
    export default {
        name: "CreateQuestionPage",
        components: {QuestionForm},

        methods: {
            create (data){
                axios.post('/questions', data)
                    .then(({data}) =>{
                        this.$router.push({name: 'questions'})
                        this.$toast.success(data.message, 'Success', {timeout: 3000})
                    })
                    .catch(({response}) => {
                        EventBus.$emit('error', response.data.errors)
                    })
            }
        },
    }
</script>

<style scoped>

</style>
