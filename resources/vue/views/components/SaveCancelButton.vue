<template>
    <div id="saveActions" class="form-group">
        <input type="hidden"
               name="save_action"
               value="save_and_back"
               v-model="actionType">
        <div class="btn-group"
             role="group">
            <button type="button"
                    class="btn btn-success"
                    @click.once="alert('clicked');">
                <span class="la la-save"
                      role="presentation"
                      aria-hidden="true">
                </span> &nbsp;
                <span>{{ saveAction.active.label }}</span>
            </button>
            <div class="btn-group"
                 role="group">
                <button id="bpSaveButtonsGroup"
                        type="button"
                        class="btn btn-success dropdown-toggle"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">▼</span>
                </button>
                <div class="dropdown-menu"
                     aria-labelledby="bpSaveButtonsGroup">
                    <template v-for="(option, k, index) in saveAction.options">
                        <a class="dropdown-item"
                           href="javascript:void(0);"
                           :key="'actionType-'+index"
                           @click="$emit('click', k)">
                            {{ option }}
                        </a>
                    </template>
                </div>
            </div>
        </div>
        <a :href="backUrl" class="btn btn-default">
            <i class="la la-ban ml-2"></i>
            Cancel
        </a>
    </div>
</template>
<script>
export default {
    name: "SaveCancelButton",
    props: ["defaultType", "action", "cancelUrl"],
    data() {
        return {
            backUrl: '',
            actionType: 'save_and_back',
            saveAction: {},
        }
    },
    mounted() {
        this.actionType = this.defaultType
        this.backUrl = this.cancelUrl
        this.saveAction = this.action
    },
}
</script>

<style scoped>

</style>
