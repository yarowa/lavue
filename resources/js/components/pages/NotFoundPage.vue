<template>
    <div class="container">
        <div class="jumbotron text-center">
            <h1 class="display-4">404</h1>
            <p class="lead">The page you are trying to access doesn't exist or removed  </p>
            <hr class="my-4">
            <router-link class="btn btn-primary btn-lg" :to="{name: 'home'}"  role="button">Back to home page</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NotFoundPage"
    }
</script>

<style scoped>

</style>
