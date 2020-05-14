export default {
    props: {
        url: {
            required: true,
            type: String
        },
    },

    data() {
        return {
            fields: {
                type_of_user : "0",
            },
            errors: {},
            disabled: 1,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },

    computed: {
        isDisabled: function(){
            return !this.fields['legal_conditions'];
        },
        checked: function () {
            return true;
        }
    },

    methods: {
        store() {
            axios.post(this.url, this.fields).then(response => {
                this.fields = {};
                this.$toastr.s('Your account has been successfully created!', 9000);
                /*this.$toastr.options.timeOut = 100;
                this.$toastr.options.fadeOut = 100;
                this.$toastr.options.onHidden = function(){
                    // this will be executed after fadeout, i.e. 2secs after notification has been show
                    console.log('ca')

                };*/
                window.location = "/home";
            }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                }
            })
        }
    },
}
