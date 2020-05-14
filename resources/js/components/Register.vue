<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <form method="POST" :action="url" @submit.prevent="store">
                            <input type="hidden" :value="csrf" name="_token"/>
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">I am</label>
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type_of_user" required id="professional" value="1" v-bind:class="{'is-invalid': errors.type_of_user}" v-model="fields.type_of_user">
                                        <label class="form-check-label" for="professional">Professional</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="type_of_user" v-model="fields.type_of_user" id="particular" required value="0" v-bind:class="{'is-invalid': errors.type_of_user}">
                                        <label class="form-check-label" for="particular">Particular</label>
                                    </div>
                                    <span class="invalid-feedback" v-if="errors && errors.type_of_user" role="alert">
                                        <strong>{{ errors.type_of_user[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="firstName" class="col-md-4 col-form-label text-md-right">First Name
                                    <small id="first_name" class="text-info">*</small>
                                </label>

                                <div class="col-md-6">
                                    <input id="firstName" type="text" class="form-control" v-model="fields.first_name" v-bind:class="{'is-invalid': errors.first_name}" name="first_name" value="" required autocomplete="first_name" autofocus>

                                    <span class="invalid-feedback" v-if="errors && errors.first_name" role="alert">
                                        <strong>{{ errors.first_name[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name
                                    <small id="l_name" class="text-info">*</small>
                                </label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control" v-model="fields.last_name" v-bind:class="{'is-invalid': errors.last_name}" name="last_name" value="" required autocomplete="last_name" autofocus>

                                    <span class="invalid-feedback" v-if="errors && errors.last_name" role="alert">
                                        <strong>{{ errors.last_name[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="department" class="col-md-4 col-form-label text-md-right">Department
                                    <small id="department_info" class="text-info">*</small>
                                </label>

                                <div class="col-md-6">
                                    <input id="department" type="text" class="form-control" v-model="fields.department" v-bind:class="{'is-invalid': errors.department}" name="department" value="" required autocomplete="department" autofocus>

                                    <span class="invalid-feedback" v-if="errors && errors.department" role="alert">
                                        <strong>{{ errors.department[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address
                                    <small id="mail" class="text-info">*</small>
                                </label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" v-model="fields.email" v-bind:class="{'is-invalid': errors.email}" value="" required autocomplete="email">
                                    <small id="emailHelp" class="form-text text-info">We'll never share your email with anyone else.</small>
                                    <span class="invalid-feedback" v-if="errors && errors.email" role="alert">
                                        <strong>{{ errors.email[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div id="professional-fields" v-if="fields.type_of_user == '1'">
                                <div class="form-group row">
                                    <label for="siret" class="col-md-4 col-form-label text-md-right">SIRET
                                        <small id="siret_mandatory" class="text-info">*</small>
                                    </label>

                                    <div class="col-md-6">
                                        <input id="siret" type="text" class="form-control" name="siret" value="" v-model="fields.siret" v-bind:class="{'is-invalid': errors.siret}">
                                        <small id="siretHelp" class="text-info">Must be 14 characters long.</small>
                                        <span class="invalid-feedback" v-if="errors && errors.siret" role="alert">
                                            <strong>{{ errors.siret[0] }}</strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="breeder_name" class="col-md-4 col-form-label text-md-right">Breeding Name
                                        <small id="password_mandatory" class="text-info">*</small>
                                    </label>

                                    <div class="col-md-6">
                                        <input id="breeder_name" type="text" class="form-control" name="breeder_name"  v-model="fields.breeder_name" v-bind:class="{'is-invalid': errors.breeder_name}" value="">

                                        <span class="invalid-feedback" v-if="errors && errors.breeder_name" role="alert">
                                            <strong>{{ errors.breeder_name[0] }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password
                                    <small id="passwordHelpInline" class="text-info">*</small>
                                </label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control"  v-model="fields.password" v-bind:class="{'is-invalid': errors.password}" aria-describedby="passwordHelpInline" name="password" required autocomplete="new-password">
                                    <small id="password_info" class="text-info">
                                        Must be 8-20 characters long.
                                    </small>
                                    <span class="invalid-feedback" v-if="errors && errors.password" role="alert">
                                        <strong>{{ errors.password[0] }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" v-model="fields.password_confirmation" v-bind:class="{'is-invalid': errors.password_confirmation}" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" v-model="fields.legal_conditions" v-bind:class="{'is-invalid': errors.legal_conditions}" id="legal-conditions" name="legal_conditions">
                                <label class="form-check-label" for="legal-conditions">"I accept the <a href="">General Terms and Conditions of Sale</a> and the <a href="" >General Terms and Conditions of Use</a>"</label>
                                <span class="invalid-feedback" v-if="errors && errors.legal_conditions" role="alert">
                                    <strong>{{ errors.legal_conditions[0] }}</strong>
                                </span>
                            </div>
                            <small id="mandatory_fields" class="text-info">* required fields</small>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" :disabled="isDisabled" class="btn btn-primary legal-conditions-btn">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import register from "../register";
    export default {
        mixins: [ register ],

    }
</script>


<style scoped>

</style>
