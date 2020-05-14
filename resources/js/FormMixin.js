export default {
    props: {
        user_id: {
            required: true,
            type: String
        }
    },
    data() {
        return {
            fields: {
                type_of_user: 0,
            },
            errors: {},
            success: false,
            loaded: true,
            species: [],
            isDragging: false,
            dragCount: 0,
            action: '',
            files: [],
            images: [],
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    },
    created() {
        axios.get('./api/race')
            .then(response => this.species = response.data);
    },
    methods: {
        OnDragEnter(e) {
            e.preventDefault();

            this.dragCount++;
            this.isDragging = true;

            return false;
        },
        OnDragLeave(e) {
            e.preventDefault();
            this.dragCount--;

            if (this.dragCount <= 0)
                this.isDragging = false;
        },
        onInputChange(e) {
            const files = e.target.files;

            Array.from(files).forEach(file => this.addImage(file));
        },
        onDrop(e) {
            e.preventDefault();
            e.stopPropagation();

            this.isDragging = false;

            const files = e.dataTransfer.files;

            Array.from(files).forEach(file => this.addImage(file));
        },
        addImage(file) {
            if (!file.type.match('image.*')) {
                this.$toastr.e(`${file.name} is not an image`);
                return;
            }

            this.files.push(file);

            const reader = new FileReader();

            reader.onload = (e) => this.images.push(e.target.result);

            reader.readAsDataURL(file);
        },
        getFileSize(size) {
            const fSExt = ['Bytes', 'KB', 'MB', 'GB'];
            let i = 0;

            while(size > 900) {
                size /= 1024;
                i++;
            }

            return `${(Math.round(size * 100) / 100)} ${fSExt[i]}`;
        },

        store() {
            if(this.loaded) {
                this.errors = {};
                this.fields['user_id'] = this.user_id;
                const formData = new FormData();

                $.each(this.fields, function (key, value) {
                    formData.append(key, value);
                });
                formData.append('user_position', document.querySelector('#ads_location').value);
               // console.log(formData['infos'].get('price'));
               console.log(formData['user_position'])
                $.each(this.files, function (key, image) {
                    formData.append(`images[${key}]`, image);
                });

                let self = this;

                axios.post('api/ads', formData, {headers: {'Content-Type': 'multipart/form-data'}}).then(response => {
                    this.loaded = true;
                    this.success = true;
                   // console.log(this.fields['images']);
                    this.fields = {};
                    this.files = {};
                    this.images = {};
                    this.$toastr.s('Your post has been successfully added!');
                    window.location = "/offers";
                }).catch(error => {
                    if (error.response) {
                        if(error.response.status === 422)
                            this.errors = error.response.data.errors || {};
                    }
                })
            }
        },

    },
    

}
