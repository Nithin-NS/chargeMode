<template>
    <div class="row">
        <div class="col-12">
            <div class="panel">
                <div class="panel-body">
                    <table
                        class="table table-hover dataTable table-striped w-full"
                        data-plugin="dataTable"
                        id="msg_table"
                    >
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Station</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="message in messages" :key="message">
                                <td>1</td>
                                <td>21-05</td>
                                <td>
                                    <span class="">{{ message[1] }}</span>
                                </td>
                                <td>
                                    <span
                                        class="badge"
                                        style="background-color: green;color:white;"
                                        >Active</span
                                    >
                                </td>
                                <td>
                                    <span
                                        class="badge"
                                        style="background-color: red;color:white;"
                                        >Out</span
                                    >
                                </td>
                                <td>
                                    <span>{{ message[3] }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            messages: []
        };
    },
    mounted() {
        console.log("Messages mounted.");
    },
    created() {
        this.getDeviceMessages();
    },
    methods: {
        getDeviceMessages: function() {
            axios.get("/getDeviceMessages").then(
                function(response) {
                    this.messages = response.data;
                    console.log(this.messages);
                }.bind(this)
            );
        }
    }
};
</script>
