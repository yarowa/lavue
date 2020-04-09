<template>
    <div class="card-body">
        <div v-if="questions.length">
            <question-excerpt v-for="question in questions" :question="question" :key="question.id"></question-excerpt>
        </div>
        <div v-else class="alert alert-warning">
            <strong>Sorry</strong> There are no questions available
        </div>
        <!--pagination-->
        <div class="card-footer">
            <pagination :meta="meta" :links="links"></pagination>
        </div>
    </div>
</template>

<script>

    import Pagination from "./Pagination";
    import QuestionExcerpt from "./QuestionExcerpt";

    export default {
        name: "QuestionsPage",
        components: {Pagination, QuestionExcerpt },
        data () {
            return {
                questions: [],
                meta: {},
                links: {}
            }
        },

        mounted() {
            this.fetchQuestions();
        },
        methods: {
            fetchQuestions () {
                axios.get('/questions', { params: this.$route.query })
                    .then(({data}) =>{
                        this.questions = data.data;
                        this.links = data.links;
                        this.meta = data.meta;
                    })
            },
            remove (index) {
                this.questions.splice(index, 1)
                this.count--
            },
        },

        watch: {
            "$route": 'fetchQuestions'
        }
    }
</script>

<style scoped>

</style>
