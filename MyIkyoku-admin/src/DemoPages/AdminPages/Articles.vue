<template>
    <div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="border-light card-border card">
                    <articleTable />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import articleTable from './Feed/ArticleTable'

    export default {
        components: {
            articleTable
        },

        data: () => ({
            feed_id: '',
        }),

        created() {
            this.feed_id = this.$route.params.id;
        }
    }
</script>