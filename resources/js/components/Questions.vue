<template>
    <div class="card-body">
        <div v-if="questions.length">
            <question-excerpt @deleted="remove(index)" v-for="(question, index) in questions" :question="question" :key="question.id"></question-excerpt>
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
    import QuestionExcerpt from "./QuestionExcerpt";
    import Pagination from "./Pagination";

    export default {
        name: "QuestionsPage",
        components: { QuestionExcerpt, Pagination },
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
