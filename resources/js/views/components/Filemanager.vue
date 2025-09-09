<template>
    <file-manager v-bind:settings="settings"></file-manager>
</template>

<script>

export default {
    computed: {
        settings() {
            return {
                // axios headers
                headers: {
                  'X-Requested-With': 'XMLHttpRequest',
                  Authorization: `Bearer ${window.localStorage.getItem('user-token')}`,
                },
                baseUrl: window.location.origin + '/file-manager/',   // overwrite base url Axios
                windowsConfig: 2,                           // overwrite config
                lang: 'en',                                 // set language
                translation: {                              // add new translation
                    name: "en",
                    content: {
                        about: 'Hafijul',
                        back: 'Islam',
                    },
                },
            };
        },
    }

}

</script>
