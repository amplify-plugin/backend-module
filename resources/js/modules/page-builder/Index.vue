<template>
    <div>
        <div id="editor">
            <p>Testing Editor using Grapes JS librrary</p>
        </div>
        <button @click="upload">submit</button>
    </div>
</template>

<script>
import DataBlocks from './data.js';

export default {
    data() {
        return {
            editor: null,
        }
    },
    mounted() {
        this.setupGrapesTemplateBuilder();
        this.addendBlocks();
    },

    methods: {
        setupGrapesTemplateBuilder() {
            this.editor = grapesjs.init({
                container: "#editor",
                height: "100vh",
                width: "auto",
                fromElement: true,
                storageManager: false,
                canvas: {
                    styles: [
                        "https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css",
                    ],
                    scripts: [
                        "https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js",
                    ],
                },
                plugins: [],
                // plugins: ["gjs-preset-webpage"],
                // pluginsOpts: {
                //     "gjs-preset-webpage": {},
                // },
            });

            // this.editor.on('block:drag:start', (block) => {
            //     console.log(block, 'string')
            // });
        },
        async addendBlocks() {
            // const res = await axios.get('/admin/page-builder/components');
            // this.editor.Blocks.add('BLOCK-ID', res.data);

            this.editor.Blocks.add('BLOCK-ID', DataBlocks);
        },
        upload() {
            console.log(this.editor.getComponents().models);
            // console.log(this.editor.DomComponents.getWrapper().attributes.attributes);
        }
    }
};
</script>



<style>
* {
    padding: 0;
    margin: 0;
}
</style>