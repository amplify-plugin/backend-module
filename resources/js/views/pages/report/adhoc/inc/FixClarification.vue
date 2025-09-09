<template>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Question: {{ prompt_data.question }}</h5>
            <div class="form-group">
                <label>{{ prompt_data.data.EA_Prompt }}</label>
                <select v-if="prompt_data.data.EA_Type == 'Select'" @change="selectPrompt" :disabled="!prompt_data.is_active" class="form-control">
                    <option value="" disabled selected>Select your relevent option.</option>
                    <option v-for="(choice) in prompt_data.data.EA_Choice">{{ choice }}</option>
                </select>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "FixClarification-Inc",
        props: ['prompt_data'],
        methods: {
            selectPrompt({target: { value }}) {
                this.prompt_data.is_active = false;
                this.$parent.promptText = value;
                this.$parent.getPromptResponse();
            }
        }
    }
</script>
