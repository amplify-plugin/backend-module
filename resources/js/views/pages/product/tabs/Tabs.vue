<template>
    <ul class="nav nav-tabs" role="tablist">
        <li
            role="presentation"
            class="nav-item"
            v-for="(tab, name) in $parent.tabs"
            @click="$parent.activeTab = name"
            :key="name"
        >
            <a
                :href="`#tab_${tab.hash}`"
                :aria-controls="`tab_${tab.hash}`"
                role="tab"
                data-toggle="tab"
                :class="{ active: $parent.activeTab === name, 'text-danger': tab.hasError }"
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
