<template>
    <a title="Click to mark as favorite question (click again to undo)"
       :class="classes"
        @click.prevent="toggle">
        <i class="fas fa-star fa-2x"></i>
        <span class="favorites-count">{{ count }}</span>
    </a>
</template>

<script>
    export default {
        name: "Favorite",
        props: ['question'],
        data () {
            return {
                isFavored: this.question.is_favored,
                count: this.question.favorites_count,
                id: this.question.id,
            }
        },
        computed: {
            classes () {
                return [
                    'favorite', 'mt-2',
                    ! this.signedIn ? 'off' : (this.isFavored ? 'favorited' : '')
                ]
            },
            url () {
                return `/questions/${this.id}/favorites`
            }
        },
        methods: {
            toggle() {
                if (! this.signedIn){
                    this.$toast.warning('Please sign in to mark as favorite', 'warning', {timeout: 3000});
                    return;
                }
                this.isFavored ? this.destroy() : this.create()
            },
            destroy () {
                axios.delete(this.url).then( response =>{
                    this.count --;
                    this.isFavored = false;
                });
            },
            create () {
                axios.post(this.url).then( response => {
                    this.count ++;
                    this.isFavored = true;
                });
            }
        }
    }
</script>

<style scoped>

</style>
