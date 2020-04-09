<template>
    <form @submit.prevent="handleSubmit">
        <div class="form-group">
            <label for="question-title">Question title</label>
            <input type="text" v-model="title" id="question-title" :class="errorClass('title')">

            <div v-if="errors['title'][0]" class="invalid-feedback">
                <strong>{{ errors['title'][0] }}</strong>
            </div>

        </div>
        <div class="form-group">
            <label for="question-body">You Question</label>
            <Editor :body="body" name="question-body">
                <textarea v-model="body" id="question-body" :class="errorClass('body')" rows="10"></textarea>
                <div v-if="errors['body'][0]" class="invalid-feedback">
                    <strong>{{ errors['body'][0] }}</strong>
                </div>
            </Editor>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-outline-primary btn-lg">{{ buttonText }}</button>
        </div>
    </form>
</template>

<script>
    import EventBus from "../event-bus";
    import Editor from "./Editor";

    export default {
        name: "QuestionForm",
        components: {Editor},
        props: {
            isEdit: {
                type: Boolean,
                default: false
            }
        },

        data () {
            return {
                title: '',
                body: '',
                errors: {
                    title: [],
                    body: []
                }
            }
        },
        mounted() {
            EventBus.$on('error', errors => this.errors = errors);
            if (this.isEdit) {
                this.fetchQuestion();
            }
        },
        computed: {
          buttonText () {
              return this.isEdit ? 'Update Question' : 'Ask Question'

          }
        },
        methods: {
            fetchQuestion () {
                axios.get(`/questions/${this.$route.params.id}`)
                    .then(({ data }) => {
                        this.title = data.title;
                        this.body = data.body;
                    })
                    .catch(error => {
                        console.log(error.response);
                    })
            },
            handleSubmit () {
                this.$emit('submitted', {
                    title: this.title,
                    body: this.body
                })
            },
            errorClass (column) {
                return [
                    'form-control',
                    this.errors[column][0] ? 'is-invalid': '',
                ]
            },
        },

    }
</script>

<style scoped>

</style>
