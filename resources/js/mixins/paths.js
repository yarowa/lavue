import Vote from '../components/Vote.vue';
import UserInfo from '../components/UserInfo.vue';
import Editor from '../components/Editor.vue';
import highlight from './highlight';
import destroy from './destroy';

export default {
    mixins: [highlight, destroy],

    components: { Vote, UserInfo, Editor },

    data () {
        return {
            editing: false
        }
    },

    methods: {
        edit () {
            this.setEditCache();
            this.editing = true;
        },

        cancel () {
            this.restoreFromCache();
            this.editing = false;
        },

        setEditCache () {},
        restoreFromCache () {},

        update () {
            axios.put(this.url, this.payload())
                .catch(({response}) => {
                    this.$toast.error(response.data.message, "Error", { timeout: 3000 });
                })
                .then(({data}) => {
                    this.bodyHtml = data.body_html;
                    this.$toast.success(data.message, "Success", { timeout: 3000 });
                    this.editing = false;
                })
                .then(() => this.highlight());
        },

        payload () {}
    }
}
