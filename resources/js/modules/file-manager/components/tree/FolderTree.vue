<template>
    <div class="fm-tree" :class="{'cs-left-sidebar' : $parent.showMenu}">
        <div class="fm-tree-disk sticky-top">
            <i class="la la-hdd-o"/> {{ selectedDisk }}
        </div>
        <branch v-bind:parent-id="0"/>
    </div>
</template>

<script>
import Branch from './Branch.vue';

export default {
    name: 'FolderTree',
    components: {
        branch: Branch,
    },
    computed: {
        /**
         * Selected Disk
         * @returns {*}
         */
        selectedDisk() {
            return this.$store.getters['fm/selectedDisk'];
        },
    },
};
</script>

<style lang="scss">
.fm-tree {
    overflow: auto;
    border-right: 1px solid #6d757d;

    & > .fm-folders-tree {
        padding-left: 0.2rem;
    }

    .fm-tree-disk {
        padding: 0.2rem 0.3rem;
        margin-bottom: 0.3rem;
        background-color: white;
    }

    .fm-tree-disk > i {
        padding-left: 0.2rem;
        padding-right: 0.5rem;
    }
}

@media only screen and (max-width: 768px) {
    .fm-tree{
        display:none
    }
    .cs-left-sidebar {
        display: block;
        position: absolute;
        z-index: 999;
        background: white;
        width: 100%;
        max-width: 250px;
        height: 100%;
        left: 0;
    }
}
</style>
