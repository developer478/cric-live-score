<template>
    <div class="rca-menu-widget rca-live-season rca-left-border">
        <a href="#" class="rca-padding">
            <span class="rca-match-title rca-live-text">IND vs IRE : </span><span class="rca-match-score">Ind 89/8 - 14.8(0)</span>
            <span v-on:click="getData">Refresh</span>
            <span class="rca-live-label rca-right">Live</span>
        </a>
    </div>
</template>

<script>
    export default {
        mixins: [],
        beforeCreate() {

        },
        beforeUpdate() {

        },
        updated() {

        },
        watch : {

        },
        mounted() {

            setInterval(function () {
                // this.getData();
            }.bind(this), 30000);

            Echo.channel('score-board')
                .listen('getLiveScore', (data) => {
                    debugger
                    console.log('Pusher Data',data);
            });

        },
        created: function () {

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('2b04d2c5cedcf7ef29d2', {
                cluster: 'ap2',
                forceTLS: true
            });

            var channel = pusher.subscribe('score-board');
            channel.bind('get-live-score', function(data) {

            });
        },
        data() {
            return {
                loading: true,
                processing: false,
                List:[]
            }
        },
        methods: {

            getData: function () {
                axios.get("match/live-score")
                .then((res) => {
                    console.log('response Data',res);
                    this.List = res.data.response.data.matchList;
                })
                .catch(function (errors) {

                });
            },
        },

    }
</script>
