<template>
    <div class="media post">
        <Vote :model="answer" name="answer"></Vote>

        <div class="media-body">
            <form v-show="authorize('modify', answer) && editing" @submit.prevent="update">
                <div class="form-group">
                    <Editor :body="body" :name="uniqueName">
                        <textarea rows="10" v-model="body" class="form-control" required></textarea>
                    </Editor>
                </div>
                <button class="btn btn-primary" :disabled="isInvalid">Update</button>
                <button class="btn btn-outline-secondary" @click="cancel" type="button">Cancel</button>
            </form>
            <div v-show="!editing">
                <div :id="uniqueName" v-html="bodyHtml" ref="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            <a v-if="authorize('modify', answer)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                            <button v-if="authorize('modify', answer)" @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                        </div>
                    </div>
                    <div class="col-4"></div>
                        <UserInfo :model="answer" label="Answered"></UserInfo>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Paths from "../mixins/paths";
    export default {
        props: ['answer'],
        mixins: [Paths],

        data () {
            return {
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionId: this.answer.question_id,
                beforeEdit: null
            }
        },
        methods: {
            setEditCache () {
                this.beforeEdit = this.body;
            },
            restoreFromCache (){
                this.body = this.beforeEdit;
            },
            payload() {
              return {
                  body: this.body
              }
            },
            delete () {
                axios.delete(this.url).then(response => {
                    this.$emit('deleted', );
                    this.$toast.success(response.data.message, 'Success', {timeout: 3000});

                });
            }

        },
        computed: {
            isInvalid () {
                return this.body.length < 10
            },
            url () {
                return `/questions/${this.questionId}/answers/${this.id}`
            },
            uniqueName () {
                return `answer-${this.id}`;
            }
        }
    }
</script>

<style scoped>

</style>
