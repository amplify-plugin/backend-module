<template>
    <component :is="current"/>
</template>
<script>
import EvaporateCoil from './evaporator-coils/index.vue';
import CuttingBoard from './cutting-board/index.vue';
import WireShelf from './wire-shelf/index.vue';
import Gaskets from './gaskets/index.vue';
import StripCurtainsCompleted from './strip-curtains/completed.vue';
import StripCurtainsReplacement from './strip-curtains/replacement.vue';
import StripCurtainsMaterial from './strip-curtains/material.vue';
import HeaterWire from './heater-wire/index.vue';
import TubularHeaters from './tubular-heaters/index.vue';
import DrainTubeHeaters from './drain-tube-heaters/index.vue';


    export default {
        name: 'CustomItem',
        props: ['currentComponent'],
        components : [EvaporateCoil, CuttingBoard,WireShelf,TubularHeaters,DrainTubeHeaters],
        data() { 
            return {
                'current' : null
            }
        },
        mounted() {
            switch(this.currentComponent) {
                case 'evaporator-coils' : 
                    this.current = EvaporateCoil;
                break;

                case 'cutting-board' : 
                    this.current = CuttingBoard;
                break;

                case 'wire-shelf' : 
                    this.current = WireShelf;
                break;

                case 'gaskets' : 
                    this.current = Gaskets;
                break;

                case 'strip-curtains-completed' : 
                    this.current = StripCurtainsCompleted;
                break;

                case 'strip-curtains-replacement' : 
                    this.current = StripCurtainsReplacement;
                break;

                case 'strip-curtains-material' : 
                    this.current = StripCurtainsMaterial;
                break;

                case 'heater-wire' : 
                    this.current = HeaterWire;
                break;

                case 'tubular-heaters' : 
                    this.current = TubularHeaters;
                break;
                case 'drain-tube-heaters' : 
                    this.current = DrainTubeHeaters;
                break;

                default : 
                    this.current = EvaporateCoil;
            }
        }
    }

</script>