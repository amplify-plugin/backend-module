<template>

    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            Language: {{ current_lang }} <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <a v-for="(available_locale, locale) in availableLocales" :key="locale"
               class="dropdown-item"
               :href="`${url}?${getQueryString(locale)}`">
                {{ available_locale }}
            </a>
        </ul>
    </div>
</template>

<script>
export default {
    props: ['current_lang', 'availableLocales', 'url', 'queryString'],
    name : "AvailableLocales",
    methods: {
        getQueryString(locale) {
            let queryString    = JSON.parse(this.queryString)
            queryString.locale = locale;

            return Object.keys(queryString)
                .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(queryString[key])}`)
                .join('&');
        }
    }
}
</script>

<style scoped>

</style>
