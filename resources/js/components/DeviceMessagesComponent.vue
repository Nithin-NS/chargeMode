<template>
    <div class="row">
        <div class="col-md-4">
            <button
                type="submit"
                value="Submit"
                id="remoteStart"
                @click.prevent="clearMessages()"
                class="btn btn-success btn-sm"
            >
                Clear Messages
            </button>
        </div>
        <div class="col-md-8">
            <div class="alert alert-primary" role="alert" v-if="msg">
                {{ msg }}
            </div>
            <span class=""> </span>
        </div>
        <div class="col-12">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">U-ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Station</th>
                        <th scope="col">Type</th>
                        <th scope="col">Message</th>
                    </tr>
                </thead>
                <tbody>
                    <tr :key="message['id']" v-for="message in messages">
                        <td>{{ message["uid"] }}</td>
                        <td>{{ message["date"] }}</td>
                        <td>
                            <span class="">{{ message["station"] }}</span>
                        </td>
                        <!-- <td>
                                    <span
                                        class="badge"
                                        style="background-color: green;color:white;"
                                        >Active</span
                                    >
                                </td> -->
                        <td v-if="message['type'] === 'in'">
                            <span
                                class="badge"
                                style="background-color: green;color:white;"
                                >{{ message["type"] }}</span
                            >
                        </td>
                        <td v-else>
                            <span
                                class="badge"
                                style="background-color: red;color:white;"
                                >{{ message["type"] }}</span
                            >
                        </td>
                        <td>
                            <span>{{ message["message"] }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            messages: [],
            msg: ""
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
                    // console.log(this.messages);
                }.bind(this)
            );
        },
        clearMessages: function() {
            axios.get("/clearDeviceMessages").then(
                function(response) {
                    this.msg = response.data;
                    this.messages = [];
                }.bind(this)
            );
        }
    }
};
</script>
