<template>
    <ul class="rca-season-list">
        <li v-for="match in List.matches">
            <a href="#">
                {{ match.series.shortName }}
            </a>
        </li>
    </ul>
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
            this.getData();
        },
        created: function () {

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
                axios.get("match/upcoming")
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
