<template>
    <div class="row mt-3">
        <!-- text input -->
        <div v-if="loader" class="text-center w-100" style="height: 250px">
            <div class="loader">Loading...</div>
        </div>

        <div v-else class="form-group col-sm-12 mb-0">
            <div class="card mb-3">
                <div class="card-body">
                    <span v-for="(option, index) in $parent.$parent.classificationOptions" :key="index"
                            class="bg-light mr-1 px-1 px-3 py-1 rounded">
                        {{ option.local_name }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FormFields from "../../../options/FormFields";

export default {
    name: "Required",
    data() {
        return {
            validationErrors: "",
            loader          : false,
        }
    },

    components: {
        FormFields
    },
    mounted() {
        console.log( this.$parent.$parent.classificationOptions );
    },
}
</script>

<style scoped>
.loader,
.loader:before,
.loader:after {
    background: #7c88a0;
    -webkit-animation: load1 1s infinite ease-in-out;
    animation: load1 1s infinite ease-in-out;
    width: 1em;
    height: 4em;
}

.loader {
    color: #7c88a0;
    text-indent: -9999em;
    margin: 88px auto;
    position: relative;
    font-size: 6px;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
    -webkit-animation-delay: -0.16s;
    animation-delay: -0.16s;
}

.loader:before,
.loader:after {
    position: absolute;
    top: 0;
    content: '';
}

.loader:before {
    left: -1.5em;
    -webkit-animation-delay: -0.32s;
    animation-delay: -0.32s;
}

.loader:after {
    left: 1.5em;
}

@-webkit-keyframes load1 {
    0%,
    80%,
    100% {
        box-shadow: 0 0;
        height: 4em;
    }
    40% {
        box-shadow: 0 -2em;
        height: 5em;
    }
}

@keyframes load1 {
    0%,
    80%,
    100% {
        box-shadow: 0 0;
        height: 4em;
    }
    40% {
        box-shadow: 0 -2em;
        height: 5em;
    }
}
</style>
