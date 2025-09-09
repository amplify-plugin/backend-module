export default {
    data() {
        return {
            actionType: 'save_and_back',
            saveAction: {
                active: {
                    value: "save_and_back",
                    label: "Save and back"
                },
                options : {
                    save_and_edit: "Save and edit this item",
                    save_and_new: "Save and new item",
                    save_and_preview: "Save and preview"
                }
            },
        }
    }
}
