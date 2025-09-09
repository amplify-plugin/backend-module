<template>
    <ul class="nav nav-pills flex-column" role="tablist">
        <li
            role="presentation"
            class="nav-item"
            v-for="(tab, name) in $parent.tabs"
            @click="$parent.changeTab(name)"
            :key="name"
        >
            <a
                :href="`#tab_${tab.hash}`"
                :aria-controls="`tab_${tab.hash}`"
                role="tab"
                :tab_name="`${tab.hash}`"
                data-toggle="tab"
                :class="{ active: $parent.activeTab === name }"
                class="nav-link"
                >{{ tab.title }}</a
            >
        </li>
    </ul>
</template>

<script>
export default {
    name: 'Tabs',
};
</script>

<style scoped></style>
