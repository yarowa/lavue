<template>
    <div class="container">
        <Question :question="question"></Question>
        <Answers :question="question"></Answers>
    </div>
</template>

<script>
    import Answers from "../Answers";
    import Question from '../Question'

    export default {
        name: "QuestionPage",

        props: ['question'],

        components: {
            Question,
            Answers
        }
    }
</script>

<style scoped>

</style>
