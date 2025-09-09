<template>
    <file-manager v-bind:settings="settings"></file-manager>
</template>

<script>
import allDisksMixin from '../../allDisks.mixin';

export default {
    mixins: [allDisksMixin],
    props: ['input_id', 'is_multiple'],
    computed: {
        settings() {
            return {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    Authorization: `Bearer ${window.localStorage.getItem('user-token')}`,
                },
                baseUrl: window.location.origin + '/file-manager/',
                windowsConfig: 2,
            };
        },
    },
    mounted() {
        addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                this.getFileCallbackForMultiple()
            }
        });

    },
    methods: {
        getFileCallback: function (file) {
            window.parent.processSelectedFile(file, this.input_id);
            parent.jQuery.colorbox.close();
        },
        getFileCallbackForMultiple: function () {
            let files = [];
            this.$store.state.fm.left.selected.files.forEach(file => {
                files.push({ path: this.all_disks[this.$store.state.fm.left.selectedDisk].url ? new URL(file, this.all_disks[this.$store.state.fm.left.selectedDisk].url).href : "/" + file });
            });

            if (files.length) {
                window.parent.processSelectedMultipleFiles(files, this.input_id);
                parent.jQuery.colorbox.close();
            }
        }
    },
    watch: {
        "$store.state.fm.left.selected.files": {
            handler(files) {
                if (files.length && this.is_multiple == 0) {
                    let file = files[0];
                    let url = this.all_disks[this.$store.state.fm.left.selectedDisk].url;
                    if (url) {
                        url = new URL(url);
                        let filePath = url.href.endsWith('/') ? url.href + file : url.href + '/' + file;
                        file = new URL(filePath, url.origin).href;
                    }
                    this.getFileCallback(file);
                }
            }
        }
    }

}

</script>

<style>
@import "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css";
</style>
