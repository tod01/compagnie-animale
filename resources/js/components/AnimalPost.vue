<template>
    <form  @submit.prevent="store">

        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-info">
                        Your Post
                    </div>
                    <div class="card-body">

                        <div class="col-md-8">

                            <div class="form-group" >
                                <label for="type_of_race">Race</label>
                                <select class="form-control" id="type_of_race" name="type_of_race" v-bind:class="{'is-invalid': errors.type_of_race} " v-model="fields.type_of_race">
                                    <option>Choose a race</option>
                                    <option v-bind:value="race.id" v-for="race in species"> {{race.species}}</option>
                                </select>
                                <span class="invalid-feedback" v-if="errors && errors.type_of_race" role="alert">
                                    <strong>{{ errors.type_of_race[0] }}</strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="type_of_post">Type of post</label>
                                <select class="form-control" id="type_of_post" name="type_of_post" v-bind:class="{'is-invalid': errors.type_of_post} " v-model="fields.type_of_post">
                                    <option selected>Choose a category</option>
                                    <option value="0">Donation</option> <!-- onselect="desable_price" -->
                                    <option value="1">Sell</option>
                                </select>
                                <span class="invalid-feedback" v-if="errors && errors.type_of_post" role="alert">
                                    <strong>{{ errors.type_of_post[0] }}</strong>
                                </span>
                            </div>

                            <div class="form-group" v-if="fields.type_of_post == 1">
                                <label for="price">Price</label>
                                <input type="number" name="price" v-model="fields.price" v-bind:class="{'is-invalid': errors.price} " class="form-control" placeholder="Enter your price" id="price">
                                <span class="invalid-feedback" v-if="errors && errors.price" role="alert">
                                    <strong>{{ errors.price[0] }}</strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="post_title">Title</label>
                                <input type="text" class="form-control" v-model="fields.post_title" v-bind:class="{'is-invalid': errors.post_title} " name="post_title" placeholder="Enter your title" id="post_title">
                                <span class="invalid-feedback" v-if="errors && errors.post_title" role="alert">
                                    <strong>{{ errors.post_title[0] }}</strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="race_belonging">Appartenance à une race</label>
                                <select class="form-control" id="race_belonging" v-bind:class="{'is-invalid': errors.race_belonging} " name="race_belonging" v-model="fields.race_belonging">
                                    <option selected>Choose</option>
                                    <option value="0">LOF / LOOF</option>
                                    <option value="1">Belonging/type/Not LOF/Not LOOF</option>
                                </select>
                                <span class="invalid-feedback" v-if="errors && errors.race_belonging" role="alert">
                                    <strong>{{ errors.race_belonging[0] }}</strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="age">Age</label>
                                <select class="form-control" id="age" name="animal_age" v-bind:class="{'is-invalid': errors.animal_age} " v-model="fields.animal_age">
                                    <option selected>Choose</option>
                                    <option value="0">More than 8 weeks</option>
                                    <option value="1">Less than 8 weeks</option>
                                    <option value="2">Adult</option>
                                </select>
                                <span class="invalid-feedback" v-if="errors && errors.animal_age" role="alert">
                                    <strong>{{ errors.animal_age[0] }}</strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="number_of_litter">Number of animals in the litter</label>
                                <input type="number" v-model="fields.number_litter" class="form-control" v-bind:class="{'is-invalid': errors.number_litter} " placeholder="Enter your number" id="number_of_litter" name="number_litter">
                                <span class="invalid-feedback" v-if="errors && errors.number_litter" role="alert">
                                    <strong>{{ errors.number_litter[0] }}</strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="id_number">Identification number</label>
                                <input type="text" class="form-control" v-model="fields.animal_id_number" v-bind:class="{'is-invalid': errors.animal_id_number} " placeholder="Enter the identification" name="animal_id_number" id="id_number">
                                <span class="invalid-feedback" v-if="errors && errors.animal_id_number" role="alert">
                                    <strong>{{ errors.animal_id_number[0] }}</strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <div class="ml-0">Your animal is </div>
                                <div class="form-check form-check-inline">
                                    <input class="ml-3 form-check-input" type="radio" v-model="fields.is_tattooed_or_chipped" v-bind:class="{'is-invalid': errors.is_tattooed_or_chipped} " name="is_tattooed_or_chipped" id="tattooed" value="1">
                                    <label class="form-check-label" for="tattooed">Tattooed</label>
                                    <input class="ml-3 form-check-input" type="radio" v-model="fields.is_tattooed_or_chipped" v-bind:class="{'is-invalid': errors.is_tattooed_or_chipped} " name="is_tattooed_or_chipped" id="chipped" value="0">
                                    <label class="form-check-label" for="chipped"> Chipped </label>
                                </div>
                                <span class="invalid-feedback" v-if="errors && errors.is_tattooed_or_chipped" role="alert">
                                    <strong>{{ errors.is_tattooed_or_chipped[0] }}</strong>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="text_post">Text of the post</label>
                                <textarea class="form-control" v-model="fields.post_text" v-bind:class="{'is-invalid': errors.post_text} " name="post_text" id="text_post" rows="8" cols="10"></textarea>
                                <span class="invalid-feedback" v-if="errors && errors.post_text" role="alert">
                                    <strong>{{ errors.post_text[0] }}</strong>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-info">
                        Upload images and video
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="uploader"
                                     @dragenter="OnDragEnter"
                                     @dragleave="OnDragLeave"
                                     @dragover.prevent
                                     @drop="onDrop"
                                     :class="{ dragging: isDragging }">

                                    <div class="upload-control" v-show="images.length">
                                        <label for="file">Select a file</label>
                                    </div>


                                    <div v-show="!images.length">
                                        <i class="fa fa-cloud-upload"></i>
                                        <p>Drag your images here</p>
                                        <div>OR</div>
                                        <div class="file-input">
                                            <label for="file">Select a file</label>
                                            <input type="file" id="file" @change="onInputChange" multiple>
                                        </div>
                                    </div>

                                    <div class="images-preview" v-show="images.length">
                                        <div class="img-wrapper" v-for="(image, index) in images" :key="index">
                                            <img :src="image" :alt="`Image Uplaoder ${index}`" aria-required="true">
                                            <div class="details">
                                                <span class="name" v-text="files[index].name"></span>
                                                <span class="size" v-text="getFileSize(files[index].size)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <!--   <div class="row">
                        <div class="col-md-8">
                            <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
                                <source src="https://storage.googleapis.com/coverr-main/mp4/Mt_Baker.mp4" type="video/mp4">
                            </video>
                        </div>
                    </div> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-info" name="user_position">
                        Localisation
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <!--<div class="form-group">
                                    <label for="address-input" class="col-form-label text-md-right">Town or postal code
                                    </label>
                                    <input type="text"  v-model="fields.user_position" v-bind:class="{'is-invalid': errors.user_position}" class="form-control " name="user_position" id="address-input" value="" size="20" maxlength="120" />
                                    <span class="invalid-feedback" v-if="errors && errors.user_position" role="alert">
                                        <strong>{{ errors.user_position[0] }}</strong>
                                    </span>
                                </div>-->
                                <div class="content" v-bind:class="{'is-invalid': errors.user_position}">
                                    <div class="column">
                                        <div class="map-wrapper">
                                            <div id='map'></div>
                                            <input type="text" id="ads_location" value="" size="20" maxlength="120" />
                                        </div>
                                    </div>
                                </div>
                                <div class="invalid-feedback d-block" v-if="errors && errors.user_position" role="alert">
                                    <strong>{{ errors.user_position[0] }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

       <!-- <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header bg-dark text-info">
                        Personal Information
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="pseudo" class="col-md-4 col-form-label text-md-right">Pseudo
                                <small class="passwordHelpInline text-info">*</small>
                            </label>

                            <div class="col-md-6">
                                <input id="pseudo" type="text" class="form-control" v-model="fields.pseudo" name="pseudo" v-bind:class="{'is-invalid': errors.pseudo} " autocomplete="pseudo" >

                                <span class="invalid-feedback" v-if="errors && errors.pseudo" role="alert">
                                    <strong>{{ errors.pseudo[0] }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-right">Phone number
                                <small class="text-info phoneHelpInline">*</small>
                            </label>

                            <div class="col-md-6">
                                <input id="phone_number" type="text" class="form-control" v-model="fields.phone_number" v-bind:class="{'is-invalid': errors.phone_number} " name="phone_number"
                                         autocomplete="phone_number" >

                                <span class="invalid-feedback" v-if="errors && errors.phone_number" role="alert">
                                    <strong>{{ errors.phone_number[0] }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address
                                <small id="passwordHelpInline" class="text-info">*</small>
                            </label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" v-bind:class="{'is-invalid': errors.email} " name="email"  v-model="fields.email"  autocomplete="email">

                                <span class="invalid-feedback" v-if="errors && errors.email" role="alert">
                                    <strong>{{ errors.email[0] }}</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-4">
                                <input type="checkbox" class="form-check-input" id="create-account" v-model="fields.create_account" name="create_account">
                                <label class="form-check-label" for="create-account">I want my account to be created</label>
                            </div>
                            <div class="col-md-6 offset-4">
                                <input type="checkbox" class="form-check-input" id="hide-number" v-model="fields.create_account" name="hide_number">
                                <label class="form-check-label" for="hide-number">Hide the phone number in the ad</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div> -->

        <!-- <small id="passwordHelpInline" class="text-info">* required fields</small> -->
        <div class="form-group text-center mt-3" v-if="fields.type_of_user == 0">
            <div class="">
                <button type="submit" class="btn btn-primary legal-conditions-btn">
                    Submit
                </button>
                <button type="submit" class="btn btn-danger legal-conditions-btn">
                    Cancel
                </button>
            </div>
        </div>

    </form>
</template>


<script>

    import FormMixin from "../FormMixin";
    
    export default {
        mixins: [ FormMixin ],

    }
    

</script>


<!--  @import "~vue-toastr/src/vue-toastr.scss" -->

<style lang="scss" scoped>
    @import "~vue-toastr/src/vue-toastr.scss";
    .uploader {
        width: 100%;
        background: #2196F3;
        color: #fff;
        padding: 40px 15px;
        text-align: center;
        border-radius: 10px;
        border: 3px dashed #fff;
        font-size: 20px;
        position: relative;

        &.dragging {
            background: #fff;
            color: #2196F3;
            border: 3px dashed #2196F3;

            .file-input label {
                background: #2196F3;
                color: #fff;
            }
        }

        i {
            font-size: 85px;
        }

        .file-input {
            width: 200px;
            margin: auto;
            height: 68px;
            position: relative;

            label,
            input {
                background: #fff;
                color: #2196F3;
                width: 100%;
                position: absolute;
                left: 0;
                top: 0;
                padding: 10px;
                border-radius: 4px;
                margin-top: 7px;
                cursor: pointer;
            }

            input {
                opacity: 0;
                z-index: -2;
            }
        }

        .images-preview {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;

            .img-wrapper {
                width: 160px;
                display: flex;
                flex-direction: column;
                margin: 10px;
                height: 150px;
                justify-content: space-between;
                background: #fff;
                box-shadow: 5px 5px 20px #3e3737;

                img {
                    max-height: 105px;
                }
            }

            .details {
                font-size: 12px;
                background: #fff;
                color: #000;
                display: flex;
                flex-direction: column;
                align-items: self-start;
                padding: 3px 6px;

                .name {
                    overflow: hidden;
                    height: 18px;
                }
            }
        }

        .upload-control {
            position: absolute;
            width: 100%;
            background: #fff;
            top: 0;
            left: 0;
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            padding: 10px;
            padding-bottom: 4px;
            text-align: right;

            button, label {
                background: #2196F3;
                border: 2px solid #03A9F4;
                border-radius: 3px;
                color: #fff;
                font-size: 15px;
                cursor: pointer;
            }

            label {
                padding: 2px 5px;
                margin-right: 10px;
            }
        }
    }
</style>
