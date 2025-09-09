<template>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label> Order Rule</label>
                <input type="text" class="form-control" disabled :value="approvalData.order_rule.name">
            </div>
            <div class="form-group">
                <label> Note </label>
                <textarea placeholder="Enter Approval Note" v-model="approvalData.notes" class="form-control" rows="3"
                    :readonly="isReadOnly"></textarea>
            </div>

            <div class="form-group" v-if="approvalData.status == 'pending'">
                <button class="btn btn-danger" @click="updateAction('rejected')" type="submit">Rejected</button>
                <button class="btn btn-success" @click="updateAction('approved')" type="submit">Approved</button>
            </div>
        </div>

    </div>
</template>

<script>
import _ from "lodash";
import Multiselect from 'vue-multiselect';
import axios from 'axios'
export default {
    components: {
        Multiselect
    },
    props: [
        'approval_data', 'path'
    ],
    data() {
        return {
            approvalData: JSON.parse(this.approval_data),
            isReadOnly: false
        }
    },
    methods: {
        updateAction(status) {
            let notes = this.approvalData.notes;
            if (status == "rejected" && notes.length === 0) {
                ShowNotification('error', 'err_message', 'Please provide order rejected note');
                return;
            }

            axios.post('/order-rule-track-approval', { id: this.approvalData.id, notes: notes, status: status })
                .then(res => {
                    if (res.status == 200) {
                        ShowNotification('success', 'err_message', res.data.message);
                        window.location.href = "/" + this.path;
                    } else {
                        ShowNotification('error', 'err_message', 'Something Wrong');
                    }
                })
                .catch(error => {
                    ShowNotification('error', 'err_message', error.response.data.message);
                });
        }

    },

    created() {
        this.isReadOnly = this.approvalData.status == 'approved';
    }

}
</script>

<style scoped></style>
