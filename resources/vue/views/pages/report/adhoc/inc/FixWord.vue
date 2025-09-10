<template>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Question: {{ prompt_data.question }}</h5>
            <p>{{ prompt_data.message }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FixWord-Inc",
        props: ['prompt_data'],
    }
</script>
