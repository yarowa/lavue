<template>
    <div class="row mt-4" v-cloak v-if="count">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ title }}</h2>
                    </div>
                    <hr>
                    <Answer v-for="answer  in answers" :answer="answer" :key="answer.id"></Answer>
                    <div class="text-center mt-3" v-if="nextAnswer">
                        <button @click.prevent="fetch(nextAnswer)" class="btn btn-outline-secondary">Load more answers</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Answer from "./Answer";
    export default {
        name: "Answers",
        props: ['question'],
        data () {
            return {
                questionId: this.question.id,
                count: this.question.answers_count,
                answers: [],
                nextAnswer: null
            }
        },
        created() {
            this.fetch(`/questions/${this.questionId}/answers`)
        },
        methods: {
            fetch (url) {
                axios.get(url).then( ({data})=> {
                    this.answers.push(...data.data);
                    this.nextAnswer = data.next_page_url;
                })
            }
        },
        computed: {
            title () {
                return this.count + ' ' + (this.count > 1 ? 'Answers' : 'Answer');
            }
        },
        components: { Answer }
    }
</script>

<style scoped>

</style>
