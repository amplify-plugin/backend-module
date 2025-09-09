import axios from 'axios';

export default {
    data() {
        return {
            all_disks: [],
        };
    },
    created: function () {
        axios.get('/admin/disks').then((res) => {
            this.all_disks = res.data;
        });
    },
};
