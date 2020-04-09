<template>
    <div class="container" v-if="question.id">
        <question :question="question"></question>
        <answers :question="question"></answers>
    </div>
</template>

<script>

    import Question from "../Question";
    import Answers from "../Answers";
    export default {
        components: {Answers, Question},
        props: ['slug'],
        data () {
            return {
                question: {}
            }
        },
        mounted () {
            this.fetchQuestion();
        },
        methods: {
            fetchQuestion () {
                axios.get(`/questions/${this.slug}`)
                    .then(({ data }) => {
                        this.question = data.data
                    })
                    .catch(error => console.log(error))
            }
        }
    }
</script>
