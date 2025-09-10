<template>
    <div v-if="isShoing">
        <slot></slot>
    </div>
</template>
<script>
export default {
    name: 'Permission',
    props: ['isShoing'],
    comments:{
        setShowing(){
        return isShoing;
    }
    },
  methods:{
    
  },
}
</script>