<template>
    <div>
        <div class="chat-history">
            <ul style="height: 480px"></ul>
        </div>
        <div class="chat-message clearfix">
            <form :action="`${url}/new`" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" :value="csrf_token"/>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>User type</label>
                        <select name="user_type" class="form-control" @change="changeMessageAbleUser">
                            <option value="">Select one</option>
                            <option value="user" title="Admin panel users">User</option>
                            <option value="contact" title="Customer contact accounts">Contact</option>
                        </select>
                    </div>
                    <div class="form-group col-md-8">
                        <label>Message to</label>
                        <select name="msg_to" class="form-control">
                            <option>Select one</option>
                            <optgroup
                                v-if="messageType === 'contact'"
                                v-for="(customer, key) in messageAbleUserList"
                                :key="key"
                                :label="customer.customer_name">
                                <option v-for="(contact, ckey) in customer.contacts"
                                        :key="ckey"
                                        :value="contact.id">
                                    {{ contact.name }}
                                </option>
                            </optgroup>

                            <option v-if="messageType === 'user'"
                                    v-for="(user, ukey) in messageAbleUserList"
                                    :key="ukey"
                                    :value="user.id">
                                {{ user.name }}
                            </option>

<!--                            <option v-for="(user, key) in messageAbleUserList" :key="key" :value="user.id">
                                <span v-if="user.customer"> {{ user.name }} ({{ user.customer.customer_name }})</span>
                                <span v-else>{{ user.name }}</span>
                            </option>-->
                        </select>
                    </div>
                </div>

                <div class="input-group mb-0">
                    <input type="text" name="msg" class="form-control" style="padding-left: 0.75rem;"
                              placeholder="Enter text here..." />
                    <div class="input-group-prepend">
                        <button class="btn btn-info rounded-right mt-0">
                            <i :class="send_icon"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group mt-3">
                        <input type="file" name="attachment" class="form-control" id="customFile"/>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "FirstMessageSender",
    props: {
        url: String,
        csrf_token: String,
        send_icon: {
            type: String,
            default: "la la-send"
        }
    },
    data() {
        return {
            messageAbleUserList: [],
            messageType: ''
        }
    },
    methods: {
        changeMessageAbleUser(userType) {
            if (userType.target.value) {
                axios.get(`${this.url}/recipients/${userType.target.value}`)
                    .then(res => {
                        this.messageAbleUserList = res.data;
                        this.messageType = res.data.type;
                        this.messageAbleUserList = res.data.account;
                    });
            }
        }
    }
}
</script>
