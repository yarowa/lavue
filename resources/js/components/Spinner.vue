<template>
    <div class="spinner" :style="getMinWidth">
        <i class="fa fa-spinner fa-spin" :class="spinnerSize" ></i>
    </div>
</template>

<script>
    export default {
        name: "Spinner",
        props: {
            small: {
                type: Boolean,
                default: false
            },
            minWidth: {
                type: Number,
                default: 109.61
            }
        },
        computed: {
            spinnerSize () {
                return this.small ? '' : 'fa-3x';
            },
            getMinWidth () {
                return {
                    minWidth: this.minWidth + 'px'
                }
            }
        }
    }
</script>

<style scoped>
    .spinner {
        color: #dddddd;
        text-align: center
    }
</style>
