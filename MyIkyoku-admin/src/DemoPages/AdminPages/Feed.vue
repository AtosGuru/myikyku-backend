<template>
    <div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="border-light card-border card">
                    <feedTable />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import feedTable from './Feed/FeedTable'
    export default {
        components: {
            feedTable,
        }
    }
</script>