<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-item-center">
                            <h2>All Questions</h2>
                            <div class="ml-auto">
                                <a href="#" class="btn btn btn-outline-secondary">Ask Question</a>
                            </div>
                        </div>

                    </div>
                    <Questions></Questions>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Questions from "../Questions";

    export default {
        name: "QuestionsPage",
        components: {Questions},

    }
</script>

<style scoped>

</style>
