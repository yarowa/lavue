<template>
    <div class="d-fex flex-column vote-controls">
        <a @click.prevent="voteUp" :title="title('up')"
           class="vote-up" :class="classes"
           >
            <i class="fas fa-caret-up fa-3x"></i>
        </a>


        <span class="votes-count">{{ count }}</span>

        <a @click.prevent="voteDown" :title="title('down')"
           class="vote-down" :class="classes"
           >
            <i class="fas fa-caret-down fa-3x"></i>
        </a>
        <Favorite v-if="name === 'question'" :question="model"></Favorite>
        <Accept v-else :answer="model"></Accept>

    </div>
</template>

<script>
    import Favorite from "./Favorite";
    import Accept from "./Accept";
    export default {
        props: ['name', 'model'],
        components: {
            Favorite,
            Accept
        },
        computed: {
            classes () {
                return this.signedIn ? '' : 'off';
            },
            url () {
                return `/${this.name}s/${this.id}/vote`
            }
        },
        data () {
            return {
                count: this.model.votes_count,
                id: this.model.id
            }
        },
        methods: {
            title (voteType) {
                let titles = {
                    up: `This ${ this.name } is useful `,
                    down: `This ${ this.name } is not useful `,
                };
                return titles[voteType];
            },
            voteUp () {
                this._vote(1);

            },
            voteDown () {
                this._vote(-1);
            },
            _vote (vote) {
                if (! this.signedIn){
                    this.$toast.warning(`Please login to vote the ${this.name}`, 'Ooops', {
                        timeout: 3000,
                        position: 'bottomLeft'
                    })
                    return;
                }
                axios.post(this.url, { vote }).then( response => {
                    this.$toast.success(response.data.message, 'Success', {
                        timeout: 3000,
                        position: 'bottomLeft'
                    });
                    this.count = response.data.votesCount;
                })
            }
        }
    }
</script>

<style scoped>

</style>
