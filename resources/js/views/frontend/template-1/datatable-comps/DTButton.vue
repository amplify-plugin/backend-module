<template>
    <div class="row">
        <a :href="`/${$parent.$parent.$parent.$parent.pathname}/${data.id}/view`" class="col-sm" :class="classes.view" title="View">
            View
        </a>
        <a :href="`/${$parent.$parent.$parent.$parent.pathname}/${data.id}/edit`" class="col-sm" :class="classes.edit" title="Edit">
            Edit
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            data: {},
            classes: {
                type: Object,
                default: () => ({
                    view: {},
                    edit: {}
                }),
            },
        }
    }
</script>
