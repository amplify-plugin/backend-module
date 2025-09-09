import Vue from 'vue';
import Vuex from 'vuex';

import heaterWire from './store/heater-wire';
import shelving from './store/shelving';
import stripCurtains from './store/strip-curtains';
import stripCurtainsCompleted from './store/strip-curtains-completed';
import stripCurtainsBulk from './store/strip-curtains-bulk';
import cuttingBoard from './store/cutting-board';
import gasket from './store/gasket';
import tubularHeaters from './store/tubular-heaters';
import evaporatorCoils from './store/evaporator-coils';
import checkout from './store/checkout';

Vue.use(Vuex);
const config = {
    language: 'en',
};
Vue.config.devtools = true;
const store = new Vuex.Store({
    state: {
        config,
    },
    mutations: {
        async generateLocalization(state, lang) {
            Vue.prototype.__ = (str, replaceAbleKeys = {}) => {
                let localizationStr = _.get(lang, str) ?? '';
                for (const key in replaceAbleKeys)
                    localizationStr = localizationStr.replaceAll(`:${key}`, replaceAbleKeys[key]);
                localizationStr = localizationStr.length > 0 ? localizationStr : str;

                return localizationStr;
            };
        },
    },
    actions: {
        async localization({ commit }) {
            await axios('/locale-lang.js').then(({ data }) => {
                commit('generateLocalization', data);
            });
        },
    },

    // plugins area start from here
    modules: {
        shelving,
        heaterWire,
        stripCurtains,
        stripCurtainsCompleted,
        stripCurtainsBulk,
        cuttingBoard,
        gasket,
        tubularHeaters,
        checkout,
        evaporatorCoils,
    },
});
export default store;
