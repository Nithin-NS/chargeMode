<template>
    <div>
        <div class="row mb-20">
            <!-- <div class="col-8">
                <div class="input-group">
                    <input
                        type="search"
                        name="search"
                        class="form-control rounded"
                        placeholder="Search"
                        aria-label="Search"
                        aria-describedby="search-addon"
                    />
                    <button type="submit" class="btn btn-outline-primary">
                        search
                    </button>
                </div>
            </div> -->
            <div class="col-4">
                <button
                    type="submit"
                    value="Submit"
                    id="remoteStart"
                    @click.prevent="clearMessages()"
                    class="btn btn-outline-primary"
                >
                    <i class="icon fa-plus" aria-hidden="true"></i>
                    <span class="text hidden-sm-down">Clear Messages</span>
                </button>
            </div>
            <div class="col-md-8" style="margin: 0;">
                <div
                    class="alert alert-primary"
                    role="alert"
                    v-if="msg"
                    style="margin: 0;padding: 6px;"
                >
                    {{ msg }}
                </div>
                <span class=""> </span>
            </div>
        </div>

        <div class="card">
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
                        <td style="padding: 24px 8px !important;">
                            {{ message["uid"] }}
                        </td>
                        <td style="padding: 24px 8px !important;">
                            {{ message["date"] }}
                        </td>
                        <td style="padding: 24px 8px !important;">
                            <span class="">{{ message["station"] }}</span>
                        </td>
                        <!-- <td>
                                    <span
                                        class="badge"
                                        style="background-color: green;color:white;"
                                        >Active</span
                                    >
                                </td> -->
                        <td
                            v-if="message['type'] === 'in'"
                            style="padding: 24px 8px !important;"
                        >
                            <span
                                class="badge"
                                style="background-color: green;color:white;"
                                >{{ message["type"] }}</span
                            >
                        </td>
                        <td v-else style="padding: 24px 8px !important;">
                            <span
                                class="badge"
                                style="background-color: #eb6709;color:white;"
                                >{{ message["type"] }}</span
                            >
                        </td>
                        <td style="padding: 24px 8px !important;">
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
            msg: "",
            timer: ""
        };
    },
    mounted() {
        // console.log("Messages mounted.");
    },
    created() {
        this.getDeviceMessages();
        this.timer = setInterval(this.getDeviceMessages, 1000);
    },
    methods: {
        getDeviceMessages() {
            axios.get("/getDeviceMessages").then(
                function(response) {
                    this.messages = response.data;
                    this.msg = "";
                    // console.log("Updating Messages");
                }.bind(this)
            );
        },
        cancelAutoUpdate() {
            clearInterval(this.timer);
            console.log("Messages Clearing..");
        },
        beforeDestroy() {
            this.cancelAutoUpdate();
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
